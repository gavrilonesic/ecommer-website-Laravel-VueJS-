@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('EditTestimonial') !!}
        </div>
        {!! Form::model($testimonial, ['name' => 'edit-testimonial-form', 'method' => 'PUT', 'id' => 'edit-testimonial-form', 'files' => true]) !!}
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
                                            <img class="img-upload-preview" width="150" src="{{$testimonial->getMedia('testimonial')->first() ? $testimonial->getMedia('testimonial')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                            {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                                            @if($testimonial->getMedia('testimonial')->first())
                                            <i class="icon-close remove-image"  data-toggle="tooltip" data-placement="top" title="Remove Image" data-type="testimonial"></i>
                                            @endif
                                            <label for="image" class="label-input-file">
                                                <span class="btn-label">
                                                <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add Image"></i>
                                                </span>
                                              <!--  {{__('messages.upload_image')}} -->
                                            </label>
                                        </div> </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.title')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('title', null, ['id' => 'title', 'placeholder' => __('messages.enter_title'), 'class' => "form-control " . ($errors->has('title') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>   </div>      <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.date')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('date', null, ['id' => 'date', 'placeholder' => __('messages.enter_date'), 'class' => "form-control " . ($errors->has('date') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'date'])
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.author_name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('author', null, ['id' => 'author', 'placeholder' => __('messages.enter_author_name'), 'class' => "form-control " . ($errors->has('author') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'author'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.status')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('status', config('constants.STATUS_LIST'), null, ['id' => 'status', 'class' => 'form-control select2']) !!}

                                        @include('admin.error.validation_error', ['field' => 'status'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="description">{{__('messages.description')}}</label>
                                        {!! Form::textarea('description', null, ['id' => 'description', 'class' => 'form-control ' . ($errors->has('description') ? 'is-invalid' : '')]) !!}
                                        @include('admin.error.validation_error', ['field' => 'description'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{route('testimonial.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
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
<!-- <script src="{{ asset('js/plugin/summernote/summernote-bs4.min.js') }}"></script> -->
<script type="text/javascript" src="{!! asset('js/plugin/datepicker/bootstrap-datetimepicker.min.js') !!}"></script>
{!! JsValidator::formRequest('App\Http\Requests\TestimonialRequest', '#edit-testimonial-form') !!}
<script>
    $('.select2').select2({
        theme: "bootstrap"
    });
    // $('#description').summernote({
    //     placeholder: "{{__('messages.description')}}",
    //     fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
    //     tabsize: 2,
    //     height: 300
    // });
    $('#date').datetimepicker({
        format: 'YYYY/MM/DD',
    });
</script>
@endsection
