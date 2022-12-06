<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.order_detail')}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        @foreach($orderitem as $item)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <img src="{{ (!empty($item->productSku->medias) ? $item->productSku->medias->getFullUrl() : (!empty($item->product->medias[0]) ? $item->product->medias[0]->getFullUrl('thumb') : asset('images/no-image/default-product-page-list.png') )) }}"  alt="product_image"width="200" height="200" border="0" class="fluid"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div style="display:block;padding:0 0 10px 0;color:#2da0ed; font-size:22px; font-weight:600;    font-family: 'Nunito', sans-serif; margin-bottom: 0px;">
                                            {{$item->product->name ?? '-'}}
                                    </div>
                                    <div style="display:block;padding:0 0 0px 0;color:#000; font-size:15px; font-weight:400;    font-family: 'Nunito', sans-serif; margin-bottom: 5px;">
                                            @if (!empty($item->product->brand->name))
                                              <strong>
                                                  {{__('messages.brand')}}:
                                              </strong>
                                              {{$item->product->brand->name}}
                                              <br/>
                                            @endif
                                            
                                            @if (!empty($item->variations))
                                              @foreach ($item->variations as $key => $row)
                                                <strong>
                                                  Option :
                                                </strong>
                                                {{$row}}
                                                <br/>
                                              @endforeach
                                            @endif
                                            <div class="count">
                                                <strong>{{__('messages.quantity')}}:</strong>
                                                <span>
                                                    {{$item->quantity}}
                                                </span>
                                            </div>
                                            <div class="discount">
                                                <strong>{{__('messages.discount')}}:</strong>
                                                <span>
                                                    {{$item->discount}}
                                                </span>
                                            </div>
                                            @if (!empty($item->orderstatus->name))
                                            <div class="status">
                                                <strong>{{__('messages.status')}}:</strong>
                                                <span>
                                                    {{$item->orderstatus->name}}
                                                </span>
                                            </div>
                                            @endif
                                        </div>
                                        <div style="display:block;padding:0 0 10px 0;color:#2da0ed; font-size:22px; font-weight:600;    font-family: 'Nunito', sans-serif; margin-bottom: 0px;">
                                            {{setting('currency_symbol')}}{{$item->price * $item->quantity}}
                                        </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{__('messages.contact_information')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="name">{{__('messages.name')}}</label>
                                                        <p>{{$item->order->first_name ?? '-'}} {{$item->order->last_name ?? '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="name">{{__('messages.email')}}</label>
                                                        <p>{{$item->order->email ?? '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="name">{{__('messages.mobile_no')}}</label>
                                                        <p>{{$item->order->mobile_no ?? '-'}}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="name">{{__('messages.invoice')}}</label>
                                                        <p>{{$item->order->invoice_no ?? '-'}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-8">
                                                    <div class="form-group">
                                                        <label for="name">{{__('messages.shipping_address')}}</label>
                                                        <p>{{ $item->order->shipping_address_1 ? $item->order->shipping_address_1.', ' : '' }} {{ $item->order->shipping_address_2 ? $item->order->shipping_address_2.', ' : '' }} {{ $item->order->shipping_city ? $item->order->shipping_city.', ' : '' }} {{ $item->order->shipping_state ? $item->order->shipping_state : '' }} {{ $item->order->shipping_postcode ? $item->order->shipping_postcode.', ' : '' }} {{ $item->order->shipping_country ? $item->order->shipping_country : '' }}</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="name">{{__('messages.shipping_method')}}</label>
                                                        @if ($order->shipping_service_name == "pickup-from-store")
                                                            {{__('messages.pickup_from_store')}}: {{__('messages.pickup_address')}}
                                                        @else
                                                            <p>{{__('messages.' . $item->order->shipping_quotes)}}</p>
                                                            @if ($item->order->shipping_quotes ==  'own_shipping')
                                                                <p>{{__('messages.shipping_service_name')}}: {{$item->order->shipping_service_name}}</p>
                                                                <p>{{__('messages.shipping_account_number')}}: {{$item->order->shipping_account_number}} </p>
                                                                <p>{{__('messages.shipping_note')}}: {{$item->order->shipping_note}}</p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            

        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal" type="button">
                Close
            </button>
        </div>
    </div>
</div>