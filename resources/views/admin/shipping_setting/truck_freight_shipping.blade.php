<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.truck_freight_shipping')}}
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
                        $shippingByWeight = $shippingSetting->value->truck_freight_shipping ?? '';
                    @endphp
                    {!! Form::hidden("id", 'truck_freight_shipping', ['id' => "truck_freight_shipping"]) !!}
                    {!! Form::hidden("shipping_charge[is_enabled]", 1) !!}
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="name">{{__('messages.charge_shipping')}} <span class="required-label">*</span></label>
                            {!! Form::select("shipping_charge[charge_shipping]", \App\Helpers\Common::getShippingChageBy(), $shippingByWeight->charge_shipping ?? null, ['id' => 'charge_shipping', 'class' => 'form-control select2']) !!}
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="name">{{__('messages.freight_name')}} <span class="required-label">*</span></label>
                            {!! Form::text("shipping_charge[freight_name]", $shippingByWeight->freight_name ?? null, ['id' => 'charge_shipping', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 d-flex align-items-center">
                        <div class="form-group">
                            <label for="name">{{__('messages.ranges')}}</label>
                        </div>
                        <a class="onlyicon ml-auto" href="javascript:void(0)" id="add-range">
                            <i class="icon-plus"  data-toggle="tooltip" title="" data-original-title="{{__('messages.add')}}">
                            </i>
                        </a>
                    </div>
                    <div class="ranges col-md-12 col-lg-12">
                        @php
                            $key = 0;
                        @endphp
                        @if (!empty($shippingByWeight->ranges))
                            @foreach($shippingByWeight->ranges as $range)
                                @include('admin.shipping_setting.range', ['key' => $key++, 'range' => $range])
                            @endforeach
                        @else
                            @include('admin.shipping_setting.range', ['key' => $key++])
                        @endif
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="name">{{__('messages.default_shipping_cost')}} <span class="required-label">*</span></label>
                            {!! Form::text('shipping_charge[default_shipping_cost]', null, ['id' => 'default_shipping_cost', 'placeholder' => __('messages.enter_default_shipping_cost'), 'class' => "form-control"]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="name">{{__('messages.type')}} <span class="required-label">*</span></label>
                            {!! Form::select('state_id', [], null, ['id' => 'state_id', 'class' => 'form-control select2', "placeholder" => __('messages.select_state')]) !!}
                        </div>
                    </div>
                </div> --}}
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
    var key = parseInt({{$key}});
    symboles = JSON.parse('{!! json_encode(\App\Helpers\Common::getShippingChageBySymbole()) !!}');
    symbol = '';
    $("#charge_shipping").select2({
        theme: "bootstrap"
    });
    $("body").on('click', '.btn-delete-range', function(e) {
        $(this).closest('div.row').remove();
    });
    $("#charge_shipping").change(function () {
        setSymbole();
    })
    function setSymbole(){
        symbol = symboles[$("#charge_shipping").val()];
        $('.sicon-class').html('('+symbol+')');
    }
    $("#add-range").click(function () {
        // alert(symbol);
        var html = `@include("admin.shipping_setting.range", ["key" => 1, "range" => null])`;
        html = html.replace(/[1]/g, key++);
        html = html.replace(/symbole/g, symbol);
        $(".ranges").append(html)
    });
    $(document).ready(function () {
        setSymbole();
        $.validator.addMethod("range_required", $.validator.methods.required, "{{__('messages.this_field_is_required')}}");
        $.validator.addClassRules({
            range_required: {
                range_required: true,
            }
        });
    });
</script>
