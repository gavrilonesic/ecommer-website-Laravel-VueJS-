@extends('admin.layouts.app')
    
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
           {!! Breadcrumbs::render('EditBlog') !!}
        </div>
        {!! Form::model($blog, ['name' => 'edit-blog-form', 'method' => 'PUT', 'id' => 'edit-blog-form', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-12">    <div class="form-group">
                                    <div class="input-file input-file-image">
                                        <img class="img-upload-preview" width="150" src="{{$blog->getMedia('blogs')->first() ? $blog->getMedia('blogs')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                        {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                                        <label for="image" class="  label-input-file">
                                            <span class="btn-label">
                                            <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('messages.add_image')}}"></i>
                                            </span>
                                        </label>
                                    </div> </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.blog_name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_blog_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>   </div>  <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="link">{{__('messages.blog_title')}}</label>
                                        {!! Form::text('title', null, ['id' => 'title', 'placeholder' => __('messages.enter_blog_title'), 'class' => "form-control " . ($errors->has('title') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'title'])
                                    </div>
                                </div>
                         
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group" id="cat">
                                        <label for="name">{{__('messages.category')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('blog_id', $blogcategory, $blog->blog_category_id, ['id' => 'blog_id', 'class' => 'form-control form-control']) !!}
                                        <input type="hidden" value="" id="blog_category_name" name="blog_category_name">
                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group" id="brand">
                                        <label for="name">{{__('messages.status')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('status', ['1' => 'Published', '0' => 'Draft'], null, ['id' => 'status', 'class' => 'form-control form-control']) !!}
                                        @include('admin.error.validation_error', ['field' => 'status'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.description')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">
                                        {{__('messages.short_description')}}
                                    </label>
                                    {!! Form::textarea('short_description', null, ['id' => 'short_description']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">
                                        {{__('messages.description')}}
                                    </label>
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
                            <a href="{{route('blog.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
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
{!! JsValidator::formRequest('App\Http\Requests\BlogRequest', '#add-blog-form') !!}
<script type="text/javascript" src="{!! asset('js/plugin/select2/select2.full.min.js') !!}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var selval = jQuery('#blog_category_id :selected').text();
         jQuery('#blog_category_name').val(selval);
        var descriptionPlaceholder = "";
        jQuery('#short_description, #description').summernote({
            placeholder: descriptionPlaceholder,
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            tabsize: 2,
            height: 300
        });

    });

    $('#blog_id').select2({
            theme: "bootstrap"
        });
    $('#status').select2({
            theme: "bootstrap"
        });

    jQuery("#blog_category_id").change(function () {
       var selval = jQuery('#blog_category_id :selected').text();
       jQuery('#blog_category_name').val(selval);
    });
</script>
@endsection
            