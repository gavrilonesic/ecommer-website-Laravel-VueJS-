<?php

namespace App\Http\Middleware;

use App\Admin;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        if (!is_array($permissions)) {
            $current_args = $request->route()->parameters();
            $current_parameter = array_shift($current_args);

            if (strpos($permissions, '{parameter}') !== false) {
                // here the $caps become 'manage_{taxonomy}'
                $permissions = str_replace( '{parameter}', $current_parameter, $permissions );
            }

            $permissions = explode('|', $permissions);
        }
        $permissions = is_array($permissions) ? $permissions : explode('|', $permissions);

        if (self::checkPermission($permissions)) {
            return $next($request);
        }

        if ($request->ajax()) {
            return \Response::view('admin.error.access_denied_modal');
        }
        return \Response::view('admin.error.access_denied');
    }

    public static function checkPermission($permissionKey = [], $guard = 'admin')
    {
        if (Auth::guard($guard)->check() && Auth::guard($guard)->user()->role_id == config('constants.ADMIN_ROLE')) {
            return true;
        }

        $permissions = Admin::getPermissions(Auth::guard($guard)->user()->id);

        if (is_array($permissionKey) && count(array_intersect($permissionKey, $permissions)) !== 0) {
            return true;
        }

    }
}
