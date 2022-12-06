<?php
namespace App\DataTables;

use App\CategoryInquiry;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;

class CategoryInquiryDataTable extends DataTable
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
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\CategoryInquiry $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CategoryInquiry $model, Request $request)
    {

        $inquiryQuery = $model->newQuery()->select('id', 'first_name', 'last_name','company_name', 'email', 'phone', 'process_time','temperature','concentration','soak','special_requirements','reference','comments','created_at')->where('category_id',$request->category_id);
        return $inquiryQuery;
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
            ['data' => 'first_name', 'name' => 'first_name', 'title' => __('messages.first_name')],
            ['data' => 'last_name', 'name' => 'last_name', 'title' => __('messages.last_name')],
            ['data' => 'company_name', 'name' => 'company_name', 'title' => __('messages.company_name')],
            ['data' => 'email', 'name' => 'email', 'title' => __('messages.email')],
            ['data' => 'phone', 'name' => 'phone', 'title' => __('messages.mobile_no')],
            ['data' => 'process_time', 'name' => 'process_time', 'title' => __('messages.process_time')],
            ['data' => 'temperature', 'name' => 'temperature', 'title' => __('messages.temperature')],
            ['data' => 'concentration', 'name' => 'concentration', 'title' => __('messages.concentration')],
            ['data' => 'soak', 'name' => 'soak', 'title' => __('messages.soak')],
            ['data' => 'special_requirements', 'name' => 'special_requirements', 'title' => __('messages.special_requirements')],
            ['data' => 'reference', 'name' => 'reference', 'title' => __('messages.reference')],
            ['data' => 'comments', 'name' => 'comments', 'title' => __('messages.comments')],
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
}
