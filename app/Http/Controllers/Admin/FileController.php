<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Controllers\Admin\AdminController;
use DB;
use Exception;
use Illuminate\Http\Request;
use Session;

class FileController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'products';

    public $importType = [
        'categories' => [
            "popup_title"    => "import_categories",
            "redirect_route" => "category.csv",
            "sample_csv"     => "categories_sample.csv",
        ],
        'products'   => [
            "popup_title"    => "import_products",
            "redirect_route" => "product.csv",
            "sample_csv"     => "products_sample.csv",
        ],
    ];

    /**
     * Import resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $popupDetail = $this->importType[$request->importType];

        return view('admin.file.import', compact('popupDetail'));
    }

    public function csvUpload(Request $request)
    {

        // Upload file in media library
        try {
            return DB::transaction(function () use ($request) {
                $file = \App\File::create([
                    'type' => $request->importType,
                ]);
                $file->addMediaFromRequest('file')->toMediaCollection('file', 'files');

                return redirect()->route($this->importType[$request->importType]['redirect_route'], ['file' => $file->id]);
            });
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());

            return redirect()->back();
        }

    }
}
