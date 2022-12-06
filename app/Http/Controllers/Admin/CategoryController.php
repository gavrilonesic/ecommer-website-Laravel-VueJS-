<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\File;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\CategoryRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use SEO;
use Session;

class CategoryController extends AdminController
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
    public function index()
    {
        SEO::setTitle(__('messages.categories'));

        $categories = Category::orderBy('id', 'DESC')
            ->with(['parent', 'productsCount','medias' => function ($query) {
                $query->where('collection_name', 'category');
            }])->withCount('inquiry')
            ->get();
            // dd($categories);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_category'));
        $categories = Category::treeList();

        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try {
            $requestData = $request->all();
            if ($requestData['parent_id']) {
                $parent               = Category::find($requestData['parent_id']);
                $requestData['level'] = $parent->level + 1;
            } else {
                $requestData['level'] = 0;
            }

            $category = Category::create($requestData);
            if (!empty($request->image)) {
                $category->addMediaFromRequest('image')->toMediaCollection('category', 'categories');
            }
            if (!empty($request->logo)) {
                $category->addMediaFromRequest('logo')->toMediaCollection('logo', 'categoryLogo');
            }

            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.category')]));

            return redirect()->route('category.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.category')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        SEO::setTitle(__('messages.view_category'));

        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        SEO::setTitle(__('messages.edit_category'));
        $categories = Category::treeList();
        return view('admin.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $requestData = $request->all();
            if ($category->parent_id != $requestData['parent_id']) {
                if (!empty($requestData['parent_id'])) {
                    $parent               = Category::find($requestData['parent_id']);
                    $requestData['level'] = $parent->level + 1;
                } else {
                    $requestData['level'] = 0;
                }
                self::updateChild([$category->id], $requestData['level']);
            }

            $category->update($requestData);
            if (!empty($request->image)) {
                try {
                    $mediaItems = $category->getMedia('category');
                    $category->addMediaFromRequest('image')->toMediaCollection('category', 'categories');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.image_not_update"));

                    return redirect()->route('category.index');
                }

            }
            if (!empty($request->logo)) {
                try {
                    $mediaItems = $category->getMedia('logo');
                    $category->addMediaFromRequest('logo')->toMediaCollection('logo', 'categoryLogo');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.logo_not_update"));

                    return redirect()->route('category.index');
                }

            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.category')]));

            return redirect()->route('category.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.category')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    public static function updateChild($categoryId, $level)
    {
        if (!empty($categoryId)) {
            $update = Category::whereIn('parent_id', $categoryId)->update(['level' => $level + 1]);
            if ($update > 0) {
                $categoryId = Category::whereIn('parent_id', $categoryId)->pluck('id', 'id')->toArray();
                self::updateChild($categoryId, $level + 1);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.category')]));

            return redirect()->route('category.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.category')]));

            return redirect()->route('category.index');
        }
    }

    /**
     * change category status.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function status(Category $category)
    {
        try {

            if ($category->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $category->status = config('constants.STATUS.STATUS_INACTIVE');
            } else {
                $category->status = config('constants.STATUS.STATUS_ACTIVE');
            }
            $category->save();

            Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.category')]));

            return redirect()->route('category.index');
        } catch (Exception $e) {

            Session::flash('error', __('messages.record_status_not_updated_error_msg', ['name' => __('messages.category')]));

            return redirect()->route('category.index');
        }
    }

    public function csv(File $file)
    {
        // File Read from media table
        if (empty($file->done_at)) {
            $file              = fopen($file->getMedia('file')[0]->getPath(), "r");
            $all_data          = $array          = array();
            $updateRecordCount = $newRecordCount = 0;
            $categoryList      = Category::pluck('name', 'id')->toArray();
            $categoryList      = array_map('strtolower', $categoryList);
            $i                 = $index                 = 0;
            while (($data = fgetcsv($file, 1000, ",")) !== false) {
                if (!empty($data) && $i == 0) {
                    foreach ($data as $key => $value) {
                        if (trim($value) == 'id') {
                            $index = $key;
                            break;
                        }
                    }
                } else {
                    if (!empty($categoryList) && !empty($categoryList[$data[$index]])) {
                        $updateRecordCount++;
                    } else {
                        $newRecordCount++;
                    }
                }
                $i++;
            }
        } else {
            return abort(404);
        }

        return view('admin.category.csv', compact('updateRecordCount', 'newRecordCount'));
    }

    public function execute(File $file)
    {
        $file->scheduled_at = Carbon::now();
        $file->save();
        Session::flash('success', __('messages.category_import_scheduled'));

        return redirect()->route('category.index');
    }

    public function export()
    {
        return (new \App\Exports\CategoryExport)->download('export-categories-csv.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }

    //deletes image from edit page if user wants to
    public function deleteimage(Category $category, Request $request)
    {
        if (empty($request->type)) {
            abort(404);
        }
        try {
            $mediaItems = $category->getMedia($request->type);
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
