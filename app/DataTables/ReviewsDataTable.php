<?php
namespace App\DataTables;

use App\Product;
use App\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;

class ReviewsDataTable extends DataTable
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
            ->addColumn('product', function ($review) {
                $routeName = route('product.detail', ['product' => $review->product->slug]);
                $product   = '<a href="' . $routeName . '">' . $review->product->name . '</a>';
                return $product;
            })
            ->editColumn('rating', function ($review) {
                $ratingText = config('constants.REVIEW_RATING')[$review->rating];
                return $ratingText;
            })
            ->editColumn('publish_date', function ($review) {
                if (!empty($review->publish_date) && $review->publish_date !== '0000-00-00') {
                    return Carbon::parse(strtotime($review->publish_date))->isoFormat('Do MMM YYYY');
                } else {
                    return 'N/A';
                }
            })
            ->editColumn('created_at', function ($review) {
                return $review->created_at->isoFormat('Do MMMM YYYY');
            })
            ->editColumn('status', function ($review) {
                $status = view('admin.review.status', compact('review'));
                return $status;
            })
            ->addColumn('action', function ($review) {
                $action = view('admin.review.action', compact('review'));
                return $action;
            })
            ->rawColumns(['action', 'status', 'product']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Review $model, Request $request)
    {
        $reviewQuery = $model->newQuery()->select('reviews.id', 'publish_date', 'reviews.status', 'rating', 'author', 'product_id', 'created_at')->with('product');
        return $reviewQuery;
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
            ['data' => 'product', 'name' => 'product.name', 'title' => __('messages.product_name')],
            ['data' => 'rating', 'name' => 'rating', 'title' => __('messages.rating')],
            ['data' => 'author', 'name' => 'author', 'title' => __('messages.posted_by')],
            // ['data' => 'created_at', 'name' => 'created_at', 'title' => __('messages.added_date'), 'orderable' => true, 'searchable' => false],
            ['data' => 'publish_date', 'name' => 'publish_date', 'title' => __('messages.publish_date'), 'orderable' => true, 'searchable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'visible' => false, 'title' => __('messages.added_date'), 'orderable' => true, 'searchable' => false],
            ['data' => 'status', 'name' => 'status', 'title' => __('messages.status'), 'orderable' => true, 'searchable' => false],
            ['data' => 'action', 'name' => 'action', 'title' => __('messages.action'), 'orderable' => false, 'searchable' => false],
            // ['data' => 'action', 'name' => 'action', 'title' => __('messages.action'), 'orderable' => false, 'searchable' => false],
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
            "order"         => [[5, "desc"]],
        ];
    }
}
