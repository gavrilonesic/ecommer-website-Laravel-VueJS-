<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Setting;
use File;
use Illuminate\Http\Request;
use Session;

class SettingController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'settings';

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->activeSidebarSubMenu = $request->page;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = str_replace('-', '_', $request->page);

        return view('admin.setting.index', compact('page'));
    }

    public function store(Request $request)
    {

        $page  = str_replace('-', '_', $request->page);
        $rules = Setting::getValidationRules($page);
        $this->validate($request, $rules);

        try {
            $requestData = $request->all();

            $validSettings = array_keys($rules);
            foreach (config("setting_fields.$page.elements") as $field) {
                if (isset($requestData[$field['name']])) {
                    Setting::add($field['name'], $requestData[$field['name']], Setting::getDataType($field['name']));
                } else {
                    Setting::where('name', $field['name'])->delete();
                }
                if ($field['name'] == 'robots_txt') {
                    File::put(public_path('robots.txt'), $requestData[$field['name']]);
                }

            }

            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __("messages.$page")]));
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __("messages.$page")]));

            return redirect()->back();
        }
    }
}
