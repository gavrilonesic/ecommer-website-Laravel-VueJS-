@extends('front.layouts.app')

@section('content')
<section>
    <div class="cartpage">
        <div class="container">
            <div class="text-center">
                <h2>
                    {{__('messages.your_order_place_order')}}
                </h2>
                <div class="row">
                  @if (!empty($order))
                      <div class="col-md-8  wow slideInLeft ">
                        <div class="cart-data">
                          @foreach($order->orderItems as $item)

                            <div class="col-md-12 cart-data-list">
                                <div class="row text-left">
                                    <div class="imgbox datacol">
                                        <img src="{{ (!empty($item->productSku->medias) ? $item->productSku->medias->getUrl() : (!empty($item->product->medias[0]) ? $item->product->medias[0]->getUrl() : asset('images/no-image/default-new-arrival-home.png'))) }}" alt="" title=""/>
                                    </div>
                                    <div class="detailbox datacol">
                                        <h5>{{$item->product->name ?? '-'}}</h5>
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
                                               @endforeach
                                        @endif
                                        <br>
                                        <div class="">
                                            <strong>{{__('messages.quantity')}}</strong>
                                            <span>
                                                {{$item->quantity}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="add-remove-row datacol">
                                        <div class="price">
                                            {{setting('currency_symbol')}}<span>{{$item->price * $item->quantity}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endforeach
                        </div>
                    </div>
                    <div class="col-md-4 wow slideInRight ">
                        {{-- <div class="couponbox">
                            <input type="text" placeholder="Enter Your Code" id="coupon_code" />
                            <button type="button" id="apply-coupon" class="btn btn-round">
                                {{__('messages.apply_coupon')}}
                            </button>
                            <br/>
                            <span id="coupon-error"></span>
                        </div> --}}
                        <div class="pricedetail text-left">
                            <h5>
                                {{__('messages.price_details')}}
                            </h5>
                            <div class="content">
                                <table>
                                    <tr>
                                        <td>
                                            {{__('messages.price')}} ({{ array_sum(array_column($order->orderItems->toArray(), 'quantity'))}} {{__('messages.items')}})
                                        </td>
                                        <td>
                                            {{setting('currency_symbol')}}<span id="total-price">{{$order->order_sub_total}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{__('messages.shipping_fee')}}
                                        </td>
                                        <td>
                                            <span id="shipping-charge">
                                                {{ !empty($order->shipping_total) ? setting('currency_symbol') . $order->shipping_total : __('messages.free')}}
                                            </span>
                                        </td>
                                    </tr>

                                    @if (trim($order->purchase_order) !== '')
                                        <tr>
                                            <td class="text-nowrap">
                                                PO
                                            </td>
                                            <td>
                                                <span>{{ $order->purchase_order }}</span>
                                            </td>
                                        </tr>
                                    @endif

                                    @if (isset($order->hazmat_shipping_cost) && $order->hazmat_shipping_cost > 0)
                                        <tr>
                                            <td class="text-nowrap">
                                                {{__('messages.hazmat_shipping_cost')}}
                                            </td>
                                            <td>
                                                <span>${{ $order->hazmat_shipping_cost }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                    @if (!empty($order->shipping_quotes) && $order->shipping_service_name == 'pickup-from-store')
                                        <tr class="pickup-from-store">
                                            <th colspan="2" class="text-left">
                                                {{__('messages.pickup_from_store')}} <br />
                                            </th>
                                        </tr>
                                        <tr class="pickup-from-store">
                                            <td colspan="2" class="text-left" id="store-address">
                                                {{ setting('address_line1') ? setting('address_line1') : '12336 Emerson Dr.' }} {{ setting('address_line2') ? setting('address_line2') : '' }}<br />{{ setting('city') ? setting('city').', ' : 'Brighton, ' }} {{ setting('state') ? setting('state') : 'MI' }} {{ setting('zipcode') ? setting('zipcode').', ' : '48116' }} {{ setting('country') ? setting('country') : 'USA' }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th colspan="2" class="text-left">
                                            {{__('messages.address')}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-left">
                                            {{$order->shipping_address_1 . ", "}}
                                            {{!empty($order->shipping_address_2) ? $order->shipping_address_2 .  ", " : ''}}
                                            {{$order->shipping_city . ", "}}
                                            {{$order->shipping_state . ", "}}
                                            {{$order->shipping_postcode . ", "}}
                                            {{$order->shipping_country . ", "}}
                                        </td>
                                    </tr>
                                    <tr class="discount {{ ($order->order_discount > 0) ? '':'d-none'}}">
                                        <td>
                                            {{__('messages.discount')}}
                                        </td>
                                        <td>
                                            {{setting('currency_symbol')}}{{$order->order_discount}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{__('messages.total_payable')}}
                                        </th>
                                        <th>
                                            {{setting('currency_symbol')}}{{$order->order_total}}
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    try {
        dataLayer.push({
            'event': 'Sale',
            'conversionValue': {{ number_format($order->order_sub_total, 2, '.', '') }},
            'transactionId': '{{ (string) $order->id }}'
        });
    } catch (e) {

    }

    try {

        dataLayer.push({
            'event': 'purchase',
            'value': {{ number_format($order->order_sub_total, 2, '.', '') }},
            'ecommerce': {
                'purchase': {
                    'actionField': {
                        'id': @json($order->id),
                        'affiliation': @json(config('app.name')),
                        'revenue': {{ number_format($order->order_sub_total, 2, '.', '') }},
                        'tax': {{ number_format($order->tax_total, 2, '.', '') }},
                        'shipping': {{ number_format($order->shipping_total, 2, '.', '') }}
                    },
                    'products': [
                        @foreach ($order->orderItems as $item)
                            {
                                "id": @json($item->product_id),
                                "name": @json($item->product->name),
                                "category": @json($item->product->categories->first() !== null ? $item->product->categories->first()->name ?? '' : ''),
                                "quantity": {{ (int) $item->quantity }},
                                "price": {{ number_format($item->price, 2, '.', '') }}
                            }
                            @if(! $loop->last)
                            ,
                            @endif

                        @endforeach
                    ]
                }
            }
        });

    } catch(e) {
        console.log(e)
    }

</script>

@endsection
