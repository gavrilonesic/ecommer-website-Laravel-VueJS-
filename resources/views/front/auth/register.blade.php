@extends('front.layouts.app')

@section('content')
<section>
    <div class="container">
      <div class="registerform formdesign">

         <div class="row">
             <div class="col-sm-12 text-center">   <h2>
                  Your Personal Details
               </h2></div>
               <div class="col-sm-12">
               <div class="card">
                    <div class="card-body">
               {!! Form::open(['name' => 'add-register-form', 'id' => 'add-register-form', 'files' => false]) !!}

              <div class="row">
                <div class="col-lg-6 col-md-12">
                <label>First Name <span class="required-label">*</span></label>
               {!! Form::text('first_name', null, ['id' => 'first_name', 'placeholder' => __('messages.enter_first_name'), 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}     </div>

               <div class="col-lg-6 col-md-12">
               <label>Last Name <span class="required-label">*</span></label>
               {!! Form::text('last_name', null, ['id' => 'last_name', 'placeholder' => __('messages.enter_last_name'), 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}     </div>

               <div class="col-lg-6 col-md-12">
               <label>Email <span class="required-label">*</span></label>
               {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email'), 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}     </div>

               <div class="col-lg-6 col-md-12"><label>Mobile Number</label>
               {!! Form::text('mobile_no', null, ['id' => 'mobile_no', 'placeholder' => __('messages.enter_mobile_no'), 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}     </div>

               <div class="col-lg-6 col-md-12"><label>Password <span class="required-label">*</span></label>
               {!! Form::password('password', ['id' => 'password', 'placeholder' => __('messages.password'), 'class' => "form-control " . ($errors->has('password') ? 'is-invalid' : '')]) !!}     </div>

               <div class="col-lg-6 col-md-12"><label>Confirm Password <span class="required-label">*</span></label>
               {!! Form::password('confirm_password', ['id' => 'confirm_password', 'placeholder' => __('messages.confirm_password'), 'class' => "form-control " . ($errors->has('confirm_password') ? 'is-invalid' : '')]) !!}
               </div>

            <div class="col-sm-12 checkboxrow">
                    <span>
                        {!! Form::checkbox('terms', null, ['class' => "form-control " . ($errors->has('terms') ? 'is-invalid' : '')]) !!}
                        <label for="address">
                           Agree to
                        </label>
                    </span>
                    <a href="{{ route('pages.slug', ['slug' => 'terms-conditions']) }}" target="_blank" class="termslink">{{__('messages.terms_and_conditions')}}</a>
                </div>
                <div class="col-sm-12 formfooter text-center">
                    <button type="submit"  id="submit-address" class="btn btn-primary">
                        {{__('messages.register_account')}}
                    </button>
                </div>
         </div></div>
         {!! Form::close() !!}
      </div>
   </div>
   </div>
   </div></div>
</section>
@endsection

<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="new-password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\CustomerRequest', '#add-register-form') !!}
<script type="text/javascript" src="{!! asset('js/plugin/select2/select2.full.min.js') !!}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#reg_country_id').select2({
            theme: "bootstrap"
        });
    });
</script>
@endsection
