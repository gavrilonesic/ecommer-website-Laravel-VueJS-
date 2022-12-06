@extends('admin.layouts.auth')

@section('content')
<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
    <div class="container container-login container-transparent animated fadeIn">
        <h3 class="text-center">{{__('messages.reset_password')}}</h3>
        <form method="POST" action="{{ route('admin.password.request') }}" aria-label="{{__('messages.reset_password')}}" id='reset-password'>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
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
                    <div class="position-relative">
                        <input  id="password" name="password" type="password" class="form-control form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{__('messages.password')}}">
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
                <div class="form-group">
                    <label for="password-confirm" class="placeholder"><b>{{__('messages.confirm_password')}}</b></label>
                    <div class="position-relative">
                        <input id="password-confirm" type="password" class="form-control form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required placeholder="{{__('messages.confirm_password')}}">
                        <div class="show-password">
                            <i class="icon-eye"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group form-action-d-flex mb-3">
                    <div class="custom-control custom-checkbox">
                        <a href="{{route('admin.login')}}" id="show-signin" class="btn btn-danger btn-link w-100 fw-bold">{{__('messages.cancel')}}</a>
                    </div>
                    <button class="btn btn-secondary col-md-6 float-right mt-3 mt-sm-0 fw-bold">
                        {{__('messages.reset_password')}}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

{!! JsValidator::formRequest('App\Http\Requests\AdminResetPasswordRequest', '#reset-password') !!}
@endsection
