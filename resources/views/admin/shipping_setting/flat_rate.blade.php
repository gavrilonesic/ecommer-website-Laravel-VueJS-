<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.flat_rate')}}
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
                        $flatRate = $shippingSetting->value->flat_rate ?? '';
                    @endphp
                    {!! Form::hidden("id", 'flat_rate', ['id' => "flat_rate"]) !!}
                    {!! Form::hidden("shipping_charge[is_enabled]", 1) !!}
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="name">{{__('messages.shipping_rate')}} ({{setting('currency_symbol')}})<span class="required-label">*</span></label>
                            {!! Form::text("shipping_charge[shipping_rate]",  $flatRate->shipping_rate ?? null, ['placeholder' => __('messages.enter_shipping_rate'), 'class' => "form-control"]) !!}
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="name">{{__('messages.type')}} <span class="required-label">*</span></label>
                            {!! Form::select("shipping_charge[type]", \App\Helpers\Common::getShippingRateType(), $flatRate->type ?? 0, ['id' => 'type', 'class' => 'form-control select2']) !!}
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
