@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('AddCustomer') !!}
        </div>
        {!! Form::open(['name' => 'add-customer-form', 'id' => 'add-customer-form', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.customer_details')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="first_name">
                                        {{__('messages.first_name')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('first_name', null, ['id' => 'first_name', 'placeholder' => __('messages.enter_first_name'), 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'first_name'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="last_name">
                                        {{__('messages.last_name')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('last_name', null, ['id' => 'last_name', 'placeholder' => __('messages.enter_last_name'), 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'last_name'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="email">
                                        {{__('messages.email')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email'), 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'email'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="mobile_no">
                                        {{__('messages.mobile_no')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('mobile_no', null, ['id' => 'mobile_no', 'placeholder' => __('messages.enter_mobile_no'), 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'mobile_no'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="customer_group_id">
                                        {{__('messages.customer_group')}}
                                    </label>
                                    {!! Form::select('customer_group_id', $customerGroups, null, ['id' => 'customer_group_id', 'class' => 'select2 form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.customer_password')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="password">
                                        {{__('messages.password')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::password('password', ['id' => 'password', 'placeholder' => __('messages.password'), 'class' => "form-control " . ($errors->has('password') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'password'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="confirm_password">
                                        {{__('messages.confirm_password')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::password('confirm_password', ['id' => 'confirm_password', 'placeholder' => __('messages.confirm_password'), 'class' => "form-control " . ($errors->has('confirm_password') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'confirm_password'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                {{__('messages.customer_address')}}
                            </h4>
                            {{-- <button class="btn btn-primary btn-round ml-auto add-address" type="button">
                                <i class="icon-plus">
                                </i>
                                {{__('messages.add_address')}}
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body customer-address">
                       <div class="cross-btn">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.first_name')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>
                                            {!! Form::text('customer_address[first_name]', null, ['placeholder' => __('messages.enter_first_name'), 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'first_name'])
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.last_name')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>
                                            {!! Form::text('customer_address[last_name]', null, ['placeholder' => __('messages.enter_last_name'), 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'last_name'])
                                                <button class="btn btn-link btn-danger btn-delete-option" type="button">
                                        </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.enter_company_name')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>
                                            {!! Form::text('customer_address[address_name]',null, ['placeholder' => __('messages.enter_company_name'), 'class' => "form-control "]) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.mobile_no')}}
                                            </label>
                                            {!! Form::text('customer_address[mobile_no]', null, ['placeholder' => __('messages.enter_mobile_no'), 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'mobile_no'])
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                     <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.address_line_1')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>
                                            {!! Form::text('customer_address[address_line_1]', null, ['placeholder' => __('messages.enter_address_line_1'), 'class' => "form-control " . ($errors->has('address_line_1') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'address_line_1'])
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.address_line_2')}}
                                            </label>
                                            {!! Form::text('customer_address[address_line_2]', null, ['placeholder' => __('messages.enter_address_line_2'), 'class' => "form-control " . ($errors->has('address_line_2') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'address_line_2'])
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.country')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>

                                            {!! Form::select('customer_address[country_id]', $countries, null, ['placeholder' => __('messages.select_country'), 'id' => "country_id", 'data-id' => "",'class' => "select2 country_id form-control " . ($errors->has('country_id') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'country'])
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.state')}}
                                            </label>
                                            <span class="required-label state-asterisk">
                                                *
                                            </span>
                                            {!! Form::select('customer_address[state_id]', [], null, ['placeholder' => __('messages.select_state'), 'id' => "state_id",'class' => "state_id select2 form-control " . ($errors->has('state_id') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'state'])
                                            {!! Form::text('customer_address[state_name]', null, ['placeholder' => __('messages.enter_state'), 'id' => "state_name", 'class' => "form-control " . ($errors->has('state_name') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'state_name'])
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.city')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>

                                           {!! Form::text('customer_address[city_name]', null, ['placeholder' => __('messages.enter_city'), 'class' => "form-control " . ($errors->has('city_name') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'city_name'])
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.zip_code')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>
                                            {!! Form::text('customer_address[zip_code]', null, ['placeholder' => __('messages.enter_zip_code'), 'class' => "form-control " . ($errors->has('zip_code') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'zip_code'])
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.addresses')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>
                                            {!! Form::select('customer_address[billing_type]', config('constants.BILLING_TYPE'), null, ['id' => "billing_type", 'class' => "select2 form-control " . ($errors->has('billing_type') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'billing_type'])
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="">
                                                {{__('messages.address_type')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>
                                            {!! Form::select('customer_address[address_type]', config('constants.ADDRESS_TYPE'), null, ['id' => "address_type",'class' => "select2 form-control " . ($errors->has('address_type') ? 'is-invalid' : '')]) !!}

                                                @include('admin.error.validation_error', ['field' => 'address_type'])
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="primary_address">
                                                {{__('messages.primary_address')}}
                                            </label>
                                            <span class="required-label">
                                                *
                                            </span>
                                            <div class="custom-control custom-radio">
                                            {!! Form::radio('primary_address',null, false, ['id' => 'customCheck', 'class' => 'form-control custom-control-input primary_address']) !!}
                                            <input type="hidden" name="customer_address[primary_address]" class="prim_add" value="0" />
                                            <label class="custom-control-label" for="customCheck">{{__('messages.primary_address')}}</label>
                                                @include('admin.error.validation_error', ['field' => 'primary_address'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-action">
                        <a class="btn btn-danger" href="{{route('customer.index')}}">
                            {{__('messages.cancel')}}
                        </a>
                        <button class="btn btn-success">
                            {{__('messages.submit')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\CustomerRequest', "#add-customer-form") !!}
{{-- @include('admin.customer.add_address', ['formId' => "add-customer-form"]); --}}
<script type="text/javascript">
    $(document).ready(function () {

        $('#state_name').hide();
        $("#country_id").change(function() {
            $state = $("#state_id");

            $state.empty();

            $state.append(new Option("{{__('messages.select_state')}}", ''));
            $.ajax({
                type: 'POST',
                url: "{{ route('get-state') }}",
                dtatType: "json",
                data: {
                    country_id: $("#country_id").val(),
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
                        $($state).attr('disabled', true);
                        $($state).val('');
                        $($state).parent('div').find('span.select2').hide();
                    } else {
                        $(".state-asterisk").show();
                        $($state).parent('div').find('input[type="text"]').hide();
                         $($state).parent('div').find('input[type="text"]').hide();
                        $($state).parent('div').find('input[type="text"]').attr('disabled', true);
                        $($state).removeAttr('disabled');
                        $('#state_name-error').remove()
                        $($state).parent('div').find('input[type="text"]').val('');
                        $($state).parent('div').find('span.select2').show();
                        $.each(response.state, function(text, key) {
                            $state.append(new Option(key.name, key.id));
                        });
                    }
                }
            });
        });

        // $("#state_id").change(function() {
        //     $city = $("#city_id");

        //     $city.empty();

        //     $city.append(new Option("{{__('messages.select_city')}}", ''));
        //     $.ajax({
        //         type: 'POST',
        //         url: "{{ route('get-city') }}",
        //         data: {
        //             state_id: $("#state_id").val(),
        //         },
        //         dtatType: "json",
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             $.each(response.state, function(text, key) {
        //                 $city.append(new Option(key, text));
        //             });
        //         }
        //     });
        // });

         $('.select2').select2({
            theme: "bootstrap"
        });

        $("body").on("click", ".custom-radio", function() {
            $(".prim_add").val('0');
            $(this).find(".prim_add").val('1');
        });


    });

</script>
@endsection