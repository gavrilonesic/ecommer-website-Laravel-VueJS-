<?php

namespace App\Jobs;

use App\Attribute;
use App\AttributeCategory;
use App\AttributeOption;
use App\Brand;
use App\Category;
use App\CustomField;
use App\File;
use App\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Log;

class ProductImport implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(File $file)
    {
        //php artisan queue:listen --tries=1 --timeout=0
        $this->file  = $file;
        $this->queue = 'productimport';

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file             = $this->file;
        $file->is_working = 1;
        $file->save();
        // DB::transaction(function () {
        $file = $this->file;
        //shell_exec("chmod -R 777 " . \Storage::disk('files')->getDriver()->getAdapter()->getPathPrefix());
        $file              = fopen($file->getMedia('file')[0]->getPath(), "r");
        $all_data          = $array          = array();
        $updateRecordCount = $newRecordCount = 0;

        $brands         = array_map('strtolower', Brand::brandList()->toArray());
        $categories     = array_map('strtolower', Category::pluck('name', 'id')->toArray());
        $attributesList = array_map('strtolower', Attribute::attributeList()->toArray());

        $attributeOptions = AttributeOption::select('id', 'option', 'attribute_id')->get()->groupBy('attribute_id')->toArray();

        $attributeOptions = array_map(function (&$value) {
            $val = [];
            foreach ($value as $key => $value) {
                $val[$value['id']] = strtolower($value['option']);
            }
            return $val;
        }, $attributeOptions);

        $customField = array_map('strtolower', CustomField::pluck('name', 'id')->toArray());
        $products    = array_map('strtolower', Product::productList()->toArray());

        $inventoryTrackingBy = [
            0 => "on the product level",
            1 => "on the attribute level",
        ];

        $fields          = ['name' => 'name', 'sku' => 'sku', 'brand_id' => 'brand', 'price' => 'default price', 'weight' => 'weight', 'depth' => 'depth', 'height' => 'height', 'width' => 'width', 'short_description' => 'short description', 'description' => 'description', 'mark_as_new' => 'mark as new', 'mark_as_featured' => 'mark as featured', 'page_title' => "page title", 'meta_tag_keywords' => 'meta keywords', 'meta_tag_description' => 'meta description', 'inventory_tracking' => 'inventory tracking', 'inventory_tracking_by' => 'inventory tracking by', 'quantity' => 'quantity', 'low_stock' => 'low stock', 'status' => 'product visible?'];
        $attributeFields = ['id' => 'id', 'name' => 'name', 'sku' => 'sku', 'price' => 'default price', 'weight' => 'weight', 'depth' => 'depth', 'height' => 'height', 'width' => 'width', 'quantity' => 'quantity', 'low_stock' => 'low stock'];
        $array           = [];
        while (($data = fgetcsv($file, 1000, ",")) !== false) {
            $productsData[] = $data;
        }

        foreach ($productsData as $i => $data) {
            if (!empty($data) && $i == 0) {
                foreach ($data as $key => $value) {
                    $array[strtolower(trim($value))] = trim($key);
                }
            } else {
                if (isset($array['item type']) && strtolower(trim($data[$array['item type']])) == 'product') {
                    DB::beginTransaction();
                    Log::info('commit Start');
                    $attributes = $productData = [];
                    if (isset($array['id']) && !empty($data[$array['id']])) {
                        $productData['id'] = $data[$array['id']];
                    }

                    foreach ($fields as $key => $value) {
                        if (isset($array[$value])) {
                            $productData[$key] = !empty($data[$array[$value]]) ? $data[$array[$value]] : "";
                        }
                    }
                    if (isset($array['description']) && !empty($data[$array['description']])) {
                        $productData['description'] = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $data[$array['description']]);
                    }
                    $productData['inventory_tracking_by'] = array_search(strtolower(trim($productData['inventory_tracking_by'])), $inventoryTrackingBy);
                    if (empty($productData['inventory_tracking']) || $productData['inventory_tracking'] == 0) {
                        $productData['inventory_tracking']    = 0;
                        $productData['inventory_tracking_by'] = 0;
                    }
                    if ($productData['inventory_tracking_by'] == 1 || empty($productData['inventory_tracking'])) {
                        $productData['quantity'] = $productData['low_stock'] = 0;
                    }

                    // Brand Id
                    if (!empty($productData['brand_id'])) {
                        $productData['brand_id'] = array_search(strtolower(trim($productData['brand_id'])), $brands);
                    }

                    // status
                    if (!empty($productData['status']) && strtolower(trim($productData['status'])) == "y") {
                        $productData['status'] = 1;
                    } else {
                        $productData['status'] = 0;
                    }

                    $productData['brand_id'] = $productData['brand_id'] ?? 0;
                    // Insert or update product
                    if (!empty($productData['id'])) {
                        $product = Product::find($productData['id']);
                        if (!empty($product)) {
                            $product->update($productData);
                        }
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

                    // Categories sync
                    $productData['category_id'] = $productData['attribute_id'] = [];
                    if (isset($array['categories']) && !empty($data[$array['categories']])) {
                        $productData['categories'] = explode(";", $data[$array['categories']]);
                        $ii                        = 0;
                        foreach ($productData['categories'] as $key => $category) {
                            if (!empty($category)) {
                                $category = explode("/", $category);
                                $parentId = 0;
                                foreach ($category as $categoryKey => $value) {
                                    if (empty(array_search(strtolower(trim($value)), $categories))) {
                                        $level = 0;
                                        if (!empty($parentId)) {
                                            $parentCategory = Category::find($parentId);
                                            $level          = $parentCategory->level + 1;
                                        }
                                        $cat = Category::create([
                                            'name'      => ucwords(strtolower(trim($value))),
                                            'parent_id' => $parentId,
                                            'level'     => $level,
                                        ]);
                                        $parentId             = $cat->id;
                                        $categories[$cat->id] = strtolower(trim($value));
                                    } else {
                                        $parentId = array_search(strtolower(trim($value)), $categories);
                                    }
                                    if (count($category) == $categoryKey + 1) {
                                        $categoryId[$ii++] = $parentId;
                                    }
                                }
                            }
                        }
                        $categoryId = array_values(array_unique($categoryId));
                        if (!empty($categoryId)) {
                            $product->categories()->sync($categoryId);
                            $productData['category_id'] = $categoryId;
                        }
                    }

                    // Upload Product Images
                    if (empty($productData['id'])) {
                        try {
                            if (isset($array['product image url - 1']) && !empty($data[$array['product image url - 1']])) {
                                $defaultImage = true;
                                for ($j = 1; $j > 0; $j++) {
                                    if (isset($array["product image url - $j"]) && !empty($data[$array["product image url - $j"]])) {
                                        $description = (isset($array["product image description - $j"]) && !empty($data[$array["product image description - $j"]]) ? $data[$array["product image description - $j"]] : '');

                                        //$defaultImage = (isset($array["product image default - $j"]) && !empty($data[$array["product image default - $j"]]) && strtolower(trim($data[$array["product image default - $j"]])) == 'yes' ? true : false);
                                        try {
                                            $product->addMediaFromUrl('http://generalchemicalcorp.mybigcommerce.com/product_images/' . $data[$array["product image url - $j"]])->withCustomProperties(['default_image' => $defaultImage, 'description' => $description])->toMediaCollection('product', 'products');
                                            $defaultImage = false;
                                        } catch (FileCannotBeAdded $e) {
                                            report($e);
                                        }
                                    } else {
                                        break;
                                    }
                                }
                            }
                        } catch (Exception $e) {
                            report($e);
                        }
                    }

                    // Save related product
                    if (isset($array['related product']) && !empty($data[$array['related product']])) {
                        $productData['related_product'] = explode(";", $data[$array['related product']]);
                        foreach ($productData['related_product'] as $key => $value) {
                            $relatedProduct[$key] = array_search(strtolower(trim($value)), $products);
                            if (empty($relatedProduct[$key])) {
                                unset($relatedProduct[$key]);
                            }
                        }
                        $relatedProduct = array_unique($relatedProduct);
                        if (!empty($categoryId)) {
                            $product->relatedProducts()->sync($relatedProduct);
                        }
                    } else {
                        $product->relatedProducts()->delete();
                    }

                    //Save custom fields
                    $customFields = [];
                    if (isset($array['custom fields']) && !empty($data[$array['custom fields']])) {
                        $productData['custom_fields'] = explode(";", $data[$array['custom fields']]);
                        foreach ($productData['custom_fields'] as $key => $customField) {
                            $customField = explode("=", $customField);
                            if (!empty($customField[0]) && !empty($customField[1])) {
                                CustomField::firstOrCreate(['name' => $customField[0]]);
                                $customFields[$customField[0]][] = $customField[1];
                            }
                        }
                    }
                    if (!isset($productsData[$i + 1]) || strtolower(trim($productsData[$i + 1][$array['item type']])) != 'sku') {
                        DB::commit();
                        Log::info('commit End');
                    }
                } else if (isset($array['item type']) && strtolower(trim($data[$array['item type']])) == 'sku') {
                    //Attribute Options
                    foreach ($attributeFields as $key => $value) {
                        $attributes[$i][$key] = (isset($array[$value]) && !empty($data[$array[$value]]) ? $data[$array[$value]] : "");
                        if ($key == 'price' && empty($attributes[$i][$key])) {
                            $attributes[$i][$key] = $product->price;
                        } else if ($key == 'name') {
                            $skuValues = [];
                            foreach (explode(";", $data[$array[$value]]) as $attributeKey => $attributeOption) {
                                $attributeOption = explode("=", $attributeOption);
                                if (!empty($attributeOption[0]) && !empty($attributeOption[1])) {
                                    $attributeId = array_search(strtolower(trim($attributeOption[0])), $attributesList);

                                    if (empty($attributeId)) {
                                        $attribute = Attribute::create([
                                            'name'   => $attributeOption[0],
                                            'option' => 'radio',
                                        ]);
                                        $attributeId                  = $attribute->id;
                                        $attributesList[$attributeId] = strtolower(trim($attributeOption[0]));
                                    }
                                    $optionKey = array_search(strtolower(trim($attributeOption[1])), $attributeOptions[$attributeId] ?? []);
                                    if (empty($optionKey)) {
                                        $option = AttributeOption::create([
                                            'attribute_id' => $attributeId,
                                            'option'       => $attributeOption[1],
                                        ]);
                                        $optionKey                                  = $option->id;
                                        $attributeOptions[$attributeId][$optionKey] = strtolower(trim($attributeOption[1]));
                                    }
                                    $skuValues[] = [
                                        'attribute_id'        => $attributeId,
                                        'attribute_option_id' => $optionKey,
                                    ];
                                    if (!in_array($attributeId, $productData['attribute_id'])) {
                                        $productData['attribute_id'][] = $attributeId;
                                    }
                                }
                            }
                            $attributes[$i]['sku_values'] = $skuValues;
                        }
                    }
                    $attributes[$i]['image'] = (isset($array['product image url - 1']) && !empty($data[$array['product image url - 1']]) ? $data[$array['product image url - 1']] : "");

                    if (!isset($productsData[$i + 1]) || strtolower(trim($productsData[$i + 1][$array['item type']])) != 'sku') {
                        //Insert attribute sku and sku values
                        if (!empty($attributes)) {
                            $attributeData['attribute_option'] = [];
                            foreach ($attributes as $key => $attribute) {
                                $attribute['price'] = $attribute['price'] ?? $product->price;
                                if ($productData['inventory_tracking_by'] != 1) {
                                    $attribute['quantity'] = $attribute['low_stock'] = 0;
                                }

                                $skuValues = $attribute['sku_values'];
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
                                        try {
                                            $media      = $productSku->getMedia('product')->first();
                                            $mediaImage = $productSku->addMediaFromUrl('http://generalchemicalcorp.mybigcommerce.com/product_images/attribute_rule_images/' . $attribute['image'])->toMediaCollection('product', 'products');
                                            if (!empty($media)) {
                                                $media->delete();
                                            }
                                        } catch (FileCannotBeAdded $e) {
                                            report($e);
                                        }
                                    }
                                } else {
                                    //create
                                    $productSku = $product->productSkus()->create($attribute);
                                    if (!empty($attribute['image'])) {
                                        try {
                                            $mediaImage = $productSku->addMediaFromUrl('http://generalchemicalcorp.mybigcommerce.com/product_images/attribute_rule_images/' . $attribute['image'])->toMediaCollection('product', 'products');
                                        } catch (FileCannotBeAdded $e) {
                                            report($e);
                                        }
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
                        if (!empty($productData['category_id']) && !empty($productData['attribute_id'])) {
                            foreach ($productData['category_id'] as $category) {
                                $category = Category::find($category);
                                $sync     = [];
                                foreach ($productData['attribute_id'] as $attribute) {
                                    $sync[$attribute] = ['product_count' => DB::raw('product_count + 1')];
                                }
                                $category->attributes()->sync($sync);
                            }
                        }

                        $product->custom_fields       = $customFields;
                        $product->category_id         = !empty($productData['category_id']) ? $productData['category_id'] : [];
                        $product->attribute_id        = !empty($productData['attribute_id']) ? $productData['attribute_id'] : [];
                        $product->attribute_option_id = $attributeData['attribute_option'];
                        $product->save();
                        DB::commit();
                        Log::info('commit End');
                    }
                }
            }
        }
        $file          = $this->file;
        $file->done_at = Carbon::now();
        $file->save();
        //});
    }
}
