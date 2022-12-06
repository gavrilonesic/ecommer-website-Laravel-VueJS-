@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('EditAdmin') !!}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-with-nav">
                    <div class="card-header">
                        <div class="row row-nav-line">
                            <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" aria-selected="false">{{__('messages.profile')}}</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#change-password" role="tab" aria-selected="false">{{__('messages.change_password')}}</a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="v-pills-home-tab-icons">
                                        {!! Form::model(Auth::guard('admin')->user(), ['name' => 'edit-admin-form', 'method' => 'PUT', 'id' => 'edit-admin-form', 'files' => true]) !!}
                                            @csrf
                                           <div class="row">
                                                <div class="col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{__('messages.name')}} <span class="required-label">*</span></label>
                                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}
                                                        @include('admin.error.validation_error', ['field' => 'name'])
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{__('messages.email')}} <span class="required-label">*</span></label>
                                                        {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email'), 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}
                                                        @include('admin.error.validation_error', ['field' => 'email'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <div class="input-file input-file-image">
                                                            <img class="img-upload-preview" width="150" src="{{Auth::guard('admin')->user()->getMedia('admin')->first() ? Auth::guard('admin')->user()->getMedia('admin')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                                            {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                                                            <label for="image" class="label-input-file">
                                                                <span class="btn-label">
                                                                <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Image"></i>
                                                                </span>
                                                                
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                    <div class="card-action">
                                                    <a href="{{route('admin.dashboard')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                                                    <button class="btn btn-success">{{__('messages.submit')}}</button>
                                                </div>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="v-pills-profile-tab-icons">
                                        {!! Form::open(['route' => ['admin.change_password'],'name' => 'change-password-form', 'method' => 'PUT', 'id' => 'change-password-form', 'files' => true]) !!}
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label> {{__('messages.current_password')}} <span class="required-label">*</span></label>
                                                        {!! Form::password('current_password', ['id' => 'current_password', 'placeholder' => __('messages.current_password'), 'class' => "form-control " . ($errors->has('current_password') ? 'is-invalid' : '')]) !!}
                                                        @include('admin.error.validation_error', ['field' => 'current_password'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{__('messages.new_password')}} <span class="required-label">*</span></label>
                                                        {!! Form::password('new_password', ['id' => 'new_password', 'placeholder' => __('messages.new_password'), 'class' => "form-control " . ($errors->has('new_password') ? 'is-invalid' : '')]) !!}
                                                        @include('admin.error.validation_error', ['field' => 'new_password'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>{{__('messages.confirm_password')}} <span class="required-label">*</span></label>
                                                        {!! Form::password('confirm_password', ['id' => 'confirm_password', 'placeholder' => __('messages.confirm_password'), 'class' => "form-control " . ($errors->has('confirm_password') ? 'is-invalid' : '')]) !!}
                                                        @include('admin.error.validation_error', ['field' => 'confirm_password'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                    <button class="btn btn-success">{{__('messages.submit')}}</button>
                                                </div>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\AdminRequest', '#edit-admin-form') !!}
{!! JsValidator::formRequest('App\Http\Requests\AdminChangePasswordRequest', '#change-password-form') !!}
@endsection
