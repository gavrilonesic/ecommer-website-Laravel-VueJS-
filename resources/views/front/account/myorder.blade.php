<div class="col-md-9 col-lg-9 myprofile-right">
    <h2>
        {{__('messages.my_orders')}}
    </h2>
    <div class="orderlist">
        <!--listing-->
        <div id="accordion" class="wow zoomIn">
          @foreach($orders as $key => $order)
            <div class="card">
                <div class="card-header">
                <div class="column">
                        <span>
                          {{__('messages.order_date')}}
                        </span>
                      {{ date('F j, Y', strtotime($order->created_at)) }}
                    </div>
                    <div class="column">
                        <span>
                            {{__('messages.id_number')}}
                        </span>
                        #{{$order->id}}
                    </div>
                    {{--<div class="column">

                         {{__('messages.product_name')}}
                    </div> --}}
                    {{-- <div class="column">
                        {{setting('currency_symbol')}}{{$order->order_total}}
                    </div> --}}
                    <div class="column trackorder">
                            {{-- Track Your order --}}
                            <span>
                           Total
                        </span>
                          {{setting('currency_symbol')}}{{$order->order_total}} <em>( {{ $order->orderItems->sum('quantity') }} {{__('messages.items')}} )</em>

                    </div>
                    <div class="column">
                    <a href="{{route('view.downloadinvoice', ['order_id' => $order->id])}}" class="btn btn-round" data-toggle="tooltip" title="{{__('messages.download_invoice')}}">
                    <img alt="" src="{{ asset('images/download.png') }}" class="downloadicon">
                            {{__('messages.invoice')}}
                        </a>
                        <a class="btn btn-round" data-toggle="collapse" href="#collapse-{{$order->id}}">
                            <!-- <i class="icon-eye" data-toggle="tooltip" title="Click to View Detail"></i> -->
                            <img alt="" src="{{ asset('images/search.png') }}"> {{__('messages.view_more')}}
                        </a>
                    </div>
                </div>

               <div id="collapse-{{$order->id}}" class="collapse {{ $key == 0 ? 'show' : ''}}" data-parent="#accordion">
                    <div class="card-body">
                        <div class="cart-data">
                          @foreach($order->orderItems as $keydata => $item)

                          <div class="col-md-12 cart-data-list">
                                {{-- @if ($item->order_status_id <= config('constants.ORDER_STATUS.SHIPPED'))
                                    <button class="cancle-order cancel-order-btn" data-target="#order-status-cancel" data-toggle="modal" data-id="{{$item->id}}">
                                      x {{__('messages.cancel_order')}}
                                    </button>
                                @endif --}}
                                <div class="row text-left">

                                    <div class="imgbox datacol">
                                        <img src="{{ (!empty($item->productSku->medias) ? $item->productSku->medias->getUrl() : (!empty($item->product->medias[0]) ? $item->product->medias[0]->getUrl() : asset('images/no-image/default-popular-product.png') )) }}" alt="" title=""/>
                                    </div>
                                    <div class="detailbox datacol">
                                        <h5>
                                        <a href="{{ route('product.detail', ['product' => $item->product->slug]) }}"> {{ $item->product->name }}</a>
                                        </h5>
                                        @if (!empty($item->product->brand->name))
                                          <strong>
                                              {{__('messages.brand')}}:
                                          </strong>
                                          {{$item->product->brand->name}}
                                          <br/>
                                        @endif
                                        {{-- Display here attribute and attribute option --}}
                                        @if (!empty($item->variations))
                                          @foreach ($item->variations as $key => $row)
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
                                        {{ $item->orderStatus->name ?? '' }}
                                        @if ($item->order_status_id == config('constants.ORDER_STATUS.DECLINED_CANCELLED'))
                                        <br/>
                                        @if(!empty($item->comment))
                                        <strong>
                                            {{__('messages.cancel_reason')}}:
                                        </strong>
                                        {{ $item->comment ?? '-' }}
                                        @endif

                                        @endif
                                        <br/>
                                        <strong>
                                            {{__('messages.qty')}}:
                                        </strong>
                                         {{$item->quantity}}
                                    </div>
                                    <div class="add-remove-row datacol">
                                        <div class="price">
                                           <p>{{__('messages.total')}}</p>
                                        {{setting('currency_symbol')}}{{number_format(($item->price * $item->quantity) - $item->discount,2)}}
                                            @if (!empty($item->discount) && $item->discount > 0)
                                                <strike> {{setting('currency_symbol')}}{{number_format($item->price * $item->quantity,2)}} </strike>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="datacol text-center text-md-right">

                                    {{-- Cancel button removed per client request; other cancel button was already commented out. --}}
                                    {{-- @if ($item->order_status_id < config('constants.ORDER_STATUS.SHIPPED'))
                                    <button class="cancle-order cancel-order-btn btn btn-round" data-target="#order-status-cancel" data-toggle="modal" data-id="{{$item->id}}">
                                    <img alt="" src="{{ asset('images/cross-icon.png') }}"> {{__('messages.cancel_order')}}
                                    </button>
                                    @endif --}}

                                @if(!empty($item->tracking_url))
                                <a class="btn btn-round bluebg"href="{{$item->tracking_url}}" target="_blank">
                                <img alt="" src="{{ asset('images/truck-icon.png') }}"> track
                                </a>
                                @endif

                                    </div>
                                </div>

                              @php
                              $statusdate = $item->orderStatusHistoryById($item->id,$item->order_status_id);
                              @endphp


                                @if ($item->order_status_id != config('constants.ORDER_STATUS.DECLINED_CANCELLED'))
                                 <div class="timeline-order">
                                   <div class="checkpoint point1 finished">
                                        <div class="dots"></div>
                                        <div class="details">
                                            <span>Processed</span>
                                            <p>{{ date('F j, Y', strtotime($order->created_at)) }}</p>
                                        </div>
                                   </div>
                                   <div class="checkpoint point2 finished">
                                   <div class="dots"></div>
                                        <div class="details">
                                            <span>Preparing</span>
                                            <p>{{ date('F j, Y', strtotime($order->created_at)) }}</p>
                                        </div>
                                   </div>

                                   @if ($item->order_status_id == config('constants.ORDER_STATUS.AWAITING_PICKUP'))
                                   <div class="checkpoint point3 active">
                                      <div class="dots"></div>
                                        <div class="details">
                                            <span>Awaiting Pickup</span>
                                            @if ($statusdate['order_status_id'] == config('constants.ORDER_STATUS.AWAITING_PICKUP'))
                                            <p>{{ date('F j, Y', strtotime($statusdate['created_at'])) }}</p>
                                            @endif
                                        </div>
                                   </div>
                                   <div class="checkpoint point4">
                                      <div class="dots"></div>
                                        <div class="details">
                                            <span>delivery</span>
                                            @if ($statusdate['order_status_id'] == config('constants.ORDER_STATUS.COMPLETED'))
                                            <p>{{ date('F j, Y', strtotime($statusdate['created_at'])) }}</p>
                                            @endif
                                        </div>
                                   </div>


                                   @elseif ($item->order_status_id == config('constants.ORDER_STATUS.SHIPPED'))

                                   <div class="checkpoint point3 active">
                                      <div class="dots"></div>
                                        <div class="details">
                                            <span>Shipping</span>
                                            @if ($statusdate['order_status_id'] == config('constants.ORDER_STATUS.SHIPPED'))
                                            <p>{{ date('F j, Y', strtotime($statusdate['created_at'])) }}</p>
                                            @endif
                                        </div>
                                   </div>
                                   <div class="checkpoint point4">
                                      <div class="dots"></div>
                                        <div class="details">
                                            <span>delivery</span>
                                            @if ($statusdate['order_status_id'] == config('constants.ORDER_STATUS.COMPLETED'))
                                            <p>{{ date('F j, Y', strtotime($statusdate['created_at'])) }}</p>
                                            @endif
                                        </div>
                                   </div>


                                   @elseif ($item->order_status_id == config('constants.ORDER_STATUS.COMPLETED'))

                                   <div class="checkpoint point3 finished">
                                      <div class="dots"></div>
                                        <div class="details">
                                            <span>Shipping</span>
                                            @if ($statusdate['order_status_id'] == config('constants.ORDER_STATUS.COMPLETED'))
                                            <p>{{ date('F j, Y', strtotime($statusdate['created_at'])) }}</p>
                                            @endif
                                        </div>
                                   </div>
                                   <div class="checkpoint point4 active">
                                      <div class="dots"></div>
                                        <div class="details">
                                            <span>delivery</span>
                                            @if ($statusdate['order_status_id'] == config('constants.ORDER_STATUS.COMPLETED'))
                                            <p>{{ date('F j, Y', strtotime($statusdate['created_at'])) }}</p>
                                            @endif
                                        </div>
                                   </div>

                                   @else
                                   <div class="checkpoint point3">
                                      <div class="dots"></div>
                                        <div class="details">
                                            <span>Shipping</span>
                                            @if ($statusdate['order_status_id'] == config('constants.ORDER_STATUS.SHIPPED'))
                                            <p>{{ date('F j, Y', strtotime($statusdate['created_at'])) }}</p>
                                            @endif
                                        </div>
                                   </div>
                                   <div class="checkpoint point4">
                                      <div class="dots"></div>
                                        <div class="details">
                                            <span>delivery</span>
                                            @if ($statusdate['order_status_id'] == config('constants.ORDER_STATUS.COMPLETED'))
                                            <p>{{ date('F j, Y', strtotime($statusdate['created_at'])) }}</p>
                                            @endif
                                        </div>
                                   </div>
                                   @endif

                                </div>
                                @endif
                                <div class="clearfix"></div>
                                @if(!empty($item->tracking_number))
                              <div class="row col-md-12 alert alert-info"> Your order has been shipped via <strong>{{config('constants.SHIPPING_PROVIDERS')[$item->tracking_provider_id]}}</strong> and the tracking number is <strong>{{$item->tracking_number}}</strong> .</div>
                              @endif
                            </div>
                            <br/>
                          @endforeach
                          <div class="col-md-12 cart-data-list">

                                <div class="row two-address-row">
                                    <div class="col-12"><h4>Shipment Details:<h4></div>
                                   <div class="col-lg-4 col-md-12">
                                       <h6>{{__('messages.shipping_address')}}</h6>
                                       <p> {!! nl2br($order->getShippingAdress()) !!}</p>
                                   </div>
                                   <div class="col-lg-4 col-md-12">
                                        <h6>{{__('messages.billing_address')}}</h6>
                                       <p> {!! nl2br($order->getBillingAdress()) !!}</p>
                                   </div>
                                   @if ($order->shipping_quotes)
                                       <div class="col-lg-4 col-md-12">
                                            <h6>{{__('messages.shipping_method')}}:<br/> {{__('messages.' . $item->order->shipping_quotes)}}</h6>
                                            @if ($order->shipping_quotes ==  'own_shipping')
                                                {{__('messages.shipping_service_name')}}:<br/> {{$order->shipping_service_name}}<br>
                                                {{__('messages.shipping_account_number')}}:<br/> {{$order->shipping_account_number}}<br>
                                                {{__('messages.shipping_note')}}: {{$order->shipping_note}}<br>
                                            @elseif ($order->shipping_quotes ==  'pickup_in_store')

                                                    {{$order->store_address}}

                                            @endif
                                       </div>
                                    @endif
                                </div>

                                </div>

                                <div class="total-price-section">

                                    <h4>Order Details:</h4>
                                    <div class="categoryprice">
                                        <table>
                                            <tbody>
                                          <tr>
                                              <td> <h6>{{__('messages.item_subtotal')}}: </h6></td>
                                              <td> <i>{{setting('currency_symbol')}}{{$order->order_sub_total}}</i></td>
                                          </tr>
                                          <tr>
                                              <td>  <h6>{{__('messages.shipping_rate')}} : </h6> </td>
                                              <td><i>{{($order->shipping_total > 0) ? setting('currency_symbol').$order->shipping_total:__('messages.free_shipping')}}</i></td>
                                          </tr>
                                          @if($order->order_discount > 0)
                                          <tr>
                                              <td> <h6>{{__('messages.discount')}}: </h6></td>
                                              <td> <i>{{($order->order_discount > 0) ? setting('currency_symbol').$order->order_discount:'-'}}</i></td>
                                          </tr>
                                          @endif
                                        </tbody>
                                         <tfoot>
                                          <tr>
                                              <td> {{__('messages.order_total')}}</td>
                                              <td>{{setting('currency_symbol')}}{{$order->order_total}}</td>
                                          </tr>
                                </tfoot>
                                       </table>
                                       </div>

                                </div>
                        </div>
                    </div>
                </div>
            </div>
          @endforeach
        </div>
        <!--listing end-->
    </div>
</div>
<div class="modal" id="order-status-cancel">
    <!-- The Modal -->
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">
                    {{__('messages.order_cancellation')}}
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <!-- Modal body -->
            {!! Form::open(['route' => ['order_cancel']]) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <label>{{__('messages.cancel_reason')}}</label>
                            {!! Form::hidden("order_id", null, ['id' => 'order_id']) !!}
                            {!! Form::hidden("order_status_id", config('constants.ORDER_STATUS.DECLINED_CANCELLED')) !!}
                            {!! Form::textarea('comment', null, ['id' => 'comment','class'=>'form-control', 'placeholder' => __('messages.you_can_write_your_cancellation_reason_here')]) !!}
                            <p><strong>Note: You will need to approach Customer Care: 248-587-5600 to settle the refund.</strong></p>
                        </div>

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-primary">
                        {{__('messages.submit')}}
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>