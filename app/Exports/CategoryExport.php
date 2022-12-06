<?php
namespace App\Exports;

use App\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExport implements FromCollection
{
    use Exportable;

    public function collection()
    {
        $categories = Category::select('id as ID', 'name as Name', 'parent_id', 'parent_id as Parent Category', 'description as Description', 'sort_order as Sort Order', 'page_title as Page Title', 'meta_tag_keywords as Meta Keywords', 'meta_tag_description as Meta Description')
            ->orderBy('id', 'ASC')
            ->with(['parent'])
            ->get()->toArray();

        $categoryList = [];
        foreach ($categories as $key => $value) {
            $value['Parent Category'] = $categories[$key]['parent']['name'] ?? "";
            unset($value['parent_id']);
            unset($value['parent']);
            if ($key == 0) {
                $header = [];
                foreach ($value as $index => $row) {
                    $header[] = $index;
                }
                $categoryList[] = $header;
            }
            $categoryList[] = $value;
        }

        return new Collection($categoryList);
    }
}
