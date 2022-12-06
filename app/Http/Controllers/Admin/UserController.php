<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\UserRequest;
use App\Permission;
use Exception;
use File;
use Hash;
use Illuminate\Http\Request;
use SEO;
use Session;
use Spatie\MediaLibrary\Models\Media;

class UserController extends AdminController
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
    public $activeSidebarSubMenu = 'user';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.admin_users'));

        $users = Admin::where("id", "<>", config("constants.MASTER_ADMIN_ID"))
            ->orderBy('id', 'DESC')->with(['medias'])
            ->get();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_admin_user'));
        $permissions = Permission::with('childs')->where('parent_id', 0)->get();

        return view('admin.user.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            if (!empty($request->get('password'))) {
                $request->merge([
                    'password' => Hash::make($request->get('password')),
                ]);
            }
            $user = Admin::create($request->all());

            if (!empty($request->image)) {
                $user->addMediaFromRequest('image')->toMediaCollection('admin', 'admins');
            }

            if (!empty($request->permission_id)) {
                $user->permissions()->sync($request->permission_id);
            }
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.admin_user')]));

            return redirect()->route('user.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.admin_user')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $user)
    {
        SEO::setTitle(__('messages.view_admin_user'));

        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        SEO::setTitle(__('messages.edit_admin_user'));

        //$result = Admin::getPermissions($request->user);
        $user = Admin::with(['permissions' => function ($query) {
            $query->select('permission_id', 'admin_id');
        }])->find($request->user);
        $permissions = Permission::with('childs')->where('parent_id', 0)->get();

        return view('admin.user.edit', compact('user', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, Admin $user)
    {
        try {
            if (!empty($request->get('password'))) {
                $request->merge([
                    'password' => Hash::make($request->get('password')),
                ]);
            }
            $user->update($request->all());
            if (!empty($request->image)) {
                try {
                    $mediaItems = $user->getMedia('admin');
                    $user->addMediaFromRequest('image')->toMediaCollection('admin', 'admins');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.image_not_update"));

                    return redirect()->route('user.index');
                }
            }

            if (!empty($request->permission_id)) {
                $user->permissions()->sync($request->permission_id);
            } else {
                $user->permissions()->delete();
            }

            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.admin_user')]));

            return redirect()->route('user.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.admin_user')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $user)
    {
        try {
            $user->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.admin_user')]));

            return redirect()->route('user.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.admin_user')]));

            return redirect()->route('user.index');
        }
    }

    //deletes image from edit page if user wants to
    public function deleteimage(Admin $user,Request $request)
    {
        if (empty($request->type)) {
            abort(404);
        }
        try {
            $mediaItems = $user->getMedia($request->type);
            if ($mediaItems->count() > 0) {
                $mediaItems[0]->delete();
            }
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.image')]));
            return '1';
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.image')]));
            return '0';
        }
    }

}
