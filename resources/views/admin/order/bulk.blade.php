@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header">
        <div class="page-inner py-5">
            <div class="d-flex justify-content-between">
                <div class="form-group flex-1 p-0">
                    <label>
                        Order Status
                    </label>
                    <select class="form-control select2" id="order_status">
                        @foreach($orderStatus as $key => $oStatus)
                        <option value="{{$oStatus->id}}">{{$oStatus->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group flex-1 p-0 ml-4">
                    <label>
                        Shipping Service
                    </label>
                    <select class="form-control select2" id="tracking_provider_id">
                        @foreach(config('constants.SHIPPING_PROVIDERS') as $key => $provider)
                        <option value="{{$key}}">{{$provider}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group flex-1 p-0">
                </div>
                <div class="form-group d-flex align-items-end p-0 ml-4">
                    <button type="button" class="btn btn-primary" onclick="bulkUpdate()">Save changes</button>
                </div>
            </div>
            <div class="d-flex justify-content-end p-0 mt-2">
                <div class="ml-auto">
                    <label class="m-0"><input type="checkbox" id="not_end_email" class="mr-2">Do not send email</label>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <table class="table" >
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Items
                                        </th>
                                        <th>
                                            Customer
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Tracking ID
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="bulk-table">
                                    @foreach ($orders as $index => $order)
                                    <tr>
                                        <td>
                                            #{{$order->id}}
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="d-flex flex-column p-2">
                                                <div>
                                                    <strong>Total: </strong> {{setting('currency_symbol') . ($order->order_total > 0 ? $order->order_total : '')}}
                                                </div>
                                                <div>
                                                    <strong>Shipping total: </strong> {{setting('currency_symbol')}}{!! $order->shipping_total !!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach($order->orderItems as $orderItem)
                                            <div class="d-flex flex-column p-2">
                                                <div>
                                                    <strong>{{$orderItem->quantity}} x
                                                        <a href="{{ route('product.detail', ['product' => $orderItem->product->slug]) }}"
                                                            target="_blank">
                                                            {{$orderItem->product->name}}
                                                        </a>
                                                    </strong>
                                                </div>
                                                <div>
                                                    <strong>Price</strong> {{setting('currency_symbol')}} {!!
                                                    number_format($orderItem->price * $orderItem->quantity,2) !!}
                                                </div>

                                                <div>
                                                    <strong>{{__('messages.status')}}: </strong>
                                                    <span id="order-item-status-{{$orderItem->id}}">
                                                        {{ $orderItem->orderStatus->name ?? '' }}
                                                    </span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{$order->billing_address_name ? $order->billing_address_name : $order->name}}
                                        </td>
                                        <td>
                                            {{$order->orderStatus->name}}
                                        </td>
                                        <td class="bulk-inputs">
                                            <input type="text" placeholder="Tracking ID" class="tracking-number" value="">
                                            <input type="hidden" class="order-id" value="{{$order->id}}">
                                     
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary removeRow">Remove</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('.select2').select2({
        theme: "bootstrap"
    });
</script>
<script>
    
    function bulkUpdate(){
        event.preventDefault();

        var data = {
  
            order_status_id: $('#order_status').val(),
            carrier_name: $('#carrier_name').val(),
            order_send_email: Number($('#not_end_email').prop("checked") !== true),
            tracking_provider_id: $('#tracking_provider_id').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        
        $('.bulk-inputs').each(function(index) {
            var id = $(this).find('.order-id').val();
            var tracking_number = $(this).find('.tracking-number').val();
            data['orders['+index+'][id]'] = id;
            data['orders['+index+'][tracking_number]'] = tracking_number;
        });

        post_to_url("{{route('order.bulk.update')}}", data, 'POST');
    }
    function post_to_url(path, params, method) {
        method = method || "post";

        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);
        form.setAttribute("_token", $('meta[name="csrf-token"]').attr('content'));

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

    $(".removeRow").click(function(event) {
        $(this).parent().parent().remove();
    });
</script>
@endsection