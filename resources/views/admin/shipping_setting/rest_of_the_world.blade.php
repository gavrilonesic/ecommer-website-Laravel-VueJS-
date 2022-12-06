<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.' . $shippingSetting['title'])}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        {!! Form::open(['name' => 'add-shipping-zone-form', 'id' => 'add-shipping-zone-form']) !!}
        <div class="modal-body">
            <div class="row">
                {!! Form::hidden("shipping_zone", request()->shippingZone, ['id' => "shipping_zone"]) !!}
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="title">{{__('messages.title')}} <span class="required-label">*</span></label>
                         {!! Form::text('title', null, ['placeholder' => __('messages.enter_title'), 'class' => "form-control"]) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript::void(0)" data-dismiss="modal" class="btn btn-danger">{{__('messages.cancel')}}</a>
            <button class="btn btn-success">{{__('messages.submit')}}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\ShippingSettingRequest', '#add-shipping-zone-form') !!}
<script type="text/javascript">
    $('#country_id').select2({
        theme: "bootstrap"
    });
</script>
