@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('EditBrand') !!}
        </div>
        {!! Form::model($brand, ['name' => 'edit-brand-form', 'method' => 'PUT', 'id' => 'edit-brand-form', 'files' => true]) !!}
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
                                        <label for="name">{{__('messages.brand_name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_brand_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}


                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview" width="150" src="{{$brand->getMedia('brand')->first() ? $brand->getMedia('brand')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                            {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}


                                            @if($brand->getMedia('brand')->first())
                                            <i class="icon-close remove-image"  data-toggle="tooltip" data-placement="top" title="Remove Image" data-type="brand"></i>
                                            @endif

                                            <label for="image" class="label-input-file">
                                                <span class="btn-label">
                                                    <i class="icon-plus"  data-toggle="tooltip" data-placement="top" title="{{__('messages.add_image')}}"></i>
                                                </span>
                                            </label>
                                        </div></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.search_engine_optimization')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="page_title">{{__('messages.page_title')}}</label>
                                        {!! Form::text('page_title', null, ['id' => 'page_title', 'placeholder' => __('messages.enter_page_title'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="meta_tag_keywords">{{__('messages.meta_keywords')}}</label>
                                        {!! Form::text('meta_tag_keywords', null, ['id' => 'meta_tag_keywords', 'placeholder' => __('messages.enter_meta_keywords'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="meta_tag_description">{{__('messages.meta_description')}}</label>
                                        {!! Form::text('meta_tag_description', null, ['id' => 'meta_tag_description', 'placeholder' => __('messages.enter_meta_description'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="slug">{{__('messages.url')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('slug', null, ['id' => 'slug', 'placeholder' => __('messages.url'), 'class' => "form-control" . ($errors->has('slug') ? 'is-invalid' : '')]) !!}
                                        @include('admin.error.validation_error', ['field' => 'slug'])

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{route('brand.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
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
{!! JsValidator::formRequest('App\Http\Requests\BrandRequest', '#edit-brand-form') !!}
@endsection