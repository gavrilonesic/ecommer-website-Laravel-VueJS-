@extends('admin.layouts.app')
    
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
           {!! Breadcrumbs::render('AddBlogCategory') !!}
        </div>
        {!! Form::open(['name' => 'add-blogcategory-form', 'id' => 'add-blogcategory-form', 'files' => true]) !!}
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
                                            <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('messages.add_image')}}"></i>
                                            </span>
                                        </label>
                                    </div> </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.blogcategory_name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_blog_category_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group" id="brand">
                                        <label for="name">{{__('messages.status')}}</label>
                                       {!! Form::select('status', ['1' => 'Active', '0' => 'Inactive'], null, ['id' => 'status', 'class' => 'form-control form-control']) !!}
                                        @include('admin.error.validation_error', ['field' => 'status'])
                                    </div>
                                </div>
                         
                            </div>
                        
                        </div>
                        <div class="card-action">
                                    <a href="{{route('blogcategory.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
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
{!! JsValidator::formRequest('App\Http\Requests\BlogCategoryRequest', '#add-blogcategory-form') !!}
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#status').select2({
            theme: "bootstrap"
        });
    });
</script>
@endsection