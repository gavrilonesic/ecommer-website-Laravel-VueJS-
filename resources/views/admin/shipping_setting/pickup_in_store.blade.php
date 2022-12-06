<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.pickup_in_store')}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        {!! Form::open(['name' => 'shipping-form', 'id' => 'shipping-form']) !!}
            <div class="modal-body">
                <div class="row">
                    @php
                        $pickupInStore = $shippingSetting->value->pickup_in_store ?? '';
                    @endphp
                    {!! Form::hidden("id", 'pickup_in_store', ['id' => "pickup_in_store"]) !!}
                    {!! Form::hidden("shipping_charge[is_enabled]", 1) !!}
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="name">{{__('messages.pickup_address')}} <span class="required-label">*</span></label>
                            {!! Form::text("shipping_charge[store_address]",  $pickupInStore->store_address ?? null, ['placeholder' => __('messages.enter_pickup_address'), 'class' => "form-control"]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript::void(0)" data-dismiss="modal" class="btn btn-danger">{{__('messages.cancel')}}</a>
                <button class="btn btn-success submit-shipping">{{__('messages.submit')}}</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\ShippingQuotesRequest', '#shipping-form') !!}
<script type="text/javascript">
   $("#type").select2({
        theme: "bootstrap"
    });
</script>
