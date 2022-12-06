<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{-- {{__('messages.add_custom_fields')}} --}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        {!! Form::open(['id' => 'copy-product-fields-form']) !!}
        <div class="modal-body">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">{{__('messages.product')}} <span class="required-label">*</span></label>
                                    {!! Form::select('product', $products, null, ['id' => "copy-products", 'class' => 'select2 form-control', "placeholder" => "Select Product"]) !!}

                                    @include('admin.error.validation_error', ['field' => 'name'])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="javascript::void(0)" data-dismiss="modal" class="btn btn-danger">{{__('messages.cancel')}}</a>
                        <button class="btn btn-success" id="submit">{{__('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
{!! JsValidator::make(["product" => "required"],[],[],'#copy-product-fields-form') !!}
<script>
    if(selectedField=='copy_custom_fields')
    {
        $("#exampleModalLabel").html("{{__('messages.add_custom_fields')}}")
    }else{
        $("#exampleModalLabel").html("{{__('messages.add_related_products')}}")
    }
    $('#copy-products').select2({
        theme: "bootstrap",
    });
    $("#submit").click(function() {
        if ($("#copy-product-fields-form").valid()) {
            var form = $("#copy-product-fields-form");
            var url = form.attr('action');
            var formSerialize = form.serialize();
            formSerialize += "&field=" + selectedField;
            $.ajax({
                type: "POST",
                url: url,
                data: formSerialize, // serializes the form's elements.
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    response = JSON.parse(response);
                    // console.log(response);
                    if (selectedField == "copy_custom_fields" && response.custom_fields) {
                        var customFields = response.custom_fields;
                        for (key in customFields) {
                            for (values in customFields[key]) {
                                addCustomField(key, customFields[key][values])
                            }
                        }
                    } else if (selectedField == "copy_related_products") {
                        var products = response.related_products;
                        var values = $("#related_product_id").val();
                        // console.log(values);
                        for (key in products) {
                            values[values.length] = products[key].related_product_id;
                        }
                        $("#related_product_id").val(values).trigger('change');

                    }
                    $(".close").trigger('click');
                }
            });
            return false;
        }
    });
</script>
