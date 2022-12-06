@extends('admin.layouts.auth')

@section('content')
<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
    <div class="container container-login container-transparent animated fadeIn">
        <h3 class="text-center">{{__('messages.sign_in_admin')}}</h3>
        <form method="POST" action="{{ route('admin.login') }}" aria-label="{{ __('messages.login') }}" id="admin-login">
        @csrf
            <div class="login-form">
                <div class="form-group">
                    <label for="email" class="placeholder"><b>{{__('messages.email')}}</b></label>
                    <input id="email" type="email" class="form-control form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{__('messages.email')}}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password" class="placeholder"><b>{{__('messages.password')}}</b></label>
                    <a href="{{ route('admin.password.request') }}" class="link float-right">{{__('messages.forgot_password')}}</a>
                    <div class="position-relative">
                        <input id="password" type="password" class=" form-control form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{__('messages.password')}}" required>
                        <div class="show-password">
                            <i class="icon-eye"></i>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group form-action-d-flex mb-3">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label m-0" for="remember">{{__('messages.remember_me')}}</label>
                    </div>
                    <button class="btn btn-primary col-md-5 float-right mt-3 mt-sm-0 fw-bold">{{__('messages.sign_in')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\AdminLoginRequest', '#admin-login') !!}
@endsection