<!-- The Modal -->
<div class="modal-dialog inquiryformdesign">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">
                CONTACT US
            </h4>
            <button class="close" data-dismiss="modal" type="button">
                ×
            </button>
        </div>
        <!-- Modal body -->
        {!! Form::open(['name' => 'contact-form','url' => route('submit.category.inquiry',['parentCategory' => \Request::route('parentCategory')]), 'id' => 'contact_inquiry_form']) !!}

            {!! RecaptchaV3::field('first_name') !!}

            <div class="container">
                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12">
                        @php
                            if(!empty($category->email)){
                                $email = $category->email;
                            }else{
                                $email = setting('email');
                            }
                        @endphp
                        Please complete all of the information  below to help us understand your manufacturinf process and chemical requirements. You can call us at <a href="tel:{{setting('mobile_no')}}">{{setting('mobile_no')}}</a>, toll free:  <a href="tel:{{setting('toll_free_number')}}">{{setting('toll_free_number')}}</a>  fax us at {{setting('fax')}} or email us: <a href="mailto:{{$email}}" target="_top">{{$email}}</a>
                    </div>

                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="zoomIn" >
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                {{ Form::label('name', __('messages.name'),['class'=>'required']) }}
                                </div>
                                <div class="col-md-12 col-lg-6">

                                    {!! Form::text('first_name', null, ['id' => 'first_name', 'class' => "form-control no-margin-bottom" . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}
                                    {{ Form::label('first_name',__('messages.first'),['class' => 'small-fonts']) }}
                                    @include('front.error.validation_error', ['field' => 'first_name'])
                                </div>
                                <div class="col-md-12 col-lg-6">

                                    {!! Form::text('last_name', null, ['id' => 'last_name', 'class' => "form-control no-margin-bottom" . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}
                                    {{ Form::label('last_name',__('messages.last'),['class' => 'small-fonts']) }}
                                    @include('front.error.validation_error', ['field' => 'last_name'])
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    {{ Form::label('company_name', __('messages.company_name')) }}
                                    {!! Form::text('company_name', null, ['id' => 'company_name', 'class' => "form-control "]) !!}

                                    @include('front.error.validation_error', ['field' => 'company_name'])
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    {{ Form::label('email',__('messages.email'),['class'=>'required']) }}
                                    {!! Form::email('email', null, ['id' => 'email', 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}
                                    @include('front.error.validation_error', ['field' => 'email'])
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    {{ Form::label('phone',__('messages.telephone'),['class'=>'required']) }}
                                    {!! Form::tel('phone', null, ['id' => 'phone', 'class' => "form-control " . ($errors->has('phone') ? 'is-invalid' : '')]) !!}
                                    @include('front.error.validation_error', ['field' => 'phone'])
                                </div>
                                <div class="col-md-6 col-lg-12">
                                    {{ Form::label('address',__('messages.address'),['class'=>'required']) }}
                                    {!! Form::text('street_address', null, ['id' => 'street_address', 'class' => "form-control no-margin-bottom" . ($errors->has('street_address') ? 'is-invalid' : '')]) !!}
                                     {{ Form::label('street_address',__('messages.street_address'),['class' => 'small-fonts required']) }}

                                    @include('front.error.validation_error', ['field' => 'street_address'])
                                </div>
                                <div class="col-md-12 col-lg-12">

                                     {!! Form::text('address_line_2', null, ['id' => 'address_line_2',  'class' => "form-control no-margin-bottom"]) !!}
                                     {{ Form::label('name',__('messages.address_line_2'),['class' => 'small-fonts']) }}

                                    @include('front.error.validation_error', ['field' => 'address_line_2'])
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    {!! Form::text('city', null, ['id' => 'city', 'class' => "form-control no-margin-bottom" . ($errors->has('city') ? 'is-invalid' : '')]) !!}
                                     {{ Form::label('city',__('messages.city'),['class' => 'small-fonts required']) }}

                                    @include('front.error.validation_error', ['field' => 'city'])
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    {!! Form::text('state', null, ['id' => 'state', 'class' => "form-control no-margin-bottom" . ($errors->has('state') ? 'is-invalid' : '')]) !!}
                                     {{ Form::label('state',__('messages.state'),['class' => 'small-fonts required']) }}

                                    @include('front.error.validation_error', ['field' => 'state'])
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    {!! Form::text('zipcode', null, ['id' => 'zipcode', 'class' => "form-control no-margin-bottom" . ($errors->has('zipcode') ? 'is-invalid' : '')]) !!}
                                     {{ Form::label('zipcode',__('messages.zip_code'),['class' => 'small-fonts required']) }}

                                    @include('front.error.validation_error', ['field' => 'comments'])
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    {!! Form::select('country', $country, config('constants.DEFAULT_COUNTRY_ID'), ['id'=>'country','class' => "select2 form-control no-margin-bottom"])  !!}

                                     {{ Form::label('country',__('messages.country'),['class' => 'small-fonts required']) }}

                                    @include('front.error.validation_error', ['field' => 'country'])
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    {{ Form::label('process_time',__('messages.process_time')) }}
                                    {!! Form::text('process_time', null, ['id' => 'process_time', 'class' => "form-control " ]) !!}
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    {{ Form::label('temperature',__('messages.temperature')) }}
                                    {!! Form::text('temperature', null, ['id' => 'temperature', 'class' => "form-control "]) !!}
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    {{ Form::label('concentration',__('messages.concentration')) }}
                                    {!! Form::text('concentration', null, ['id' => 'concentration', 'class' => "form-control "]) !!}
                                </div>
                                <div class="col-md-12">
                                    {{ Form::label('soak',__('messages.soak')) }}
                                    {!! Form::text('soak', null, ['id' => 'soak', 'class' => "form-control "]) !!}
                                </div>
                                <div class="col-md-12">
                                    {{ Form::label('reference', __('messages.reference')) }}
                                    {!! Form::text('reference', null, ['id' => 'reference', 'class' => "form-control "]) !!}
                                </div>
                                  <div class="col-md-12">
                                    {{ Form::label('special_requirements', __('messages.special_requirements')) }}
                                    {!! Form::textarea('special_requirements', null, ['id' => 'special_requirements', 'class' => "form-control " . ($errors->has('comments') ? 'is-invalid' : '')]) !!}
                                </div>

                                <div class="col-md-12">
                                    {{ Form::label('comments', __('messages.comments')) }}
                                    {!! Form::textarea('comments', null, ['id' => 'comments','class' => "form-control " ]) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::submit('Submit', ['id' => 'contact_inquiry_form', 'class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\CategoryInquiryRequest', '#contact_inquiry_form') !!}