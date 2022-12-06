<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\File;
use App\Http\Controllers\Admin\AdminController;
use App\DataTables\CategoryInquiryDataTable;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Session;
use SEO;

class CategoryInquiryController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'products';

    /**
     * Active sidebar sub menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'categories';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryInquiryDataTable $dataTable)
    {
        SEO::setTitle(__('messages.advance_search'));
        $categories  = Category::allCategoryList();
        return $dataTable->render('admin.category.search', compact('categories'));
    }



}
