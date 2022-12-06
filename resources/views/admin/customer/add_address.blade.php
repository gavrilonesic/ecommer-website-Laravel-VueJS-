<div class="">
    <div class="">
          {!! Form::open(['url' => route('user.address.store',['customer' => $customer->id]),'name' => 'add-customer-addressess', 'id' => 'add-customer-addressess', 'files' => true]) !!}
        <div class="modal-body">
        <div class="row">

            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="">
                        {{__('messages.first_name')}} <span class="required-label">
                        *
                    </span>
                    </label>

                    {!! Form::text('first_name', null, ['placeholder' => __('messages.enter_first_name'), 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'first_name'])
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="">
                        {{__('messages.last_name')}}
                    <span class="required-label">
                        *
                    </span>
                    </label>
                    {!! Form::text('last_name', null, ['placeholder' => __('messages.enter_last_name'), 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'last_name'])

                </button>
                </div>

            </div>
        </div>
        <div class="row">

            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="">
                        {{__('messages.company_name')}}
                        <span class="required-label">
                            *
                        </span>
                    </label>
                    {!! Form::text('address_name',null, ['placeholder' => __('messages.enter_company_name'), 'class' => "form-control "]) !!}
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="">
                        {{__('messages.mobile_no')}}<span class="required-label">*</span>
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
                        {{__('messages.address_line_1')}} <span class="required-label">
                        *
                    </span>
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
                        {{__('messages.country')}}<span class="required-label">
                        *
                    </span>

                    </label>

                    {!! Form::select('country_id', $countries, null, ['placeholder' => __('messages.select_country'), 'id' => "country_id", 'data-id' => "",'class' => "select2 country_id form-control " . ($errors->has('country_id') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'country'])
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="">
                        {{__('messages.state')}}
                        <span class="required-label state-asterisk">
                        *
                        </span>
                    </label>
                    {!! Form::select('state_id', [], null, ['placeholder' => __('messages.select_state'), 'id' => "state_id",'class' => "state_id select2 form-control " . ($errors->has('state_id') ? 'is-invalid' : '')]) !!}

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
                        {{__('messages.city')}}<span class="required-label">
                        *
                    </span>
                    </label>

                   {!! Form::text('city_name', null, ['placeholder' => __('messages.enter_city'), 'class' => "form-control " . ($errors->has('city_name') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'city_name'])
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="">
                        {{__('messages.zip_code')}}<span class="required-label">
                        *
                    </span>
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
                        {{__('messages.addresses')}}<span class="required-label">
                        *
                    </span>
                    </label>
                    {!! Form::select('billing_type', config('constants.BILLING_TYPE'), null, ['id' => "billing_type", 'class' => "select2 form-control " . ($errors->has('billing_type') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'billing_type'])
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="">
                        {{__('messages.address_type')}}
                    <span class="required-label">
                        *
                    </span>
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
                    <span class="required-label">
                        *
                    </span>
                    </label>
                    <div class="custom-control custom-radio">
                    {!! Form::radio('primary_address',null, false, ['id' => 'customCheck', 'class' => 'form-control custom-control-input primary_address']) !!}
                    <input type="hidden" name="primary_address" class="prim_add" value="0" />
                    <label class="custom-control-label" for="customCheck">{{__('messages.primary_address')}}</label>
                        @include('admin.error.validation_error', ['field' => 'primary_address'])
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
      </div>
        {!! Form::close() !!}
    </div>
</div>