@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('AddCmsPage') !!}
        </div>
        {!! Form::open(['name' => 'add-cms-page-form', 'id' => 'add-cms-page-form', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-12">  <div class="form-group">
                                        <div class="input-file input-file-image">
                                            <img class="img-upload-preview" width="150" src="{{asset('images/150x150.png')}}" alt="preview">
                                            {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                                            <label for="image" class="  label-input-file">
                                                <span class="btn-label">
                                                <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Image"></i>
                                                </span>
                                                <!-- {{__('messages.upload_image')}} -->
                                            </label>
                                        </div> </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.title')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('title', null, ['id' => 'title', 'placeholder' => __('messages.enter_title'), 'class' => "form-control " . ($errors->has('title') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'title'])
                                    </div>
                                </div>
                           
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="description">{{__('messages.description')}}</label>
                                        {!! Form::textarea('description', null, ['id' => 'description']) !!}
                                    </div>
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
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{route('cms_page.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
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
<script src="{{ asset('js/plugin/summernote/summernote-bs4.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CmsPageRequest', '#add-cms-page-form') !!}
<script>
    $('#description').summernote({
        placeholder: "{{__('messages.description')}}",
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
        tabsize: 2,
        height: 300
    });
</script>
@endsection