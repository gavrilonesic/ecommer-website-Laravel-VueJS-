<?php
namespace App\Exports;

use App\Product;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    use Exportable;

    public function collection()
    {
        $products = Product::select(
            DB::raw('"product" as "Item Type"'),
            'id',
            'name as Name',
            'sku as SKU',
            'brand_id',
            'brand_id as Brand',
            'price as Default Price',
            'weight as Weight',
            'depth as Depth',
            'height as Height',
            'width as Width',
            'quantity as Quantity',
            'low_stock as Low Stock',
            'category_id as Categories',
            'short_description as Short Description',
            'description as Description',
            'inventory_tracking as Inventory Tracking',
            DB::raw('(CASE WHEN inventory_tracking_by = 0 THEN "On the product level" ELSE "On the attribute level" END) As "Inventory Tracking By"'),
            DB::raw('mark_as_new as "Mark As New"'),
            DB::raw('mark_as_featured as "Mark As Featured"'),
            'page_title as Page Title',
            'meta_tag_keywords as Meta Keywords',
            'meta_tag_description as Meta Description',
            'custom_fields')
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
            ->get()->toArray();

        $productsList = [];
        foreach ($products as $index => $value) {
            $value['Brand']      = $value['brand']['name'] ?? "";
            $value['Categories'] = "";
            if (!empty($value['categories'])) {
                foreach ($value['categories'] as $key => $category) {
                    $value['Categories'] .= $category['name'] . ";";
                }
                $value['Categories'] = rtrim($value['Categories'], ";");
            }
            $value["Custom Fields"] = "";
            if (!empty($value['custom_fields'])) {
                foreach (json_decode($value['custom_fields'], true) as $key => $customFields) {
                    $value["Custom Fields"] .= (!empty($value["Custom Fields"]) ? ";" : "");
                    $value["Custom Fields"] .= $key . "=" . implode(";$key=", $customFields);
                }
            }

            if (!empty($value['related_products'])) {
                foreach ($value['related_products'] as $key => $product) {
                    $value['Related Product'][] = $product['name'];
                }
                $value['Related Product'] = implode(";", $value['Related Product']);
            } else {
                $value["Related Product"] = "";
            }

            $productSkus = $value['product_skus'];
            unset($value['brand_id']);
            unset($value['brand']);
            unset($value['categories']);
            unset($value['related_products']);
            unset($value['custom_fields']);
            unset($value['product_skus']);
            if ($index == 0) {
                $header = [];
                foreach ($value as $index => $row) {
                    $header[] = $index;
                }
                $productsList[] = $header;
            }
            $productsList[] = $value;

            foreach ($productSkus as $productSku) {
                $value = ["Item Type" => "SKU", 'id' => $productSku['id'], 'Name' => '', "SKU" => $productSku['sku'], "Brand" => "", 'Default Price' => $productSku['price'], 'Weight' => $productSku['weight'], 'Depth' => $productSku['depth'], 'Height' => $productSku['height'], 'Width' => $productSku['width'], 15 => $productSku['quantity'], 16 => $productSku['low_stock']];
                foreach ($productSku['product_sku_values'] as $productSkuValues) {
                    if (!empty($productSkuValues['attribute_options']['option'])) {
                        $value['Name'] .= (!empty($value['Name']) ? ";" : "");
                        $value['Name'] .= $productSkuValues['attribute_options']['attribute']['name'] . "=" . $productSkuValues['attribute_options']['option'];
                    }
                }
                $productsList[] = $value;
            }
        }

        return new Collection($productsList);
    }
}
