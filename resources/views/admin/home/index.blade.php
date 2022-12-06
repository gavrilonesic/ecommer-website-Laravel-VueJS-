@extends('admin.layouts.app')

@section('content')
<div class="content admin-dashboard">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pb-3">
                        <div>
                            <h2 class="pb-2 fw-bold">{{__('messages.dashboard')}}</h2>
                            <h5 class="op-7 mb-2">{{__('messages.store_statistics')}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-primary card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="icon-big text-center">
                                                <i class="icon-people"></i>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 col-stats text-lg-left text-center">
                                            <div class="numbers">
                                                <p class="card-category">{{__('messages.no_of_customers')}}</p>
                                                <a href="{{ route('customer.index') }}" class=""><h4 class="card-title">@if($data['no_of_customers'] > 0) {{number_format($data['no_of_customers'])}} @else - @endif </h4></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-info card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="icon-big text-center">
                                                <i class="icon-notebook"></i>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 col-stats text-lg-left text-center">
                                            <div class="numbers">
                                                <p class="card-category">{{__('messages.no_of_orders')}}</p>
                                                <a href="{{ route('order.index') }}" class=""><h4 class="card-title">@if($data['order_count'] > 0) {{number_format($data['order_count'])}} @else - @endif</h4></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-success card-round">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="icon-big text-center">
                                                <i class="icon-layers"></i>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 col-stats text-lg-left text-center">
                                            <div class="numbers">
                                                <p class="card-category">{{__('messages.no_of_products')}}</p>
                                                <a href="{{ route('product.index') }}" class=""><h4 class="card-title">@if($data['products_count'] > 0) {{number_format($data['products_count'])}} @else - @endif</h4></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-secondary card-round">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="icon-big text-center">
                                                <i class="icon-list"></i>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 col-stats text-lg-left text-center">
                                            <div class="numbers">
                                                <p class="card-category">{{__('messages.no_of_categories')}}</p>
                                                <a href="{{ route('category.index') }}" class=""><h4 class="card-title">@if($data['category_count'] > 0) {{$data['category_count']}} @else - @endif</h4></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h5 class="op-7 mb-2">{{__('messages.sales_statistics')}}</h5>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="icon-big text-center">
                                                <i class="icon-pie-chart text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 col-stats text-lg-left text-center">
                                            <div class="numbers">
                                                <p class="card-category">{{__('messages.total_sale')}}</p>
                                                <h4 class="card-title">{{\setting('currency_symbol')}}{{number_format($data['total_sale'],2)}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="icon-big text-center">
                                                <i class="icon-chart"></i>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 col-stats text-lg-left text-center">
                                            <div class="numbers">
                                                <p class="card-category">{{__('messages.average_sale')}}</p>
                                                <h4 class="card-title">{{\setting('currency_symbol')}}{{number_format($data['average_sale'],2)}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="icon-big text-center">
                                                <i class="icon-calendar text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 col-stats text-lg-left text-center">
                                            <div class="numbers">
                                                <p class="card-category">{{__('messages.monthly_sale')}}</p>
                                                <h4 class="card-title">{{!empty($data['monthly_avg_order']) ?round($data['monthly_avg_order']) : $data['total_order']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-5">
                                            <div class="icon-big text-center">
                                                <i class="icon-basket-loaded text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-7 col-stats text-lg-left text-center">
                                            <div class="numbers">
                                                <p class="card-category">{{__('messages.yearly_sale')}}</p>
                                                <h4 class="card-title">{{!empty($data['yearly_avg_order']) ?round($data['yearly_avg_order']) : $data['total_order']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       {{--  <div class="col-md-5">
                            <div class="card full-height">
                                <div class="card-header">
                                    <div class="card-title">{{__('messages.stock_threshold')}}</div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody><tr>
                                                <th>{{__('messages.product')}}</th>
                                                <th>{{__('messages.quantity')}}</th>
                                            </tr>
                                            @foreach($data['stock_threshold'] as $key => $value)
                                            <tr>
                                                <td><a href="{{route('product.edit', ['id' => $value->id])}}">{{$value->name}}</a></td>
                                                <td class="font-weight-600">{{$value->quantity}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-12">
                            <div class="card full-height">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">{{__('messages.recent_orders')}}</div>
                                        <div class="card-tools">
                                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                                                <li class="nav-item submenu">
                                                    <a class="nav-link active show" data-toggle="pill" href="#recent" role="tab" aria-selected="true">Recent</a>
                                                </li>
                                                <li class="nav-item submenu">
                                                    <a class="nav-link" data-toggle="pill" href="#pending" role="tab" aria-selected="false">{{__('messages.pending')}}</a>
                                                </li>
                                                <li class="nav-item submenu">
                                                    <a class="nav-link show" data-toggle="pill" href="#delievered" role="tab" aria-selected="true">{{__('messages.delievered')}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body tab-content" >
                                    <div class="tab-pane fade show active" id="recent">
                                        @foreach($data['recent_orders'] as $key => $value)
                                        <div class="d-table w-100">
                                            <div class="d-block d-md-table-cell align-top">
                                                <div class="d-table-cell align-top pt-1 pl-4">
                                                    <h5 class="title-product fw-bold">{{$value->invoice_no}}</h5>
                                                    <p class="text-muted mb-0">Url: <a class="fw-bold" href="{{route('order.index')}}">{{$value->id}}</a></p>
                                                </div>
                                            </div>
                                            <div class="d-block d-md-table-cell align-top float-md-right pt-3 pt-md-1 pl-md-5">
                                                <div class="d-inline-block text-right align-top">
                                                    <h2 class="fw-bold">{{$value->order_total}}</h2>
                                                    <h5 class="text-muted">Sales</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator-dashed"></div>
                                        @endforeach
                                    </div>

                                    <div class="tab-pane fade" id="pending">
                                        @foreach($data['pending_orders'] as $key => $value)
                                        <div class="d-table w-100">
                                            <div class="d-block d-md-table-cell align-top">
                                                <div class="d-table-cell align-top pt-1 pl-4">
                                                    <h5 class="title-product fw-bold">{{$value->invoice_no}}</h5>
                                                    <p class="text-muted mb-0">Url: <a class="fw-bold" href="{{route('order.index')}}">{{$value->id}}</a></p>
                                                </div>
                                            </div>
                                            <div class="d-block d-md-table-cell align-top float-md-right pt-3 pt-md-1 pl-md-5">
                                                <div class="d-inline-block text-right align-top">
                                                    <h2 class="fw-bold">{{$value->order_total}}</h2>
                                                    <h5 class="text-muted">Sales</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator-dashed"></div>
                                        @endforeach
                                    </div>

                                    <div class="tab-pane fade" id="delievered">
                                        @foreach($data['delievered_orders'] as $key => $value)
                                        <div class="d-table w-100">
                                            <div class="d-block d-md-table-cell align-top">
                                                <div class="d-table-cell align-top pt-1 pl-4">
                                                    <h5 class="title-product fw-bold">{{$value->invoice_no}}</h5>
                                                    <p class="text-muted mb-0">Url: <a class="fw-bold" href="{{route('order.index')}}">{{$value->id}}</a></p>
                                                </div>
                                            </div>
                                            <div class="d-block d-md-table-cell align-top float-md-right pt-3 pt-md-1 pl-md-5">
                                                <div class="d-inline-block text-right align-top">
                                                    <h2 class="fw-bold">{{$value->order_total}}</h2>
                                                    <h5 class="text-muted">Sales</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator-dashed"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">{{__('messages.sales_report')}}</div>
                                        <div class="card-tools">
                                            <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm">
                                                <li>
                                                    <input type="text" name="daterange" value="" class="form-control" />
                                                    <input id="from" name="from" placeholder="From" value="" type="hidden">
                                                    <input id="to" name="to" placeholder="To" value="" type="hidden">
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="salesChart"></canvas>
                                    </div>

                                    {{-- <div class="chart-container" style="min-height: 375px"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                        <canvas id="statisticsChart" width="597" height="375" class="chartjs-render-monitor" style="display: block; width: 597px; height: 375px;"></canvas>
                                    </div>
                                    <div id="myChartLegend"><ul class="0-legend html-legend"><li><span style="background-color:#f3545d"></span>Subscribers</li><li><span style="background-color:#fdaf4b"></span>New Visitors</li><li><span style="background-color:#177dff"></span>Active Users</li></ul></div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{__('messages.top_selling_products')}}</div>
                                </div>
                                <div class="card-body pb-0">
                                    @if ($data['top_selling_product']->count() > 0)
                                        @foreach($data['top_selling_product'] as $product)
                                            <div class="d-flex mb-3">
                                                <div class="avatar">
                                                    <img src="{{!empty($product->product->medias[0]) ? $product->product->medias[0]->getUrl('thumb') : asset('images/150x150.png')}}" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="flex-1 pt-1 ml-2">
                                                    <h6 class="fw-bold mb-1">{{$product->product->name}}</h6>
                                                    {{-- <small class="text-muted">{{$product->product->name}}</small> --}}
                                                </div>
                                                <div class="d-flex ml-auto align-items-center">
                                                    <h3 class="text-info fw-bold">{{$product->total ?? 0}}</h3>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title fw-mediumbold">{{__('messages.customer_with_most_sales')}}</div>
                                    <div class="card-list">
                                        @if ($data['top_customer']->count() > 0)
                                            @foreach($data['top_customer'] as $user)
                                                <div class="item-list">
                                                    <div class="avatar">
                                                        <img src="{{ $user->user->avatar_url ?? asset('images/default-avatar.png') }}" alt="..." class="avatar-img rounded-circle">
                                                    </div>
                                                    <div class="info-user ml-3">
                                                        <div class="username">{{$user->user->name ?? ""}}</div>
                                                        {{-- <div class="status">Graphic Designer</div> --}}
                                                    </div>
                                                    {{-- <button class="btn btn-icon btn-primary btn-round btn-xs">
                                                        <i class="fa fa-plus"></i>
                                                    </button> --}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{__('messages.top_performing_categories')}}</div>
                                </div>
                                <div class="card-body pb-0">
                                    @if ($data['top_category']->count() > 0)
                                        @foreach($data['top_category'] as $category)
                                            <div class="d-flex mb-3">
                                                <div class="avatar">
                                                    <img src="{{!empty($category->medias) ? $category->medias->getUrl('thumb') : asset('images/150x150.png')}}" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="flex-1 pt-1 ml-2">
                                                    <h6 class="fw-bold mb-1">{{$category->name ?? ""}}</h6>
                                                    {{-- <small class="text-muted">{{$category->name ?? ""}}</small> --}}
                                                </div>
                                                <div class="d-flex ml-auto align-items-center">
                                                    <h3 class="text-info fw-bold">{{$category->total ?? 0}}</h3>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="{{ asset('js/chart.min.js') }}"></script>
<script type="text/javascript">
    from = moment().subtract(1, 'month');
    to = moment();
    currency  = "{{\setting('currency_symbol')}}";
    $('input[name="daterange"]').daterangepicker({
        "locale":{
                    format: 'MM/DD/YYYY'
                },
        "startDate":from,
        "endDate":to,
        "autoApply": true,
        "showISOWeekNumbers":true,
        "ranges": {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(7, 'days'), moment()],
            'Last 30 Days': [moment().subtract(1, 'month'), moment()],
            'Month To Date': [moment().startOf('month'), moment()],
            'Past Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Year To Date': [moment().startOf('year'), moment()],
            'Past Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        },
    }, function(from, to, label) {
        $("#from").val(from.format('MM/DD/YYYY'));
        $("#to").val(to.format('MM/DD/YYYY'));
        getGraphData();
    });
    $("#from").val(from.format('MM/DD/YYYY'));
    $("#to").val(to.format('MM/DD/YYYY'));
    salesChart = false;
    var myLineChart =  {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    borderColor: "#1d7af3",
                    pointBorderColor: "#FFF",
                    pointBackgroundColor: "#1d7af3",
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 1,
                    pointRadius: 4,
                    backgroundColor: 'transparent',
                    fill: true,
                    borderWidth: 2,
                    data: []
                }]
            },
            options : {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels : {
                        padding: 10,
                        fontColor: '#1d7af3',
                    }
                },
                 scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                tooltips: {
                    bodySpacing: 4,
                    mode:"nearest",
                    intersect: 0,
                    position:"nearest",
                    xPadding:10,
                    yPadding:10,
                    caretPadding:10,
                    callbacks: {
                        label: function(tooltipItems, data) {
                            return  data.datasets[tooltipItems.datasetIndex].label+': ' + currency + data.datasets[0].data[tooltipItems.index];
                        }
                    }
                },
                layout:{
                    padding:{left:15,right:15,top:15,bottom:15}
                }
            }
        };
    function getGraphData()
    {
        var data =[];
        data['from']=$("#from").val();
        data['to']=$("#to").val();
        $.ajax({
           "type":'GET',
           "url":'{{route('admin.dashboard.graph')}}',
           "data":{from:$("#from").val(),to:$("#to").val()},
           "success":function(data){
            var chartConf = $.extend(true, {}, myLineChart);
            chartConf.data.labels = data.chartData.labels;
            chartConf.data.datasets[0].label = data.chartData.label;
            chartConf.data.datasets[0].data = data.chartData.data;
            if (salesChart) salesChart.destroy();
            salesChart = new Chart($('#salesChart'), chartConf);
           },
           "error": function(xhr) {
                console.log(xhr);
          }
        });
    }
    getGraphData();
</script>
@endsection
