<?php

namespace App\Http\Controllers\Front\Auth;

use App\Email;
use App\Http\Controllers\Front\FrontController;
use App\Http\Requests\CustomerRequest;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends FrontController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        if (!$request->ajax()) {
            $this->middleware('guest');
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(CustomerRequest $request)
    {
        $data = $request->all();
        $user = User::updateOrCreate([
            'email'    => $data['email'],
            'is_guest' => 1,
        ],
            ['first_name' => $data['first_name'],
                'last_name'   => $data['last_name'],
                'password'    => Hash::make($data['password']),
                'mobile_no'   => $data['mobile_no'],
                'is_guest'    => 0,
            ]);

        //email to new customer
        try {
            $placeHolders = [
                '[Customer Name]'  => $user->name ?? '',
                '[Customer Email]' => $user->email ?? '',
            ];
            Email::sendEmail('customer.registration', $placeHolders, $user->email ?? '');
        } catch (Exception $e) {

        }

        return redirect()->route('login')->with('success', __('messages.record_add_successfull_msg', ['name' => __('messages.registration')]));

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(RegistrationRequest $request)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('front.auth.register');
    }
}
