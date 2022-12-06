@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center formdesign">
    <div class="text-center col-md-12">
                <h2>{{ __('Login') }}</h2>
 </div>
        
        <div class="col-md-6 col-md-offset-3">

            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="login-form">
                        @csrf
                        {!! Form::hidden("slug", request()->slug) !!}
                        <div class="row">
                          <div class="col-lg-12 col-md-12">
                          <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('E-Mail Address') }} <span class="required-label">*</span></label>

                            <div class="">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                          </div>
                          <div class="col-lg-12 col-md-12">
                          <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('Password') }} <span class="required-label">*</span></label>

                            <div class="">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                           </div>
                          
                          </div>
                          <div class="col-sm-12">
                          <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 checkboxrow">
                                <span>
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </span>

                                </div>
                                <div class="col-lg-6 col-md-12 text-right">
                                    <div class="form-footer">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <a href="{{ route('register') }}" class="btn btn-primary">
                                Register
                                </a>
                                </div>
                                </div>
                            </div>
                        </div>
                          </div>
                        </div>
                        <div class="login-footer">
                        <div class="form-group row">
                          
                                    <div class="col-md-12 col-lg-12 text-lg-right text-md-center">
                                    @if (Route::has('password.request'))
                                            <a class="btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif                    
                                      <br>                         
                                           
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\AdminLoginRequest', '#login-form') !!}
@endsection
