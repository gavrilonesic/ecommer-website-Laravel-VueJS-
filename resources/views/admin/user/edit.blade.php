@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('EditAdminUser') !!}
        </div>
        {!! Form::model($user, ['name' => 'edit-admin-user-form', 'method' => 'PUT', 'id' => 'edit-admin-user-form', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="input-file input-file-image">
                                        <img class="img-upload-preview" width="150" src="{{$user->getMedia('admin')->first() ? $user->getMedia('admin')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                        {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}

                                        @if($user->getMedia('admin')->first())
                                        <i class="icon-close remove-image"  data-toggle="tooltip" data-placement="top" title="Remove Image" data-type="admin"></i>
                                        @endif
                                        <label for="image" class="label-input-file">
                                            <span class="btn-label">
                                            <i class="icon-plus"  data-toggle="tooltip" data-placement="top" title="Add Image"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('messages.email')}} <span class="required-label">*</span></label>
                                        {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email'), 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}
                                        @include('admin.error.validation_error', ['field' => 'email'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('messages.role')}} <span class="required-label">*</span></label>
                                        {!! Form::select('role_id', config('constants.ROLES'), 2, ['id' => 'role_id', 'placeholder' => __('messages.select_role'), 'class' => 'select2 form-control']) !!}
                                        @include('admin.error.validation_error', ['field' => 'role_id'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('messages.password')}} <span class="required-label">*</span></label>
                                        {!! Form::password('password', ['id' => 'password', 'placeholder' => __('messages.enter_password'), "value" => "", 'class' => "form-control " . ($errors->has('password') ? 'is-invalid' : '')]) !!}
                                        @include('admin.error.validation_error', ['field' => 'password'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('messages.confirm_password')}} <span class="required-label">*</span></label>
                                        {!! Form::password('confirm_password', ['id' => 'confirm_password', 'placeholder' => __('messages.enter_confirm_password'), 'class' => "form-control " . ($errors->has('confirm_password') ? 'is-invalid' : '')]) !!}
                                        @include('admin.error.validation_error', ['field' => 'confirm_password'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card permissions">
                        <div class="card-header">
                            <h4 class="card-title">
                                {{__('messages.permissions')}}
                            </h4>
                        </div>
                        @php
                            $userPermissions = array_column($user->permissions->toArray(), 'permission_id');
                        @endphp
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group expand-collapse">
                                        <button class="btn-link ml-auto" data-toggle="modal" type="button" id="expand-all">
                                        <i class="icon-plus"></i> {{__('messages.expand_all')}}
                                        </button>
                                        <button class="btn-link ml-auto" data-toggle="modal" type="button" id="collapse-all">
                                        <i class="icon-minus"></i> {{__('messages.collapse_all')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-check checkboxdesign">
                                            <ul class="row">
                                            @include('admin.user.permission',['childs' => $permissions, 'parent' => 0])
                                            </ul>
                                    </div> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="{{route('user.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                        <button class="btn btn-success">{{__('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\BrandRequest', '#edit-admin-user-form') !!}
<script type="text/javascript">
    $('.select2').select2({
        theme: "bootstrap"
    });
    $('.custom-control-input').click(function(){
        checked = false;
        if ($(this).is(':checked') === true) {
            checked = true
        }
        var parentUl = $(this).closest('ul'), parentChecked = true;
        $(parentUl).find('.custom-control-input').each(function( index ) {
            if ($(this).is(':checked') !== true) {
                parentChecked = false;
            }
        });
        $(parentUl).closest('li').find('.custom-control-input').first().prop('checked', parentChecked);
        $(this).closest('li').find('.custom-control-input').prop('checked', checked);
    });
    $("#role_id").change(function() {
        if ($(this).val() == 2) {
            $(".permissions").show();
        } else {
            $(".permissions").hide();
        }
    });
    $("#role_id").change();
</script>
@endsection