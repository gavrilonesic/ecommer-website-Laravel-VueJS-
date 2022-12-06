<table>
{{-- @if(!empty($cancelled) && $order->orderItems[0]->comment)
    <tr>
        <td bgcolor="#ffffff" style="padding:20px 40px; text-align:left; ">
            <p style="font-size: 13px; color:#666666; font-weight:500; font-family: 'Montserrat', sans-serif; line-height: 16px;">
                Cancel Reason: {{ $order->orderItems[0]->comment ?? '-' }}</p>
        </td>
    </tr>
@endif --}}
<tr>
    <td bgcolor="#fff" align="left" valign="top" style="padding:0 40px 20px;">
        <table class="email-container" cellspacing="0" cellpadding="0" border="0" align="center"
            style="margin: auto; background: #fff; width:100%;  ">
            <tr>
                <td align="left" valign="top" class="stack-column-center">
                    <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                        {{__('messages.order_no')}}
                    </strong>
                    <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                        #{{$order->id}}</div>
                </td>
                <td align="left" valign="top" class="stack-column-center">
                    <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                        {{__('messages.order_date')}}
                    </strong>
                    <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                        {{ date('F j, Y', strtotime($order->created_at)) }}</div>
                </td>
                <td align="left" valign="top" class="stack-column-center">
                    <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                        {{__('messages.shipping_method')}}
                    </strong>
                    <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                        @if ($order->shipping_service_name === 'UPS Ground' || $order->shipping_service_name === 'UPS 2nd Day Air')
                            {{ $order->shipping_service_name }}
                        @else
                            @if ($order->shipping_service_name == "pickup-from-store")
                                {{__('messages.pickup_from_store')}}:<br />
                                {{ setting('address_line1') ? setting('address_line1') : '12336 Emerson Dr.' }} {{ setting('address_line2') ? setting('address_line2') : '' }}<br />{{ setting('city') ? setting('city').', ' : 'Brighton, ' }} {{ setting('state') ? setting('state') : 'MI' }} {{ setting('zipcode') ? setting('zipcode').', ' : '48116' }} {{ setting('country') ? setting('country') : 'USA' }}
                            @else
                                {{__('messages.' . $order->shipping_quotes)}}
                            @endif
                        @endif
                    </div>
                    @if ($order->shipping_quotes ==  'own_shipping')
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                            {{$order->shipping_service_name}}
                        </div>
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                            {{$order->shipping_account_number}}
                        </div>                    
                    @endif
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td bgcolor="#fff" align="left" valign="top" style="padding:0 15px;">
        <table class="email-container" cellspacing="0" cellpadding="0" border="0" align="center"
            style="margin: auto; background: #f0f5f9; width:100%;  ">
            @foreach($order->orderItems as $item)
            <tr>
                <td align="left" valign="top" class="stack-column-center nopadd"
                    style="padding: 0 20px">
                    <table class="email-container" cellspacing="0" cellpadding="0" border="0"
                        align="center" style="width:100%;">
                        <tr style="border-bottom:1px solid #e6e6e6">
                            <td class="stack-column-center" style="padding: 15px 0; width:100px"
                                valign="top">
                                <img src="{{ (!empty($item->productSku->medias) ? $item->productSku->medias->getFullUrl() : (!empty($item->product->medias[0]) ? $item->product->medias[0]->getFullUrl('thumb') : asset('images/no-image/default-product-page-list.png') )) }}" width="100" style="border:1px solid #e6e6e6"/>
                            </td>
                            <td class="stack-column-center nopadd" style="padding: 15px;"
                                valign="top">
                                <h2
                                    style="text-transform: capitalize; color:#393950; font-weight:700; font-size:16px; display:block; margin:0 0 10px 0; font-family: 'Montserrat', sans-serif;">
                                    {{$item->product->name ?? '-'}}</h2>
                                <p
                                    style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; line-height: 16px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;">
                                   @if (!empty($item->product->brand->name))
                                        <strong>{{__('messages.brand')}}</strong>: {{$item->product->brand->name}}
                                    @endif
                                </p>
                                <p
                                    style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; line-height: 16px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;">
                                 @if (!empty($item->variations))
                                      @foreach ($item->variations as $key => $row)
                                        <strong>
                                          {{$key}}:
                                        </strong>
                                        {{$row}}
                                        <br/>
                                      @endforeach
                                    @endif
                                </p>
                                <p
                                    style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; line-height: 16px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;">
                                    <strong>QTY</strong>: {{$item->quantity}}
                                </p>
                            </td>
                            <td class="stack-column-center"
                                style="padding: 15px 0; width:100px " align="right"
                                valign="top">
                                <div
                                    style="text-transform: capitalize; color:#3eabe2; font-weight:600; font-size:16px; line-height: 16px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;">
                                    {{setting('currency_symbol')}}{{$item->price * $item->quantity}}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            @endforeach
        </table>
    </td>
