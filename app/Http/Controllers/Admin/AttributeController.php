<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\AttributeOption;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\AttributeRequest;
use Illuminate\Http\Request;
use SEO;
use Session;

class AttributeController extends AdminController
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
    public $activeSidebarSubMenu = 'attributes';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.attributes'));

        $attributes = Attribute::orderBy('id', 'DESC')
            ->get();

        return view('admin.attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        SEO::setTitle(__('messages.add_attribute'));
        if ($request->ajax()) {
            return view('admin.product.add_attribute');
        }

        return view('admin.attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request)
    {
        try {
            $attribute        = Attribute::create($request->all());
            $attributeOptions = $request->attribute_options;
            if (!empty($attributeOptions)) {
                foreach ($attributeOptions as $key => $option) {
                    if (empty($option['option'])) {
                        unset($attributeOptions[$key]);
                    }
                }
                $attribute->attributeOptions()->createMany($attributeOptions);
            }

            if ($request->ajax()) {
                return json_encode($attribute);
            }
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.attribute')]));

            return redirect()->route('attribute.index');
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.attribute')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        SEO::setTitle(__('messages.view_brand'));

        return view('admin.attribute.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        SEO::setTitle(__('messages.edit_attribute'));

        return view('admin.attribute.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        try {
            $attribute->update($request->all());

            if (!empty($request->attribute_options)) {
                $attributeOptionsId = [];
                foreach ($request->attribute_options as $option) {
                    if (!empty($option['id'])) {
                        $attributeOptionsId[] = $option['id'];
                        AttributeOption::where('id', $option['id'])->update($option);
                    } else if (!empty($option['option'])) {
                        $attributeOptions     = $attribute->attributeOptions()->create($option);
                        $attributeOptionsId[] = $attributeOptions->id;
                    }
                }
                if (!empty($attributeOptionsId)) {
                    $attribute->attributeOptions()->whereNotIn('id', $attributeOptionsId)->delete();
                }
            }

            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.attribute')]));

            return redirect()->route('attribute.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.attribute')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        try {
            $attribute->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.attribute')]));

            return redirect()->route('attribute.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.attribute')]));

            return redirect()->route('attribute.index');
        }
    }
}
