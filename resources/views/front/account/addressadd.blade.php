@extends('front.layouts.app')
@section('content')
      <!-- Main navigation row end-->
<section>
   <div class="myprofile-pg">
      <div class="container">
         <div class="row">
           <div class="col-md-12 col-lg-12">
           <h2>Add your Address</h2>
           <div class="alert alert-info po-box"><strong>{{__('messages.we_are_unable_to_deliver_to_po_box_address')}}</strong>
           </div>
                <div class="cross-btn">
                    <div class="">
                        {!! Form::open(['name' => 'add-address-form', 'id' => 'add-address-form', 'method' => 'POST']) !!}
                        {{-- {!! Form::hidden('user_id',$userid) !!} --}}
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="">
                                        {{__('messages.first_name')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('first_name', '',['placeholder' => __('messages.enter_first_name'), 'class' => 'customer_address_required form-control ' . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}
                                    @include('front.error.validation_error', ['field' => 'first_name'])
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
                                    {!! Form::text('last_name', '',['placeholder' => __('messages.enter_last_name'), 'class' => "customer_address_required form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}
                                    @include('front.error.validation_error', ['field' => 'last_name'])
                                </div>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="">
                                        {{__('messages.company_name')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('address_name', '', ['placeholder' => __('messages.enter_company_name'), 'class' => "form-control "]) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="">
                                        {{__('messages.mobile_no')}}
                                    </label>
                                     <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('mobile_no', '', ['placeholder' => __('messages.enter_mobile_no'), 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}
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
                                    {!! Form::text('address_line_1', '', ['placeholder' => __('messages.enter_address_line_1'), 'class' => "customer_address_required form-control " . ($errors->has('address_line_1') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'address_line_1'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="">
                                        {{__('messages.address_line_2')}}
                                    </label>
                                    {!! Form::text('address_line_2', '',['placeholder' => __('messages.enter_address_line_2'), 'class' => "form-control " . ($errors->has('address_line_2') ? 'is-invalid' : '')]) !!}
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
                                    {!! Form::select('country_id', $countries, null, ['placeholder' => __('messages.select_country'), 'id' => "country_id",'class' => "customer_address_required select2 country_id form-control " . ($errors->has('country_id') ? 'is-invalid' : '')]) !!}
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
                                    {!! Form::select('state_id', [], null, ['placeholder' => __('messages.select_state'), 'id' => "state_id",'class' => "customer_address_required state_id select2 form-control " . ($errors->has('state_id') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'state'])
                                    {!! Form::text('state_name', null, ['placeholder' => __('messages.enter_state'), 'id' => "state_name", 'disabled' => true,'class' => "form-control " . ($errors->has('state_name') ? 'is-invalid' : '')]) !!}
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
                                    {!! Form::text('city_name', null, ['placeholder' => __('messages.enter_city'), 'class' => "form-control " . ($errors->has('city_name') ? 'is-invalid' : '')]) !!}

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
                                    {!! Form::text('zip_code', '', ['placeholder' => __('messages.enter_zip_code'), 'class' => "customer_address_required form-control " . ($errors->has('zip_code') ? 'is-invalid' : '')]) !!}
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
                                    {!! Form::select('billing_type', config('constants.BILLING_TYPE'), null, ['id' => "billing_type_", 'class' => "customer_address_required select2 form-control " . ($errors->has('billing_type') ? 'is-invalid' : '')]) !!}
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
                                    {!! Form::select('address_type', config('constants.ADDRESS_TYPE'), '', ['id' => "address_type_",'class' => "customer_address_required select2 form-control " . ($errors->has('address_type') ? 'is-invalid' : '')]) !!}
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

                                    {{ Form::label('primary_address', 'Yes') }}
                                    {{ Form::radio('primary_address', '1', false, array('id'=>'primary_address')) }}

                                    {{ Form::label('primary_address', 'No') }}
                                    {{ Form::radio('primary_address', '0', true, array('id'=>'primary_address')) }}

                                    @include('admin.error.validation_error', ['field' => 'primary_address'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a class="btn btn-danger" href="{{route('my_addresses')}}">
                                {{__('messages.cancel')}}
                            </a>
                            <button class="btn btn-success">
                                {{__('messages.submit')}}
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\AddressRequest', '#add-address-form') !!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#state_name').hide();
    })
   $(document).on('change', '#country_id', function() {
        getstate();
    });
    // $(document).on('change', '#state_id', function() {
    //     getcity();
    // });

   function select2() {
        $('.select2').select2({
        theme: "bootstrap"
        });
    }

    function getstate(){
    $state = $("#state_id");
    $state.empty();
    $state.append(new Option("{{__('messages.select_state')}}", ''));
    $.ajax({
        type: 'POST',
        url: "{{ route('get-state') }}",
        dataType: "json",
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
                $($state).hide();
            } else {
                $(".state-asterisk").show();
                $($state).parent('div').find('input[type="text"]').hide();
                $($state).parent('div').find('input[type="text"]').attr('disabled', true);
                $($state).removeAttr('disabled');
                $($state).parent('div').find('input[type="text"]').val('');
                $($state).show();
                // $.each(response.state, function(text, key) {
                //     $state.append(new Option(key, text));
                // });
                $.each(response.state, function(text, key) {
                    $state.append(new Option(key.name, key.id));
                });
            }
        }
    });
}

// function getcity(){
// $city = $("#city_id");
// $city.empty();
// $city.append(new Option("{{__('messages.select_city')}}", ''));
//     $.ajax({
//         type: 'POST',
//         url: "{{ route('get-city') }}",
//         data: {
//             state_id: $("#state_id").val(),
//         },
//         dataType: "json",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(response) {
//             $.each(response.state, function(text, key) {
//                 $city.append(new Option(key, text));
//             });
//         }
//     });
// }


</script>
@endsection




