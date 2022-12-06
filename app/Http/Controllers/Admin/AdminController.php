<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Current menu active in sidebar
     *
     * @var string
     */
    public $activeSidebarMenu = "";

    /**
     * Current sub-menu active in sidebar
     *
     * @var string
     */
    public $activeSidebarSubMenu = "";

    /**
     * set breadcrumbs
     *
     * @var string
     */
    public $breadcrumb = [];

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setupNavigation();
    }

    /**
     * Sets navigation data for sidebar
     *
     * @return void
     */
    protected function setupNavigation()
    {
        View::share('activeSidebarMenu', $this->activeSidebarMenu);
        View::share('activeSidebarSubMenu', $this->activeSidebarSubMenu);
        View::share('breadcrumb', $this->breadcrumb);
    }
}
