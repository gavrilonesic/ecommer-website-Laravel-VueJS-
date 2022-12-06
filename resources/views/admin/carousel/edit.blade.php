@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
           {!! Breadcrumbs::render('EditCarousel') !!}
        </div>
        {!! Form::model($carousel, ['name' => 'edit-carousel-form', 'method' => 'PUT', 'id' => 'edit-carousel-form', 'files' => true]) !!}

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
                                    <div class="input-file input-file-image">
                                        <label>{{__('messages.background_image')}}</label>
                                        <span class="required-label">*</span>
                                        <img class="img-upload-preview" width="150" src="{{$carousel->backgroundimg ? $carousel->backgroundimg->getUrl('thumb') : asset('images/150x150.png')}}" alt="preview">
                                        {!! Form::file('background_image', ['id' => 'background_image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                                        <label for="background_image" class="  label-input-file">
                                            <span class="btn-label">
                                            <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('messages.add_bg_image')}}"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-file input-file-image">
                                        <label>{{__('messages.image')}}</label>
                                        <img class="img-upload-preview" width="150" src="{{$carousel->medias ? $carousel->medias->getUrl('thumb') : asset('images/150x150.png')}}" alt="preview">
                                        {!! Form::file('image',['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                                        {!! Form::hidden('image_exists') !!}
                                        @if($carousel->medias)
                                            <i class="icon-close remove-image"  data-toggle="tooltip" data-placement="top" title="Remove Image" data-type="carousel"></i>
                                        @endif
                                        <label for="image" class="  label-input-file">
                                            <span class="btn-label">
                                            <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('messages.add_image')}}"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.heading')}}</label>
                                        {{-- <span class="required-label">*</span> --}}
                                        {!! Form::text('heading', null, ['id' => 'name', 'placeholder' => __('messages.enter_heading'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>    </div>    <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="link">{{__('messages.description')}}</label>

                                        {!! Form::text('description', null, ['id' => 'description', 'placeholder' => __('messages.enter_description'), 'class' => "form-control " . ($errors->has('description') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'description'])
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.button_text')}}</label>
                                        {{-- <span class="required-label">*</span> --}}
                                        {!! Form::text('button_text', null, ['id' => 'button_text', 'placeholder' => __('messages.enter_button_text'), 'class' => "form-control " . ($errors->has('button_text') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'button_text'])
                                    </div>    </div>    <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="link">{{__('messages.link')}}</label>
                                        {!! Form::text('link', null, ['id' => 'link', 'placeholder' => __('messages.enter_link'), 'class' => "form-control " . ($errors->has('link') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'link'])
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class="card-action">
                                    <a href="{{route('carousel.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                                    <button class="btn btn-success">{{__('messages.submit')}}</button>
                                </div>
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
{!! JsValidator::formRequest('App\Http\Requests\CarouselRequest', '#edit-carousel-form') !!}
@endsection