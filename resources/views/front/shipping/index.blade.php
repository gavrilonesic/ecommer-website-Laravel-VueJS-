@if (! empty($couriers) && $shippingSettings->count() > 0)

    {!! Form::model($user, ['route' => ['shipping_calculation'],'id' => 'shipping-fee-form']) !!}
    @if ($shippingSettings->count() > 0)
            <div class="row second-step">
                @foreach ($couriers as $courier)
                    @if ($courier['rate'] !== 'N/A')
                        <div class="col-md-12 col-lg-12">
                            <div class="radioboxrow pl-4">
                                <span>
                                    {!! Form::radio('shipping_quotes', $courier['label'] . '_' . $courier['rate'], null, ['id' => "shipping_quotes_" . $courier['code'], 'class' => 'custom-control-input shipping_quotes']) !!}
                                    <label for="shipping_quotes_{{$courier['code']}}">
                                        <b>{{ $courier['label'] }}</b>: {{setting('currency_symbol')}}{{ number_format($courier['rate'], 2)}}
                                    </label>
                                </span>
                            </div>
                        </div>
                    @endif
                @endforeach
                {{-- <div class="col-md-12 col-lg-12">
                    <div class="radioboxrow">
                        <span>
                            {!! Form::radio('shipping_setting_id', $shippingSetting->id, null, ['id' => "shipping-option-{{$key}}", 'class' => 'custom-control-input shipping-setting']) !!}
                            <label for="shipping-option-{{$key}}">
                                {{$shippingSetting->title}}
                            </label>
                        </span>
                    </div>
                </div> --}}
                {{-- <div class="col-md-12 col-lg-12 shipping-quotes">
                    <div class="row">
                      <div class="col-lg-6 col-md-12">
                      {!! Form::select('shipping_quotes', [], null, ['placeholder' => __('messages.select_shipping_quotes'), 'id' => "shipping_quotes",'class' => "select2 form-control"]) !!}
                      </div>
                    </div>
                </div> --}}
            @else
                <div class="col-md-12 col-lg-12">
                    {{__('messages.we_are_not_shipping_in_your_country')}}
                </div>
            @endif
            <input id="shipping-option" class="custom-control-input" name="shipping_setting_id" type="hidden" value="">
            <div class="col-md-12 col-lg-12">
                <div class="radioboxrow pl-4">
                    <span>
                        {!! Form::radio('shipping_quotes', 'own_shipping', null, ['id' => "shipping_quotes-own-shipping", 'class' => 'custom-control-input shipping_quotes']) !!}
                        <label for="shipping_quotes-own-shipping">
                            {{__('messages.my_own_shipping_details')}}
                        </label>
                    </span>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 own-shipping">
                <div class="row">
                  <div class="col-lg-6 col-md-12">
                  {!! Form::text('shipping_account_number', null, ['id' => 'shipping_account_number', 'placeholder' => __('messages.enter_shipping_account_number') .'&nbsp;*', 'class' => "form-control"]) !!}
                  </div>
                </div>
            </div>
            @if ($pickupAvailable)
                <div class="col-md-12 col-lg-12">
                    <div class="radioboxrow pl-4">
                        <span>
                            {!! Form::radio('shipping_quotes', 'pickup-from-store_0', null, ['id' => "shipping_quotes-pickup-in-store", 'class' => 'custom-control-input shipping_quotes']) !!}
                            <label for="shipping_quotes-own-shipping">
                                {{__('messages.pickup_in_store')}}
                            </label>
                        </span>
                    </div>
                </div>
            @endif
        </div>

        @if (isset($isHazmat) && $isHazmat)
            <div class="col-md-12">
                <div class="alert alert-success my-3">
                    You have items in your cart that are considered <strong>hazardous</strong> materials. Therefore, air freight options have been removed.
                </div>
            </div>
        @endif

        <div class="col-sm-12 formfooter text-right">
            <button type="button" id="submit-shipping" class="btn btn-primary">
                <span class="spinner-border spinner-border-sm btnSpinner" role="status" aria-hidden="true" style="display: none"></span>
                {{__('messages.continue')}}
            </button>
        </div>
    {!! Form::close() !!}
    {!! $validator->selector('#shipping-fee-form') !!}
    <script type="text/javascript">
        $(".own-shipping").hide();
        $('input:radio[name="shipping_quotes"]').change(function(){
            var shipping_quotes_id = $(this).attr('id');
            if(shipping_quotes_id == 'shipping_quotes-own-shipping'){
                var id = 'own_shipping';
            }else{
                var id = shipping_quotes_id.split("-");
                var id = id[1];
            }
            $("#shipping-option").val(id);

        });
    </script>
@else
    
    @if (\App\CartStorage::canShipByAir())
        <div class="alert alert-danger">
            There is no available shipping options for your address, please provide <strong>a valid address</strong>
        </div>
    @else 
        <div class="alert alert-danger">
            There is no shipping available for your cart items.
        </div>
    @endif

    <div class="formfooter text-right">
        <input type="button" value="Edit address" class="btn btn-warning jq-prev-step" />
    </div>

@endif

