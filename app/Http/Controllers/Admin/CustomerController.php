<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\CustomerGroup;
use App\DataTables\CustomersDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\CustomerEditRequest;
use App\Http\Requests\CustomerRequest;
use App\User;
use App\UserAddress;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use SEO;
use Session;
use Auth;

class CustomerController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'users';

    /**
     * Active sidebar sub menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'customers';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomersDataTable $dataTable)
    {
        SEO::setTitle(__('messages.customers'));
        return $dataTable->render('admin.customer.index');
        //  $customers = User::with(['userAddress'])->orderBy('created_at', 'DESC')->get();

        // return view('admin.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_customer'));
        $customerGroups = CustomerGroup::pluck('name', 'id');
        $countries      = Country::pluck('name', 'id');
        return view('admin.customer.create', compact('customerGroups', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {

        try {

            return DB::transaction(function () use ($request) {
                if (!empty($request->get('password'))) {
                    $request->merge([
                        'password' => Hash::make($request->get('password')),
                    ]);
                }
                $customer = User::create($request->all());

                if (!empty($request->customer_address)) {
                    $customerAddress = $request->customer_address;
                    $customer->userAddress()->create($customerAddress);
                }
                Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.customer')]));

                return redirect()->route('customer.index');
            });
        } catch (\Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.customer')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer, Request $request)
    {
        SEO::setTitle(__('messages.view_customer'));
        return view('admin.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        $customerGroups = CustomerGroup::pluck('name', 'id');
        $countries      = Country::pluck('name', 'id');
        $customer       = User::with(['userAddress', 'userAddress.state', 'userAddress.country'])->where('id', $customer->id)->orderBy('id', 'DESC')->first();

        return view('admin.customer.edit', compact('customer', 'customerGroups', 'countries'));
    }

    public function addressEdit(UserAddress $address)
    {
        $customerGroups = CustomerGroup::pluck('name', 'id');
        $countries      = Country::pluck('name', 'id');
        $address->with(['userAddress', 'userAddress.state', 'userAddress.country']);

        return view('admin.customer.edit_address', compact('address', 'customerGroups', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerEditRequest $request, User $customer)
    {
        try {
            return DB::transaction(function () use ($request, $customer) {
                if (!empty($request->get('password'))) {
                    $request->merge([
                        'password' => Hash::make($request->get('password')),
                    ]);
                }
                $customer->update($request->all());

                if (!empty($request->customer_address)) {
                    $customerAddressId = [];
                    foreach ($request->customer_address as $address) {
                        if (empty($address['address_name'])) {
                            $address['address_name'] = $address['first_name'] . ' ' . $address['last_name'];
                        }
                        if (!empty($address['id'])) {
                            $customer->userAddress()->where('id', $address['id'])->update($address);
                        } else {
                            $address['id'] = $customer->userAddress()->create($address)->id;
                        }
                        $customerAddressId[] = $address['id'];
                    }
                }
                Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.customer')]));

                return redirect()->route('customer.index');
            });
        } catch (\Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.customer')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    public function addressUpdate(AddressRequest $request, UserAddress $address)
    {
        try {
            return DB::transaction(function () use ($request, $address) {
                $data = $request->all();
                if (!isset($data['state_id'])) {
                    $data['state_id'] = null;
                } elseif (!isset($data['state_name'])) {
                    $data['state_name'] = null;
                }

                $address->update($data);
                Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.customer')]));

                return redirect()->back();
            });
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.addresses')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    public function addressCreate(AddressRequest $request, User $customer)
    {

        try {
            return DB::transaction(function () use ($request, $customer) {
                $customer->userAddress()->create($request->all());
                Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.addresses')]));

                return redirect()->back();
            });
        } catch (\Exception $e) {
            Session::flash('error', __('messages.record_not_added_success_msg', ['name' => __('messages.addresses')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        try {
            $customer->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.customer')]));

            return redirect()->route('customer.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.customer')]));

            return redirect()->route('customer.index');
        }
    }

    public function addressdestroy(UserAddress $address)
    {
        try {

            $address->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.addresses')]));

            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.addresses')]));

            return redirect()->back();
        }
    }

    /**
     * send reset password link to user.
     *
     * @param  \App\User  $customer
     * @return \Illuminate\Http\Response
     */
    public function ResetPasswordLink(Request $request, User $customer)
    {
        $response = $this->broker()->sendResetLink(
            ['id' => $customer->id]
        );

        if ($response == Password::RESET_LINK_SENT) {
            Session::flash('success', __('messages.reset_password_link_send_successfully'));
        } else {
            Session::flash('error', __('messages.reset_password_link_not_send', ['name' => __('messages.customer')]));
        }

        return redirect()->route('customer.index');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('users');
    }

    public function loginAsUser(User $customer)
    {
        Auth::guard('web')->login($customer);
        return redirect()->route('home');
    }
}
