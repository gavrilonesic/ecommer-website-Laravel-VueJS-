<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\AttributeCategory;
use App\Brand;
use App\Category;
use App\CustomField;
use App\DataTables\ProductsDataTable;
use App\File;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductSku;
use App\Video;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use SEO;
use Session;

class ProductController extends AdminController
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
    public $activeSidebarSubMenu = 'products';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductsDataTable $dataTable)
    {
        SEO::setTitle(__('messages.products'));

        return $dataTable->render('admin.product.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(ProductsDataTable $dataTable)
    {
        SEO::setTitle(__('messages.advance_search'));
        $brands      = Brand::brandList();
        $categories  = Category::allCategoryList();
        $attributes  = Attribute::attributeList();
        $customField = CustomField::customFieldList()->toJson();
        return $dataTable->render('admin.product.search', compact('brands', 'attributes', 'categories', 'customField'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_product'));
        $response = $this->getAllList();
        extract($response);

        $status = [
            'Unavailable',
            'Available'
        ];

        return view('admin.product.create', compact('brands', 'attributes', 'categories', 'customField', 'products', 'videos', 'status'));
    }

    public function getAllList($productId = null)
    {
        return [
            'brands'      => Brand::brandList(),
            'categories'  => Category::treeList(),
            'attributes'  => Attribute::attributeList(),
            'customField' => CustomField::customFieldList()->toJson(),
            'products'    => Product::productList($productId),
            'videos'      => Video::with('medias')->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $response = $this->createOrUpdate($request);
        if ($response) {
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.product')]));

            return redirect()->route('product.index');
        } else {

            return redirect()->back()->withInput($request->all());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        SEO::setTitle(__('messages.edit_product'));
        $product = Product::with(['relatedProducts' => function ($query) {
            $query->select('product_id', 'related_product_id');
        }, 'productSkus' => function ($query) {
            $query->with(['productSkuValues' => function ($query) {
                $query->with('attributeOptions');
            }, 'medias']);
        }, 'categories' => function ($query) {
            $query->select('category_id', 'product_id');
        }])->find($request->product);

        $status = [
            'Unavailable',
            'Available'
        ];

        $response = $this->getAllList($request->product);
        extract($response);

        return view('admin.product.edit', compact('product', 'brands', 'attributes', 'categories', 'customField', 'products', 'videos', 'status'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $response = $this->createOrUpdate($request, $product);
        if ($response) {
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.product')]));

            return redirect()->route('product.index');
        } else {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.product')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.product')]));

            // return redirect()->route('product.index');
            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.product')]));
            return redirect()->back()->withInput();
            // return redirect()->route('product.index');
        }
    }

    /**
     * Prepate matrix html table
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createMatrix(Request $request)
    {
        $attributes = Attribute::with('attributeOptions')->whereIn('id', $request->attribute)->get();
        foreach ($attributes as $attribute) {
            //$attributeMatrix[$attribute->id] = $attribute->attributeOptions->pluck('option', 'id')->toArray();
            $attributeMatrix[$attribute->id] = $attribute->attributeOptions->toArray();
        }

        $attributeMatrix = $this->preparMatrixArray($attributeMatrix);
        return view('admin.product.create_matrix', compact('attributeMatrix'));
    }

    public function preparMatrixArray($input)
    {
        $results = [];

        foreach ($input as $key => $values) {
            if (empty($values)) {
                continue;
            }

            if (empty($results)) {
                foreach ($values as $value) {
                    $results[] = [$key => $value];
                }
            } else {
                $append = [];

                foreach ($results as &$result) {
                    $result[$key] = array_shift($values);
                    $copy         = $result;

                    foreach ($values as $item) {
                        $copy[$key] = $item;
                        $append[]   = $copy;
                    }
                    array_unshift($values, $result[$key]);
                }

                $results = array_merge($results, $append);
            }
        }

        return $results;
    }

    public function createOrUpdate($request, $product = null)
    {
        try {
            return DB::transaction(function () use ($request, $product) {

                $requestData = $productData = $request->all();

                if (isset($requestData['save_as_draft'])) {
                    $productData['status'] = config('constants.SAVE_AS_DRAFT');
                } else {
                    $productData['status'] = config('constants.STATUS.STATUS_ACTIVE');
                }

                $productData['mark_as_new']      = $requestData['mark_as_new'] ?? 0;
                $productData['mark_as_featured'] = $requestData['mark_as_featured'] ?? 0;

                if (!isset($requestData['inventory_tracking'])) {
                    $productData['inventory_tracking']    = 0;
                    $productData['inventory_tracking_by'] = 0;
                }
                if ($productData['inventory_tracking_by'] == 1 || $productData['inventory_tracking'] == 0) {
                    $productData['quantity'] = $productData['low_stock'] = 0;
                }
                unset($productData['category_id']);
                unset($productData['attribute_id']);

                if (!empty($product)) {
                    if (empty($requestData['video_id'])) {
                        $productData['video_id'] = null;
                    }
                    if (empty($requestData['youtube_url'])) {
                        $productData['youtube_url'] = null;
                    }
                    $product->update($productData);
                } else {
                    $product = Product::create($productData);
                }

                $oldAttributes = [
                    'categories' => $product->category_id,
                    'attributes' => $product->attribute_id,
                ];

                $attributeData = [
                    'attributes'       => [],
                    'attribute_option' => [],
                ];
                $customFields = [];
                if (!empty($requestData['category_id'])) {
                    $product->categories()->detach();
                    $product->categories()->sync($requestData['category_id']);
                }

                $product->include_in_feed = isset($requestData['include_in_feed']) ? TRUE : FALSE;
                $product->status = $requestData['status'];

                // Upload Product Images
                $productImages = $requestData['product_images'] ?? "";
                $imageOrder    = 1;
                if (!empty($productImages)) {
                    foreach ($productImages['description'] as $key => $description) {
                        $defaultImage = ($requestData['default_image'] == $key) ? true : false;
                        if (!empty($productImages['media_id'][$key])) {
                            $media = $product->getMedia('product')->find($productImages['media_id'][$key]);

                            $customProperties                  = $media->custom_properties;
                            $customProperties['default_image'] = $defaultImage;
                            $customProperties['description']   = $description;
                            $media->update(['order_column' => $imageOrder, 'custom_properties' => $customProperties]);
                        } else {
                            if (!empty($productImages['url'][$key])) {
                                $image = $product->addMediaFromUrl($productImages['image'][$key]);
                            } else {
                                $image = $product->addMediaFromBase64($productImages['image'][$key])->usingFileName($productImages['file_name'][$key]);
                            }
                            $media                           = $image->withCustomProperties(['default_image' => $defaultImage, 'description' => $description])->toMediaCollection('product', 'products');
                            $productImages['media_id'][$key] = $media->id;
                            $media->order_column             = $imageOrder;
                            $media->save();
                        }
                        $imageOrder++;
                    }
                    if (!empty($productImages['media_id'])) {
                        $mediaDelete = $product->getMedia('product')->whereNotIn('id', $productImages['media_id']);
                    }
                } else {
                    $mediaDelete = $product->getMedia('product');
                }

                if ($mediaDelete->count() > 0) {
                    foreach ($mediaDelete as $key => $image) {
                        $image->delete();
                    }
                }

                //Insert attribute sku and sku values
                $attributes = $requestData['attribute'] ?? "";
                if (!empty($attributes)) {
                    $attributeData['attribute_option'] = [];
                    foreach ($attributes as $key => $attribute) {
                        $attribute['include_in_feed'] = isset($attribute['include_in_feed']) ? TRUE : FALSE;
                        $attribute['hazmat_type'] = $attribute['hazmat_type'] ?? ProductSku::HAZMAT_TYPE_NONE;
                        $attribute['is_hazmat'] = $attribute['hazmat_type'] == ProductSku::HAZMAT_TYPE_NONE ? false : true;
                        $attribute['is_shipping_by_air'] = isset($attribute['is_shipping_by_air']) ? true : false;
                        
                        $attribute['price'] = $attribute['price'] ?? $product->price;
                        if ($productData['inventory_tracking_by'] != 1) {
                            $attribute['quantity'] = $attribute['low_stock'] = 0;
                        }

                        if(!isset($attribute['sku_values'])){
                            $attribute['sku_values'] = "[]";
                        }

                        $skuValues = json_decode($attribute['sku_values'], true);
                        $skuValues = array_map(function ($sku) use ($product) {
                            return $sku + ['product_id' => $product->id];
                        }, $skuValues);
                        $attribute['attribute_option_id'] = json_encode(array_map(function ($skuValues) {
                            return $skuValues['attribute_option_id'];
                        }, $skuValues));
                        if (!empty($attribute['id'])) {
                            // Update
                            $productSku = $product->productSkus()->find($attribute['id']);
                            $productSku->update($attribute);
                            if (!empty($attribute['image'])) {
                                $media      = $productSku->getMedia('product')->first();
                                $mediaImage = $productSku->addMedia($attribute['image'])->toMediaCollection('product', 'products');
                                if (!empty($media)) {
                                    $media->delete();
                                }
                            }
                        } else {
                            //create
                            $productSku = $product->productSkus()->create($attribute);
                            if (!empty($attribute['image'])) {
                                $mediaImage = $productSku->addMedia($attribute['image'])->toMediaCollection('product', 'products');
                            }
                            $productSku->productSkuValues()->createMany($skuValues);
                        }
                        $attributesId[]                    = $productSku->id;
                        $attributeData['attribute_option'] = array_merge($attributeData['attribute_option'], array_column($skuValues, 'attribute_option_id'));
                    }
                    $attributeData['attribute_option'] = array_values(array_unique($attributeData['attribute_option']));
                } else {
                    $product->productSkus()->delete();
                }
                if (!empty($attributesId)) {
                    $product->productSkus()->whereNotIn('id', $attributesId)->delete();
                }

                // Remove count from category filter
                if (!empty($oldAttributes['categories']) && !empty($oldAttributes['attributes'])) {
                    foreach ($oldAttributes['categories'] as $category) {
                        foreach ($oldAttributes['attributes'] as $att) {
                            if (!isset($attributeCategory)) {
                                $attributeCategory = AttributeCategory::orWhere(function ($q) use ($category, $att) {
                                    $q->where('category_id', $category)
                                        ->Where('attribute_id', $att);
                                });
                            } else {
                                $attributeCategory = $attributeCategory->orWhere(function ($q) use ($category, $att) {
                                    $q->where('category_id', $category)
                                        ->Where('attribute_id', $att);
                                });
                            }
                        }
                    }
                    $attributeCategory->update(['product_count' => DB::raw('product_count - 1')]);
                }
                // Save Category Filter Data
                if (!empty($requestData['category_id']) && !empty($requestData['attribute_id'])) {
                    foreach ($requestData['category_id'] as $key => $category) {
                        $category = Category::find($category);
                        $sync     = [];
                        foreach ($requestData['attribute_id'] as $key => $attribute) {
                            $sync[$attribute] = ['product_count' => DB::raw('product_count + 1')];
                        }
                        $category->attributes()->detach();
                        $category->attributes()->sync($sync);
                    }
                }

                // Save related product
                if (!empty($requestData['related_product'])) {
                    $product->relatedProducts()->detach();
                    // dd($requestData['related_product']);
                    $product->relatedProducts()->sync($requestData['related_product'], false);
                } else {
                    $product->relatedProducts()->detach();
                }

                //Save custom fields
                if (!empty($requestData['custom_fields']['name'])) {
                    foreach ($requestData['custom_fields']['name'] as $key => $customField) {
                        if (!empty($customField) && !empty($requestData['custom_fields']['value'][$key])) {
                            CustomField::firstOrCreate(['name' => $customField]);
                            $customFields[$customField][] = $requestData['custom_fields']['value'][$key];
                        }
                    }
                }

                $product->custom_fields = $customFields;
                $product->category_id   = !empty($requestData['category_id']) ? $requestData['category_id'] : [];
                $product->attribute_id  = !empty($attributeData['attribute_option']) ? $requestData['attribute_id'] : [];
                // $product->video_id        = !empty($requestData['video_id']) ? $requestData['video_id'] : [];
                $product->attribute_option_id = $attributeData['attribute_option'];
                $product->save();

                return true;
            });
        } catch (\Exception $e) {
            echo $e->getMessage();exit;
            Session::flash('error', $e->getMessage());

            return false;
        }
    }

    /**
     * change product status.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function status(Product $product)
    {
        try {

            if ($product->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $product->status = config('constants.SAVE_AS_DRAFT');
                Session::flash('success', __('messages.record_save_as_draft_success_msg', ['name' => __('messages.product')]));
            } else {
                $product->status = config('constants.STATUS.STATUS_ACTIVE');
                Session::flash('success', __('messages.record_publish_success_msg', ['name' => __('messages.product')]));
            }
            $product->save();
            return redirect()->back();
            // return redirect()->route('product.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_status_not_updated_error_msg', ['name' => __('messages.product')]));
            return redirect()->back();
            // return redirect()->route('product.index');
        }
    }

    public function csv(File $file)
    {
        // File Read from media table
        if (empty($file->done_at)) {
            $file              = fopen($file->getMedia('file')[0]->getPath(), "r");
            $all_data          = $array          = array();
            $updateRecordCount = $newRecordCount = 0;
            $productList       = array_map('strtolower', Product::productList()->toArray());

            $i = 0;
            while (($data = fgetcsv($file, 1000, ",")) !== false) {
                if (!empty($data) && $i == 0) {
                    foreach ($data as $key => $value) {
                        if (strtolower(trim($value)) == 'id') {
                            $index = $key;
                        } else if (strtolower(trim($value)) == 'item type') {
                            $itemTypeIndex = $key;
                        }
                    }
                } else {
                    if (isset($itemTypeIndex) && strtolower(trim($data[$itemTypeIndex])) == 'product') {
                        if (!empty($productList) && isset($index) && !empty($productList[$data[$index]])) {
                            $updateRecordCount++;
                        } else {
                            $newRecordCount++;
                        }
                    }
                }
                $i++;
            }
        } else {
            return abort(404);
        }

        return view('admin.product.csv', compact('updateRecordCount', 'newRecordCount'));
    }

    public function execute(File $file)
    {
        //dispatch(new ProductImport($file));

        return redirect()->route('product.index');
    }

    public function export()
    {
        return (new \App\Exports\ProductExport)->download('export-products-csv.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportGoogleFeed()
    {
        return (new \App\Exports\GoogleFeedExport)->download('google-feed.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]); 
    }

    public function copyProductField(Request $request)
    {
        if ($request->ajax()) {
            if ($request->isMethod('GET')) {
                $products = Product::productList();

                return view('admin.product.copy_product_fields', compact('products'));
            } else if ($request->isMethod('POST')) {
                $product = Product::with(['relatedProducts' => function ($query) {
                    $query->select('product_id', 'related_product_id');
                }])->find($request->product)->toArray();
                $product['custom_fields'] = !empty($product['custom_fields']) ? json_decode($product['custom_fields']) : [];
                return json_encode($product);
            }
        }
    }
}
