<?php
namespace App\Exports;

use App\Product;
use App\ProductSku;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class GoogleFeedExport implements FromCollection
{
    use Exportable;

    /**
     * Custom Function for Remove Specific Tag in the string.
     */    
    private function strip_html_tags(Array $tags,$string) {
        foreach($tags as $tag) {
            $string = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/", '', $string);
        }
        return $string;
    }

    public function collection()
    {
        $products = Product::select(
                'id',
                'sku',
                'name as title',
                'description',
                'include_in_feed',
                'quantity as quantity',
                'slug as link',
                DB::raw('"New" as `condition`'),
                'price',
                DB::raw('"In Stock" as `availability`'),
                'status',
                DB::raw('"" as `image_link`'),
                'brand_id',
                DB::raw('"" as `gtin`'),
                'sku as mpn',
                DB::raw('"General Chemical Corp" as `brand`'),
                DB::raw('"Hardware > Building Consumables > Chemicals" as `google_product_category`'),
                'name as custom_label_0',
                'name as shipping_label',
                'weight as shipping_weight')
            ->orderBy('id', 'ASC')
            ->with(['brand' => function ($query) {
                $query->select('id', 'name');
            }, 'categories' => function ($query) {
                $query->select('categories.id', 'categories.name');
            }, 'relatedProducts' => function ($query) {
                $query->select('products.id', 'products.name');
            }, 'productSkus.productSkuValues.attributeOptions' => function ($query) {
                $query->withTrashed()->with(['attribute' => function ($query) {
                    $query->withTrashed();
                }]);
            }])
            ->where('status', 1)->get()->toArray();

        $productsList = [];
            
        foreach ($products as $index => $value) {
            if($value['include_in_feed']) {

                $product = Product::where('id',$value['id'])->first();
    
                $image = $product->medias->first();
    
                if(gettype($image) == "object" && strpos($image->mime_type, 'image') > -1) {
                    $value['image_link'] = 'https://generalchem.com/storage/products/' . $image->id . '/' . $image->file_name;
                } else {
                    $value['image_link'] = '';
                }
    
                $value['description'] = $this->strip_html_tags(['span', 'strong', 'br'], $value['description']);
    
                $value['brand'] = $value['brand']['name'] ?? $value['brand'];
            
                $value['link'] = 'https://generalchem.com/product/' . $value['link'];
    
                $value['shipping_weight'] = $value['shipping_weight'] . ' lb';
    
                $value['availability'] = $value['status'] == 1 ? "In Stock" : "Out of Stock";
    
                $value['price'] = $value['price'] . ' USD';
    
                $productSkus = $value['product_skus'];
            
                $categories = $value['categories'];
    
                unset($value['include_in_feed']);
                unset($value['product_skus']);
                unset($value['categories']);
                unset($value['quantity']);
                unset($value['status']);
                unset($value['brand_id']);
                unset($value['related_products']);
            
                if ($index == 0) {
                    $header = [];
                    foreach ($value as $index => $row) {
                        $header[] = $index;
                    }
                    $productsList[] = $header;
                }
            
                $productsList[] = $value;
    
                $index = 0;
                foreach ($productSkus as $productSku) {
                    $index += 1;
                    if($productSku['include_in_feed']){                
                        $skuModel = ProductSku::where('id',$productSku['id'])->first();
        
                        $skuImage = $skuModel->medias != NULL ? $skuModel->medias->first() : NULL;
        
                        if(gettype($skuImage) == "object" && strpos($skuImage->mime_type, 'text') !== FALSE) {
                            $newValue['image_link'] = 'https://generalchem.com/storage/products/' . $skuImage->id . '/' . $skuImage->file_name;
                        } else {
                            $newValue['image_link'] = $value['image_link'];
                        }
        
                        $newValue = $value;
                        $newValue['id'] = $value['id'] . '-' . $productSku['id'];
                        $newValue['title'] = $value['title'];
                        $newValue['sku'] = $value['sku'] . '-' . $productSku['id'];
                        $newValue['price'] = $productSku['price'] . ' USD';
                        $newValue['shipping_weight'] = $productSku['weight'] . ' lb';
                        $newValue['link'] = $newValue['link'] . '?option=' . $index;
                        foreach ($productSku['product_sku_values'] as $productSkuValues) {
                            if (!empty($productSkuValues['attribute_options']['option'])) {
                                $newValue['custom_label_0'] .= $value['custom_label_0'] . " (" . $productSkuValues['attribute_options']['option'] . ")";
                                $newValue['shipping_label'] .= $value['shipping_label'] . " (" . $productSkuValues['attribute_options']['option'] . ")";
                                $newValue['title'] .= " (" . $productSkuValues['attribute_options']['option'] . ")";
                            }
                        }
                        $productsList[] = $newValue;
                    }
                }
            }
        }    
        return new Collection($productsList);
    }
}
