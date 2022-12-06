@extends('front.layouts.app')
@section('content')
<section>
    <!-- contact form design start-->
    <div class="formdesign wow zoomIn" >
        <div class="container">
            <div class="text-center">
                <div class="subttl"> Please use this form to request an SDS. <br/>You will receive an email with instructions upon submission.</div>
                <h2>SDS Request Form</h2>
            </div>

            {!! Form::open(['name' => 'sds-form', 'id' => 'sds_form']) !!}

                {!! RecaptchaV3::field('name') !!}

                @honeypot
                
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'name'])
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('company_name', null, ['id' => 'company_name', 'placeholder' => __('messages.enter_company_name'), 'class' => "form-control " . ($errors->has('company_name') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'company_name'])
                    </div>
                    <div class="col-md-4">
                        {!! Form::tel('telephone', null, ['id' => 'telephone', 'placeholder' => __('messages.enter_telephone'), 'class' => "form-control " . ($errors->has('telephone') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'telephone'])
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email'), 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'email'])
                        <span class="text-info">We will supply you with information using this email.</span>
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('website', null, ['id' => 'website', 'placeholder' => __('messages.enter_website'), 'class' => "form-control " . ($errors->has('website') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'website'])
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('product', null, ['id' => 'product', 'placeholder' => __('messages.enter_product'), 'class' => "form-control " . ($errors->has('product') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'product'])
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        &nbsp;<br/>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="formfooter text-center">
                    {!! Form::submit('Submit', ['id' => 'submit_contactform', 'class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\SdsFormRequest', '#sds_form') !!}
@endsection