<?php

namespace App\DataTables;

use App\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('image', function ($product) {
                $media = view('admin.product.media', compact('product'));

                return $media;
            })
            ->editColumn('name', function ($product) {
                $name = view('admin.product.name', compact('product'));
                return $name;
            })
            ->editColumn('price', function ($product) {
                return setting('currency_symbol') . $product->price;
            })
            ->editColumn('status', function ($product) {
                $status = view('admin.product.status', compact('product'));
                return $status;
            })
            ->editColumn('updated_at', function ($product) {
                return date('m/d/y', strtotime($product->updated_at));
            })
            ->addColumn('action', function ($product) {
                $action = view('admin.product.action', compact('product'));
                return $action;
            })
            ->rawColumns(['name', 'status', 'image', 'action'])
            ->removeColumn('medias')
            ->removeColumn('id')
            ->removeColumn('slug');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model, Request $request)
    {
        $productQuery = $model->newQuery()->select('id', 'sku', 'name', 'price', 'status', 'slug', 'updated_at')->with(['medias' => function ($query) {
            $query->whereJsonContains('custom_properties->default_image', true);
        }]);
        if (!empty($request->name)) {
            $productQuery->where('name', 'like', "%$request->name%");
        }
        if (!empty($request->sku)) {
            $productQuery->where('sku', 'like', "%$request->sku%");
        }
        if (!empty($request->brand_id)) {
            $productQuery->where('brand_id', (int) $request->brand_id);
        }
        if (!empty($request->category_id)) {
            $productQuery->whereJsonContains('category_id', (int) $request->category_id);
        }
        if (!empty($request->attribute_id)) {
            $productQuery->whereJsonContains('attribute_id', (int) $request->attribute_id);
        }
        return $productQuery;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters($this->getBuilderParameters())
            ->parameters([
                'drawCallback' => 'function() { imapgePopup() }',
            ])
            ->minifiedAjax();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['defaultContent' => '', 'name' => '#', 'title' => '#', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'image', 'name' => 'image', 'title' => __('messages.image'), 'orderable' => false],
            ['data' => 'sku', 'name' => 'sku', 'title' => __('messages.sku')],
            ['data' => 'name', 'name' => 'name', 'title' => __('messages.name')],
            ['data' => 'price', 'name' => 'price', 'title' => __('messages.price')],
            ['data' => 'status', 'name' => 'status', 'title' => __('messages.is_publish'), 'orderable' => true],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => __('messages.updated_at')],
            ['data' => 'action', 'name' => 'action', 'title' => __('messages.action'), 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            "pageLength"    => 50,
            "drawCallback"  => "function() { tooltip(); }",
            "bLengthChange" => true,
            "bAutoWidth"    => false,
            "stateSave"     => true,
            "deferRender"   => true,
            "order"         => [[6, "desc"]],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Products_' . date('YmdHis');
    }
}
