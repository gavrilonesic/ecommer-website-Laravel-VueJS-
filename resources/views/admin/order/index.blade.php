@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.orders')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0 dropdown">
                    <button class="btn btn-secondary" type="button" onclick="bulkUpdate()">
                        Bulk Update
                    </button>
                    <a type="button" class="btn btn-secondary" href="{{route('order.index',['failed_order'=>request()->get('failed_order')=='hide'?'show':'hide'])}}">
                        {{__('messages.show_hide_order_button',['name'=>request()->get('failed_order')=='hide'?'Show':'Hide'])}}
                    </a>
                    <button type="button" class="btn btn-secondary"  id="print-orders-btn" onClick=printInvoice("{{route('order.invoice', ['type'=>'print'])}}")>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="orderBtnSpinner" style="display: none"></span>
                        {{__('messages.print_selected_invoice')}}
                    </button>
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{__('messages.filter_orders')}}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item {{ empty((request()->get('status_id'))) ?'active':'' }}" href="{{route('order.index',['user_id'=>request()->get('user_id'),'failed_order'=>'hide'])}}">{{__('messages.all_orders')}}</a>
                    @foreach($orderStatus as $oStatus)
                        <a class="dropdown-item {{ (request()->get('status_id') == $oStatus->id) ?'active':'' }}" href="{{route('order.index',['status_id'=>$oStatus->id,'user_id'=>request()->get('user_id'),'failed_order'=>'hide'])}}">{{$oStatus->name}}</a>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $dataTable->table(['class' => 'display table table-head-bg-primary'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="show-order-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
@endsection
@section('script')
{!! $dataTable->scripts() !!}
<script src="{{ asset('js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
    var table = $('#dataTableBuilder').DataTable();
    // Products column is used for searching only. Keep invisible.
    table.column('products:name').visible(false);

    $('#dataTableBuilder tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var icon = $(this).children('i');
        var row = LaravelDataTables["dataTableBuilder"].row( tr );
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            icon.removeClass('icon-minus').addClass('icon-plus');
            tr.removeClass('shown');
        } else {
            // Open this row
            icon.removeClass('icon-plus').addClass('icon-minus');
            $.ajax({
                type: 'GET',
                url: row.data().details_url,
                success: function(response) {
                    row.child(response).show();;
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON) {
                        flashMessage('error', xhr.responseJSON.message);
                    }
                }
            });
            tr.addClass('shown');
        }
    });
    $('body').on('click', 'a.view-order', function (e) {
        $('#show-order-detail').load($(this).attr("data-url"), function (result) {
            $('#show-order-detail').modal({show: true});
            $('.select2').select2({
                theme: "bootstrap"
            });
        });
    });
    $('body').on('click','#change_status',function(e){
        var order_item_count = $('[name="order_item[]"]:checked').length;
        $("#change_status").prop("disabled", true);
        $("#btnSpinner").show();
        if(order_item_count > 0){
            changeStatus();
        }else{
            $("#change_status").prop("disabled", false);
            $("#btnSpinner").hide();
            alert('please select product');
        }
    });
    $('body').on('change', '.select2', function (e) {
        let order_status = $(this).prop('id') == "order_status";
        let tracking_provider = $(this).prop('id') == "tracking_provider_id";

        if (order_status)
            $(".show-hidden-div").addClass('d-none');

        if (order_status && $(this).val() == "{{config('constants.ORDER_STATUS.DECLINED_CANCELLED')}}") {
            $(".cancel-div").removeClass('d-none');
            return;
        }

        if (order_status && $(this).val() == "{{config('constants.ORDER_STATUS.SHIPPED')}}") {
            $(".shipping-div").removeClass('d-none');
            return;
        }

        if (tracking_provider && $(this).val() == "{{config('constants.CUSTOM_SHIPPING_PROVIDER_ID')}}") {
            $(".carrier-div").removeClass('d-none');
            return;
        } else if (tracking_provider) {
            $(".carrier-div").addClass('d-none');
            return;
        }

        return;
    });

    function changeStatus(){
        var order_items = [];
        $.each($("input[name='order_item[]']:checked"), function(){
            order_items.push($(this).val());
        });
        order_id = $('#order_id').val();
        route_url = $('#route_url').val();
        order_status = $('#order_status').val();
        order_status_text = $('#order_status :selected').text();
        comment = $('#comment').val();
        tracking_url = $('#tracking_url').val();
        tracking_provider_id = $('#tracking_provider_id').val();
        tracking_number = $('#tracking_number').val();
        carrier_name = $('#carrier_name').val();

        if($('#do_not_send_email').prop("checked") == true){
            order_send_email = 0;
        }else{
            order_send_email = 1;
        }

        let postObject = {
            order_id: order_id,
            order_items: order_items,
            order_status_id: order_status,
            tracking_url: tracking_url,
            tracking_provider_id: tracking_provider_id,
            tracking_number: tracking_number,
            order_send_email,
            comment:comment,
            carrier_name:carrier_name
        }

         $.ajax({
            type: 'POST',
            dataType: "json",
            url: route_url,
            data: postObject,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.message) {
                    $('#show-order-detail').modal('hide');
                    $.each(order_items, function(index, value){
                        $("#order-item-status-"+value).html(order_status_text);
                    });
                     $("#btnSpinner").hide();
                    $("#change_status").prop("disabled", false);
                    flashMessage('success', response.message);
                }
            },
            error: function(xhr, status, error) {
                if (xhr.responseJSON) {
                    $('#show-order-detail').modal('hide');
                    $("#change_status").prop("disabled", false);
                    $("#btnSpinner").hide();
                    flashMessage('error', xhr.responseJSON.message);
                }
            }
        });
    }
    function doPrint(url,data=null) {
        $.ajax({
            type: 'GET',
            url: url,
            data:data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                var mywindow = window.open('', 'my div', 'height=1200,width=1200');
                mywindow.document.write(response);
                setTimeout(function(){
                    mywindow.print();
                    mywindow.close();
                }, 500);
                if(data){
                    $("#print-orders-btn").prop("disabled", false);
                    $("#orderBtnSpinner").hide();
                }
            },
            error: function(xhr, status, error) {
                if(data){
                    $("#print-orders-btn").prop("disabled", false);
                    $("#orderBtnSpinner").hide();
                }
                if (xhr.responseJSON) {
                    flashMessage('error', xhr.responseJSON.message);
                }
            }
        });
        return false;
    }
    function printInvoice(url){
        var orderIds = [];
        $.each($("input[name='order_select']:checked"), function(){
            orderIds.push($(this).val());
        });
        if(orderIds.length > 50)
        {
            flashMessage('error', "{{__('messages.can_not_print_more_than')}}");
        }
        else if(orderIds.length <= 0)
        {
            flashMessage('error', "{{__('messages.please_select_atleast_one_order')}}");
        }else{
            $("#print-orders-btn").prop("disabled", true);
            $("#orderBtnSpinner").show();
            data =  {order_id:orderIds};
            doPrint(url,data);
        }
    }
    function bulkUpdate(){
        event.preventDefault();

        var orderIds = {};
        
        $.each($("input[name='order_select']:checked"), function(index){
            orderIds['orders['+ index +'][id]'] = $(this).val();
        });

        if(Object.keys(orderIds).length <= 0){
            flashMessage('error', "{{__('messages.please_select_atleast_one_order')}}");
            return;
        }

        post_to_url("{{route('order.bulk.edit')}}", orderIds, 'GET');
    }
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    function callback()
    {
        tooltip();
        $('#select_all').prop('checked',false);
        $('th.order-select').prop('title', "{{__('messages.select_all')}}");
        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    }
    function post_to_url(path, params, method) {
        method = method || "post";

        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for(var key in params) {
            if(params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection