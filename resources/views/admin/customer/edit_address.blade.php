<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.edit_address')}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        {!! Form::model($address, ['url' => route('user.address.update',['address' => $address->id]),'name' => 'edit-customer-address', 'method' => 'PUT', 'id' => 'edit-customer-address', 'files' => true]) !!}
        <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.first_name')}}
                                <span class="required-label">*</span>
                            </label>
                            {!! Form::text('first_name', null, ['placeholder' => __('messages.enter_first_name'), 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'first_name'])
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.last_name')}}
                                <span class="required-label">*</span>
                            </label>

                            {!! Form::text('last_name', null, ['placeholder' => __('messages.enter_last_name'), 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'last_name'])

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.company_name')}}
                                <span class="required-label">*</span>
                            </label>
                            {!! Form::text('address_name',null, ['placeholder' => __('messages.enter_company_name'), 'class' => "form-control "]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.mobile_no')}}
                                <span class="required-label">*</span>
                            </label>
                            {!! Form::text('mobile_no', null, ['placeholder' => __('messages.enter_mobile_no'), 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'mobile_no'])
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.address_line_1')}}
                                <span class="required-label">*</span>
                            </label>

                            {!! Form::text('address_line_1', null, ['placeholder' => __('messages.enter_address_line_1'), 'class' => "form-control " . ($errors->has('address_line_1') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'address_line_1'])
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.address_line_2')}}
                            </label>
                            {!! Form::text('address_line_2', null, ['placeholder' => __('messages.enter_address_line_2'), 'class' => "form-control " . ($errors->has('address_line_2') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'address_line_2'])
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.country')}}
                                <span class="required-label">*</span>
                            </label>

                            {!! Form::select('country_id', $countries, null, ['placeholder' => __('messages.select_country'), 'id' => "edit_country_id", 'data-id' => "",'class' => "select2 country_id form-control " . ($errors->has('country_id') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'country'])
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.state')}}
                                <span class="required-label state-asterisk">*</span>
                            </label>

                            {!! Form::select('state_id', [], null, ['placeholder' => __('messages.select_state'), 'id' => "edit_state_id",'class' => "state_id select2 form-control " . ($errors->has('state_id') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'state'])
                    {!! Form::text('state_name', null, ['placeholder' => __('messages.enter_state'), 'id' => "edit_state_name", 'disabled' => true,'class' => "form-control " . ($errors->has('state_name') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'state_name'])
                        </div>
                    </div>

                </div>
                <div class="row">
                     <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.city')}}
                                <span class="required-label">*</span>
                            </label>

                            {!! Form::text('city_name', null, ['placeholder' => __('messages.enter_city'), 'class' => "form-control " . ($errors->has('city_name') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'city_name'])
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.zip_code')}}
                                <span class="required-label">*</span>
                            </label>

                            {!! Form::text('zip_code', null, ['placeholder' => __('messages.enter_zip_code'), 'class' => "form-control " . ($errors->has('zip_code') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'zip_code'])
                        </div>
                    </div>

                </div>
                <div class="row">
                     <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.addresses')}}
                                <span class="required-label">*</span>
                            </label>

                            {!! Form::select('billing_type', config('constants.BILLING_TYPE'), null, ['id' => "billing_type", 'class' => "select2 form-control " . ($errors->has('billing_type') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'billing_type'])
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">
                                {{__('messages.address_type')}}
                                <span class="required-label">*</span>
                            </label>

                            {!! Form::select('address_type', config('constants.ADDRESS_TYPE'), null, ['id' => "address_type",'class' => "select2 form-control " . ($errors->has('address_type') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'address_type'])
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="primary_address">
                                {{__('messages.primary_address')}}
                                <span class="required-label">*</span>
                            </label>

                            <div class="custom-control custom-radio">
                                {!! Form::radio('primary_address',null, false, ['id' => 'customCheck', 'class' => 'form-control custom-control-input primary_address']) !!}
                                <input class="prim_add" name="primary_address" type="hidden" value="0"/>
                                <label class="custom-control-label" for="customCheck">
                                    {{__('messages.primary_address')}}
                                </label>
                                @include('admin.error.validation_error', ['field' => 'primary_address'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

             <a href="javascript::void(0)" data-dismiss="modal" class="btn btn-danger">{{__('messages.cancel')}}</a>
            <button class="btn btn-success">
                {{__('messages.submit')}}
            </button>

        </div>
        {!! Form::close() !!}
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\AddressRequest', "#edit-customer-address") !!}
<script type="text/javascript">
    $(document).ready(function () {
         $('.select2').select2({
        theme: "bootstrap"
    });
    @if (empty($address->state_id))
        $("#edit_state_id").parent('div').find('input[type="text"]').show();
        $("#edit_state_id").parent('div').find('input[type="text"]').removeAttr('disabled');
        $(".state-asterisk").hide();
        $("#edit_state_id").attr('disabled', true);
        $("#edit_state_id").val('');
        $("#edit_state_id").parent('div').find('span.select2').hide();
    @else
      console.log($('#edit_state_name'))
      $('#edit_state_name').hide()
      address = {!! json_encode($address) !!};
     getStateFirst(address.country_id, address.state_id)
    @endif
   });
    function getStateFirst(countryId, stateId) {
        setTimeout(function() {
            var $state = $("#edit_state_id");
            $state.empty();
            $state.append(new Option("{{__('messages.select_state')}}", ''));
            $.ajax({
                type: 'POST',
                url: "{{ route('get-state') }}",
                dataType: "json",
                data: {
                    country_id: countryId,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var count = Object.keys(response.state).length;
                    if (count == 0) {
                        $(".state-asterisk").hide();
                        $($state).parent('div').find('input[type="text"]').show();
                        //$($state).parent('div').find('input[type="text"]').addClass('customer_address_required')
                        $($state).parent('div').find('input[type="text"]').removeAttr('disabled');
                        //$($state).removeClass('customer_address_required')
                        $($state).attr('disabled', true);
                        $($state).val('');
                        $($state).parent('div').find('span.select2').hide();
                    } else {
                        $(".state-asterisk").show();
                        $.each(response.state, function(text, key) {
                            $state.append(new Option(key.name, key.id));
                        });
                        $('#edit_state_id').val(stateId);
                    }
                }
            });
        }, 200)
    }

    $("#edit_country_id").change(function() {
            $state = $("#edit_state_id");

            $state.empty();

            $state.append(new Option("{{__('messages.select_state')}}", ''));
            $.ajax({
                type: 'POST',
                url: "{{ route('get-state') }}",
                dtatType: "json",
                data: {
                    country_id: $("#edit_country_id").val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                   var count = Object.keys(response.state).length;
                    if (count == 0) {
                        $(".state-asterisk").hide();
                        $($state).parent('div').find('input[type="text"]').show();
                        $($state).parent('div').find('input[type="text"]').removeAttr('disabled');
                        //$($state).removeClass('customer_address_required')
                        $($state).attr('disabled', true);
                        $($state).val('');
                        $($state).parent('div').find('span.select2').hide();
                    } else {
                        $(".state-asterisk").show();
                        $($state).parent('div').find('input[type="text"]').hide();
                        $($state).parent('div').find('input[type="text"]').attr('disabled', true);
                        $($state).removeAttr('disabled');
                        //$($state).addClass('customer_address_required')
                        //$($state).parent('div').find('input[type="text"]').removeClass('customer_address_required')
                        $('#edit_state_name-error').remove()
                        $($state).parent('div').find('input[type="text"]').val('');
                        $($state).parent('div').find('span.select2').show();
                        $.each(response.state, function(text, key) {
                            $state.append(new Option(key.name, key.id));
                        });
                    }
                }
            });
        });
     $("body").on("click", ".custom-radio", function() {
            $(".prim_add").val('0');
            $(this).find(".prim_add").val('1');
        });
</script>
