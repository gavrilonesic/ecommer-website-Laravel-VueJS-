<?php
namespace App\DataTables;

use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
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
            ->addColumn('name', function ($customer) {
                $name = $customer->name;
                return $name;
            })
            ->editColumn('created_at', function ($customer) {
                return $customer->created_at->isoFormat('Do MMMM YYYY');
            })
            ->addColumn('action', function ($customer) {
                $action = view('admin.customer.action', compact('customer'));
                return $action;
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereRaw("CONCAT(first_name,' ',last_name) like ?", ["%{$keyword}%"]);
            }, true)
            ->addColumn('address_count', function ($customer) {
                $routeName = route('customer.edit', ['customer' => $customer->id]);
                $address_count = '<a href="'.$routeName.'">'.$customer->userAddress->count().'</a>';
                return $address_count;
            })
            ->addColumn('order_count', function ($customer) {
                $routeName = route('order.index', ['user_id' => $customer->id]);
                $order_count = '<a href="'.$routeName.'" target="_blank">'.$customer->orders->count().'</a>';
                return $order_count;
            })
            // ->removeColumn('first_name')
            // ->removeColumn('user_address')
            // ->removeColumn('last_name')
            // ->removeColumn('created_at')
            ->rawColumns(['action','address_count','order_count'])
            ->removeColumn('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model, Request $request)
    {
        $customerQuery = $model->newQuery()->with(['userAddress','orders'])->select('id', 'first_name', 'last_name', 'email', 'mobile_no', 'created_at')->where('is_guest',0);
        return $customerQuery;
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
            ['data' => 'name', 'name' => 'name', 'title' => __('messages.name')],
            ['data' => 'email', 'name' => 'email', 'title' => __('messages.email')],
            ['data' => 'mobile_no', 'name' => 'mobile_no', 'title' => __('messages.mobile_no')],
            ['data' => 'address_count', 'name' => 'address_count', 'title' => __('messages.address_count'),'orderable' => false,],
            ['data' => 'order_count', 'name' => 'order_count', 'title' => __('messages.order_count'),'orderable' => false,],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => __('messages.joining_date'), 'orderable' => true, 'searchable' => false],
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
}
