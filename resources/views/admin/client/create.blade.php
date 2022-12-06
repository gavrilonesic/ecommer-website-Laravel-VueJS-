@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('AddClient') !!}
        </div>
        {!! Form::open(['name' => 'add-client-form', 'id' => 'add-client-form', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.status')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('active', config('constants.STATUS_LIST'), null, ['id' => 'active', 'class' => 'form-control select2']) !!}

                                        @include('admin.error.validation_error', ['field' => 'active'])
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="form-group">
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview" width="150" src="{{asset('images/150x150.png')}}" alt="preview">
                                            {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                                            <label for="image" class="label-input-file float-left">
                                                <span class="btn-label">
                                                <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Image"></i>
                                                </span>
                                            <!--  {{__('messages.upload_image')}} -->
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{route('client.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                            <button class="btn btn-success">{{__('messages.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('script')
{!! JsValidator::formRequest('App\Http\Requests\ClientRequest', '#add-client-form') !!}
<script>
    $('.select2').select2({ theme: 'bootstrap' });
</script>
@endsection
