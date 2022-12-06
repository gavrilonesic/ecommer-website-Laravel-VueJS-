<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.add_attribute')}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        {!! Form::open(['name' => 'add-attribute-form', 'id' => 'add-attribute-form']) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="attribute_type">{{__('messages.attribute_type')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('attribute_type', config('constants.ATTRIBUTE_TYPE'), null, ['id' => 'attribute_type', 'class' => 'form-control']) !!}
                                        @include('admin.error.validation_error', ['field' => 'attribute_type'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">{{__('messages.options')}}</h4>
                        </div>  <div class="card-body">
                            <div class="row add-more-option">
                                <div class="col-md-6 col-lg-6 ">
                                    <div class="form-group">     
                                        <div class="row">
                                        <div class="col-sm-12">                              
                                        <span class="required-label">*</span>
                                        {!! Form::text('attribute_options[0][option]', null, ['class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}
                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div></div></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary add-more"><i class="icon-plus"></i> &nbsp; {{__('messages.add_option')}}  </button>
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
        </div>
        {!! Form::close() !!}
    </div>
</div>

{!! JsValidator::formRequest('App\Http\Requests\AttributeRequest', '#add-attribute-form') !!}
<script>
    $('#attribute_type').select2({
        theme: "bootstrap"
    });
    $(".add-more").click(function(e){
        var html =  '<div class="col-md-6 col-lg-6"> <div class="form-group"><div class="row"><div class="col-sm-12">';
            html +=         '<input type="text" class="form-control" name="attribute_options[][option]" /></div>';
            html +=         '<button type="button" class="btn btn-link btn-danger btn-delete-option"><i class="icon-close"></i></button>'
            html += '</div></div></div></div>';
        $('.add-more-option').append(html);
    });
    $('body').on('click', '.btn-delete-option', function(e) {
        $(this).closest('div.col-md-6').remove();
    });
    $("#submit").click(function() {
        if ($("#add-attribute-form").valid()) {
            var form = $("#add-attribute-form");
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    values = $("#attributes").val();
                    response = JSON.parse(response);
                    values[values.length] = response.id;
                    $("#attributes").append(new Option(response.name, response.id));
                    $("#attributes").val(values).trigger('change');
                    $(".close").trigger("click")
                }
            });
            return false;
        }
    });
</script>
