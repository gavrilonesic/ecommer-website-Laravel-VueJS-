<div class="row order-detail-accordian">
    @if(!empty($order->payment_status) && !empty($order->payment_status_code) && $order->payment_status_code!==1)
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                {{-- @if(!empty($order->payment_response->transactionResponse->errors))
               {{ $order->payment_response->transactionResponse->errors[0]->errorText }}
               @else --}}
                Please verify Payment Manually.
               {{-- @endif --}}
            </div>
        </div>
    @endif
    @if(!$order->payment_status)
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                {{$order->payment_message}}
            </div>
        </div>
    @endif
    <!-- static html-->
    <div class="col-md-6 col-lg-3 br-line">
         <div class="row">
            <div class="col-lg-7 col-md-12">  <h2>Billing</h2></div>
            <div class="col-lg-5 col-md-12 text-lg-right text-md-center"><a class="btn btn-primary" href="javascript:void(0)" onclick="copyToClipboard('billing-address-{{$order->id}}')"></i> Copy</a></div>
        </div>
        <div class="address">
            <span><i class="icon-location-pin"></i><div id="billing-address-{{$order->id}}">{!! nl2br($order->getBillingAdress()) !!}</div></span>
            <span><i class="icon-phone"></i> <a href="tel:{{$order->billing_mobile_no}}">{{$order->billing_mobile_no}}</a></span>
            <span><i class="icon-envelope"></i> <a href="mailtp:{{$order->billing_email}}">{{$order->billing_email}}</a></span>
            <span><i class="icon-credit-card"></i> {{$order->payment->title}}</span>
            @if(!empty($order->payment_transaction_id))
            <span><i class="icon-key"></i> {{$order->payment_transaction_id}}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6 col-lg-3 br-line">
        <div class="row">
            <div class="col-lg-7 col-md-12">  <h2>Shipping</h2></div>
            <div class="col-lg-5 col-md-12 text-lg-right text-md-center"><a class="btn btn-primary" href="javascript:void(0)" onclick="copyToClipboard('shipping-address-{{$order->id}}')"></i> Copy</a></div>
        </div>
        <div class="address">
            <span>
                <i class="icon-location-pin"></i>
                <div id="shipping-address-{{$order->id}}">
                    {!! nl2br($order->getShippingAdress()) !!}
                </div>
            </span>
            <span><i class="icon-phone"></i> <a href="tel:{{$order->mobile_no}}">{{$order->mobile_no}}</a></span>
            <span><i class="icon-envelope"></i> <a href="mailtp:{{$order->email}}">{{$order->email}}</a></span>
            <span class="form-group">
                <i class="icon-plane"></i>
                @if ($order->shipping_quotes ==  'own_shipping')
                    {{__('messages.shipping_service_name')}}: {{$order->shipping_service_name}}<br/>
                    {{__('messages.shipping_account_number')}}: {{$order->shipping_account_number}} <br/>
                    {{__('messages.shipping_note')}}: {{$order->shipping_note}}</p>
                @elseif ($order->shipping_quotes ==  'pickup_in_store')
                    {{__('messages.pickup_from_store')}} ({{ setting('address_line1') ? setting('address_line1') : '12336 Emerson Dr.' }} {{ setting('address_line2') ? setting('address_line2') : '' }} {{ setting('city') ? setting('city').', ' : 'Brighton, ' }} {{ setting('state') ? setting('state') : 'MI' }} {{ setting('zipcode') ? setting('zipcode').', ' : '48116' }} {{ setting('country') ? setting('country') : 'USA' }})
                @elseif (in_array($order->shipping_service_name, ['UPS Ground', 'UPS 2nd Day Air', 'Truck Freight Shipping']))
                    {{ $order->shipping_service_name }}
                @else
                {{__('messages.' . $order->shipping_quotes)}}
                @endif
            </span>
            @if(!empty($order->shipping_total) && $order->shipping_total > 0)
                <span><i class="icon-wallet"></i>{{setting('currency_symbol')}}{!! $order->shipping_total !!}</span>
            @endif
        </div>

    </div>
    <div class="col-md-12 col-lg-6">
        <div class="row">
            <div class="col-lg-7 col-md-12">  <h2>Orders <div class="totalitemnum">({{$order->orderItems->sum('quantity')}} items)</div>
            </h2></div>
            @if($order->payment_status)
            <div class="col-lg-5 col-md-12 text-lg-right text-md-center"><a class="btn btn-primary  view-order" href="javascript:void(0)" data-toggle="modal" data-url="{{route('order.status.view', ['order' => $order->id])}}"></i>Change Status</a></div>
            @endif
        </div>



        <div class="orderdetails">
            <table class="table">
                @foreach($order->orderItems as $orderItem)
                <tr>
                    <td class="pdetail">
                        <strong>{{$orderItem->quantity}} x <a href="{{ route('product.detail', ['product' => $orderItem->product->slug]) }}" target="_blank">{{$orderItem->product->name}}</a> </strong> <br>
                       @if($orderItem->product->sku){{$orderItem->product->sku}} <br>@endif
                        @if (!empty($orderItem->variations))
                          @foreach ($orderItem->variations as $key => $row)
                            <strong>
                              {{$key}}:
                            </strong>
                            {{$row}}
                            <br/>
                          @endforeach
                        @endif
                         <strong>
                            {{__('messages.status')}}:
                        </strong>
                         <span id="order-item-status-{{$orderItem->id}}">
                            {{ $orderItem->orderStatus->name ?? '' }}
                        </span>
                        @if(!empty($orderItem->tracking_number))
                             <br/>
                             <strong>
                                {{ $orderItem->getCarrierName() }}:
                            </strong>
                            <span>
                                {{ $orderItem->tracking_number}}
                            </span>
                        @endif
                        @if(!empty($orderItem->comment))
                        <br/>
                        <strong>
                             {{__('messages.cancel_reason')}}:
                        </strong>
                        <span>
                                {!! nl2br($orderItem->comment) !!}
                            </span>
                        @endif
                    </td>
                    <td class="price">
                        {{setting('currency_symbol')}}{!! number_format($orderItem->price * $orderItem->quantity,2) !!}
                    </td>
                    {{-- <td class="optcheck">
                        @include('admin.order.status')
                        <select class="form-control">Select an option
                            <option>Option 1</option>
                            <option>Option 1</option>
                            <option>Option 1</option>
                            <option>Option 1</option>
                        </select>
                    </td> --}}
                </tr>
                @endforeach
                <tr class="totalrow">
                    <td colspan="2">
                        <table class="table">

                            @if (! $order->coupons->isEmpty())
                                <tr>
                                    <td>Coupons: </td>
                                    <td align="right">
                                        @foreach ($order->coupons as $coupon)
                                            <kbd>{{ $coupon->code }}</kbd>
                                            @if (! $loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endif

                            @if (trim($order->purchase_order) !== '')

                                <tr>
                                    <td>
                                        PO
                                    </td>
                                    <td align="right">
                                        {{ $order->purchase_order }}
                                    </td>
                                </tr>

                            @endif

                            <tr>
                                <td>
                                    Subtotal
                                </td>
                                <td align="right">
                                    {{setting('currency_symbol')}}{!! $order->order_sub_total !!}
                                </td>
                            </tr>
                            @if(!empty($order->order_discount) && $order->order_discount > 0)
                                <tr>
                                    <td>
                                        Discount
                                    </td>
                                    <td align="right">
                                        -{{setting('currency_symbol')}}{!! $order->order_discount !!}
                                    </td>
                                </tr>
                            @endif
                            @if(!empty($order->shipping_total))
                                <tr>
                                    <td>
                                        Shipping
                                    </td>
                                    <td align="right">
                                        {{setting('currency_symbol')}}{!! $order->shipping_total !!}
                                    </td>
                                </tr>
                            @endif
                            @if(!empty($order->handling_fees_total) && $order->handling_fees_total > 0)
                                <tr>
                                    <td>
                                        Handling Fees
                                    </td>
                                    <td align="right">
                                        {{setting('currency_symbol')}}{!! $order->handling_fees_total !!}
                                    </td>
                                </tr>
                            @endif
                            @if(!empty($order->hazmat_shipping_cost) && $order->hazmat_shipping_cost > 0)
                                <tr>
                                    <td>
                                        {{__('messages.hazmat_shipping_cost')}}
                                    </td>
                                    <td align="right">
                                        {{setting('currency_symbol')}}{!! $order->hazmat_shipping_cost !!}
                                    </td>
                                </tr>
                            @endif
                            <tr class="grand_total">
                                <td>
                                    GRAND TOTAL
                                </td>
                                <td align="right">
                                    {{setting('currency_symbol')}}{{ $order->order_total }}
                                </td>
                            </tr>
                            @if(!empty($order->refund_total) && $order->refund_total > 0)
                                <tr>
                                    <td>
                                        Refunded
                                    </td>
                                    <td align="right">
                                        -{{setting('currency_symbol')}}{!! $order->refund_total !!}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>

            </table>

        </div>

    </div>
    <!--static html end-->
</div>
<script type="text/javascript">
    $('.select2').select2({
        theme: "bootstrap"
    });
    // $('body').on('click', 'a.view-order', function (e) {
    //     $('#show-order-detail').load($(this).attr("data-url"), function (result) {
    //         $('#show-order-detail').modal({show: true});
    //     });
    // });
    function copyToClipboard(containerid) {
    if (window.getSelection) {
        if (window.getSelection().empty) { // Chrome
            window.getSelection().empty();
        } else if (window.getSelection().removeAllRanges) { // Firefox
            window.getSelection().removeAllRanges();
        }
    } else if (document.selection) { // IE?
        document.selection.empty();
    }

    if (document.selection) {
        var range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerid));
        range.select().createTextRange();
        document.execCommand("copy");
        flashMessage('success', 'Address Copied');
    } else if (window.getSelection) {
        var range = document.createRange();
        range.selectNode(document.getElementById(containerid));
        window.getSelection().addRange(range);
        document.execCommand("copy");
        flashMessage('success', 'Address Copied');
    }
    if (window.getSelection) {
        if (window.getSelection().empty) { // Chrome
            window.getSelection().empty();
        } else if (window.getSelection().removeAllRanges) { // Firefox
            window.getSelection().removeAllRanges();
        }
    } else if (document.selection) { // IE?
        document.selection.empty();
    }
}
</script>
