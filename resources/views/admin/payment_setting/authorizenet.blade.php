@extends('admin.layouts.app') @section('content')
<div class="content content-full">
    @include('admin.payment_setting.tab')
    <div class="page-inner">
        {!! Form::model($paymentSettings, ['name' => 'edit-payment-settings-form', 'method' => 'PUT', 'id' => 'edit-payment-settings-form']) !!}
        {{ Form::hidden('method', $paymentSetting->view) }}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div>
                                        <label>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        {!! Form::radio("ps[mode]", "0", (!empty($paymentSetting->value) && ($paymentSetting->value->mode=='0') ) ? true : false, ['id' => 'sandbox_mode', 'class' => 'custom-control-input'. ($errors->has('ps.mode') ? 'is-invalid' : '')]) !!}
                                        <label class="custom-control-label" for="sandbox_mode">
                                            {{__('messages.sandbox_mode')}}
                                        </label>
                                    </div>
                                    @include('admin.error.validation_error', ['field' => "ps.mode"])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div>
                                        <label>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        {!! Form::radio("ps[mode]", "1", (!empty($paymentSetting->value) && ($paymentSetting->value->mode=='1') ), ['id' => 'live_mode', 'class' => 'custom-control-input'. ($errors->has('ps.mode') ? 'is-invalid' : '')]) !!}
                                        <label class="custom-control-label" for="live_mode">
                                            {{__('messages.live_mode')}}
                                        </label>
                                    </div>
                                    @include('admin.error.validation_error', ['field' => "ps.mode"])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="sandbox_login_id">{{__('messages.authorizenet_sandbox_api_login_id')}}</label>
                                    {!! Form::text("ps[sandbox][login_id]",$paymentSetting->value->sandbox->login_id, ['id' => 'sandbox_login_id', 'placeholder' => __('messages.authorizenet_sandbox_api_login_id'), 'class' => "form-control " . ($errors->has('ps.sandbox.login_id') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'ps.sandbox.login_id'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="live_login_id">{{__('messages.authorizenet_live_api_login_id')}}</label>
                                    {!! Form::text("ps[live][login_id]",$paymentSetting->value->live->login_id , ['id' => 'live_login_id', 'placeholder' => __('messages.authorizenet_live_api_login_id'), 'class' => "form-control " . ($errors->has('ps.live.login_id') ? 'is-invalid' : '')]) !!} @include('admin.error.validation_error', ['field' => 'ps.live.login_id'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="sandbox_transaction_key">{{__('messages.authorizenet_sandbox_transaction_key')}}</label>
                                    {!! Form::text("ps[sandbox][transaction_key]",$paymentSetting->value->sandbox->transaction_key , ['id' => 'sandbox_transaction_key', 'placeholder' => __('messages.authorizenet_sandbox_transaction_key'), 'class' => "form-control " . ($errors->has('ps.sandbox.transaction_key') ? 'is-invalid' : '')]) !!} @include('admin.error.validation_error', ['field' => 'ps.sandbox.transaction_key'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="live_transaction_key">{{__('messages.authorizenet_live_transaction_key')}}</label>
                                    {!! Form::text("ps[live][transaction_key]",$paymentSetting->value->live->transaction_key , ['id' => 'live_transaction_key', 'placeholder' => __('messages.authorizenet_live_transaction_key'), 'class' => "form-control " . ($errors->has('ps.live.transaction_key') ? 'is-invalid' : '')]) !!} @include('admin.error.validation_error', ['field' => 'ps.live.transaction_key'])
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{route('payment_settings')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                            <button class="btn btn-success">
                                {{ __('messages.submit') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\PaymentSettingRequest', '#edit-payment-settings-form') !!}
@endsection