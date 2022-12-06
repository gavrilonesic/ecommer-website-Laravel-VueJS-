@extends('admin.layouts.auth')

@section('content')
<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
    <div class="container container-login container-transparent animated fadeIn">
        <h3 class="text-center">{{__('messages.reset_password')}}</h3>
        <form method="POST" action="{{ route('admin.password.email') }}" aria-label="{{__('messages.reset_password')}}" id="forgot-password">
            @csrf
            <div class="login-form">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="email" class="placeholder"><b>{{__('messages.email')}}</b></label>
                    <input id="email" type="email" class="form-control form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{__('messages.email')}}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row form-action">
                    <div class="col-md-6">
                        <a href="{{route('admin.login')}}" id="show-signin" class="btn btn-danger btn-link w-100 fw-bold">{{__('messages.cancel')}}</a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-secondary w-100 fw-bold">{{__('messages.send_link')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
{!! $validatorForm->selector('#forgot-password') !!}
@endsection
