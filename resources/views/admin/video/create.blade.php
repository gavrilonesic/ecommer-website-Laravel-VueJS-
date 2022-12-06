
@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('AddVideo') !!}
        </div>
        {!! Form::open(['name' => 'add-video-form', 'id' => 'add-video-form', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.video_information')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="title">
                                        {{__('messages.title')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('title', null, ['id' => 'title', 'placeholder' => __('messages.title'), 'class' => "form-control " . ($errors->has('title') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'title'])
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-6">
                                <div class="form-group">
                                    <label for="video">
                                        {{__('messages.video')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::file('video', ['id' => 'video', 'placeholder' => __('messages.select_video'), 'class' => "form-control " . ($errors->has('video') ? 'is-invalid' : '')]) !!}
                                     <span class="required-label">({{__('messages.allowed_file_types')}})</span>
                                        @include('admin.error.validation_error', ['field' => 'video'])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a class="btn btn-danger fw-bold" href="{{route('video.index')}}">
                            {{__('messages.cancel')}}
                        </a>
                        <button class="btn btn-success">
                            {{__('messages.submit')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\StoreVideoRequest', '#add-video-form') !!}
@endsection