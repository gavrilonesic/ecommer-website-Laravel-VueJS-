
@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('EditVideo') !!}
        </div>
        {!! Form::model($video, ['name' => 'edit-video-form', 'method' => 'PUT', 'id' => 'edit-video-form']) !!}
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
{!! JsValidator::formRequest('App\Http\Requests\StoreVideoRequest', '#edit-video-form') !!}
@endsection