</tr>
@if (isset($confirm))
    <tr>
        <td bgcolor="#fff" align="left" valign="top" style="padding:20px 15px;">
            <table class="email-container" cellspacing="0" cellpadding="0" border="0"
            align="center" style="width:100%;">
              <tr>
                  <td class="stack-column-center nopadd" style="padding:15px 15px 15px 0;">
                   <strong style="text-transform: uppercase; color:#666; font-weight:700; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;">{{__('messages.billing_address')}}</strong>
                   <p style="text-transform: uppercase; color:#666; font-weight:500; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;">
                    {!! $order->getBillingAdress() !!}
                   </p>
                </td>
                <td class="stack-column-center nopadd" style="padding:15px 0 15px 0;">
                    @unless ($order->shipping_service_name == "pickup-from-store")
                        <strong style="text-transform: uppercase; color:#666; font-weight:700; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;">@if($order->shipping_quotes ==  'pickup_in_store'){{__('messages.pickup_address')}}@else{{__('messages.shipping_address')}}@endif</strong>
                        <p style="text-transform: uppercase; color:#666; font-weight:500; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;">
                        {!! $order->getShippingAdress() !!}
                    @endunless
                </p>
                 </td>
                 <td class="stack-column-center nopadd" style="padding:20px 15px 10px 0px; width:225px" align="right">
                    @if (trim($order->purchase_order) !== '')
                        <div style="font-size:13px; color:#393950; line-height: 15px; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 500;display:block;margin-bottom:8px;">
                            <span style="display: inline-block">
                                PO
                            </span>
                            <span style="display: inline-block; max-width:90px; width:100%;">
                                {{ $order->purchase_order }}
                            </span>
                        </div>
                    @endif
                     <div style="font-size:13px; color:#393950; line-height: 15px; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 500;display:block;margin-bottom:8px;"><span style="display: inline-block">{{__('messages.item_subtotal')}}</span><span style="display: inline-block; max-width:90px; width:100%;">{{setting('currency_symbol')}}{{$order->order_sub_total}}</span></div>
                     @if($order->order_discount > 0)
                     <div style="font-size:13px; color:#393950; line-height: 15px; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 500;display:block;margin-bottom:8px;"><span style="display: inline-block">{{__('messages.discount')}}</span><span style="display: inline-block; max-width:90px; width:100%;">{{setting('currency_symbol')}}{{$order->order_discount}}</span></div>
                     @endif
                     @if($order->shipping_total > 0)
                     <div style="font-size:13px; color:#393950; line-height: 15px; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 500;display:block;margin-bottom:8px;"><span style="display: inline-block">{{__('messages.shipping')}}</span><span style="display: inline-block; max-width:90px; width:100%;">{{setting('currency_symbol')}}{{$order->shipping_total}}</span></div>
                     @endif
                     @if($order->hazmat_shipping_cost > 0)
                     <div style="font-size:13px; color:#393950; line-height: 15px; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 500;display:block;margin-bottom:8px;"><span style="display: inline-block">{{__('messages.hazmat_shipping_cost')}}</span><span style="display: inline-block; max-width:90px; width:100%;">{{setting('currency_symbol')}}{{$order->hazmat_shipping_cost}}</span></div>
                     @endif
                     <div style="font-size:13px; color:#393950; line-height: 15px; text-transform: uppercase; font-family: 'Montserrat', sans-serif; font-weight: 500;display:block;"><span style="font-weight:700">{{__('messages.order_total')}}</span><span style="display: inline-block; max-width:90px; width:100%;">{{setting('currency_symbol')}}{{$order->order_total}}</span></div>
                </td>
              </tr>
            </table>
        </td>
    </tr>
@endif
</table>