@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
           {!! Breadcrumbs::render('AddReview') !!}
        </div>
        {!! Form::open(['name' => 'add-review-form', 'method' => 'POST', 'id' => 'add-review-form']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.review_title')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('review_title', null, ['id' => 'review_title', 'placeholder' => __('messages.enter_review_title'), 'class' => "form-control " . ($errors->has('review_title') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'review_title'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.author_name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('author', null, ['id' => 'author', 'placeholder' => __('messages.enter_author_name'), 'class' => "form-control " . ($errors->has('author') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'author'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="link">{{__('messages.review_description')}}</label>
                                        {!! Form::textarea('review_description', null, ['id' => 'review_description', 'placeholder' => __('messages.enter_review_description'), 'class' => "form-control " . ($errors->has('review_description') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'review_description'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group" id="">
                                        <label for="name">{{__('messages.status')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('status', config('constants.REVIEW_STATUS'), null, ['id' => 'status', 'class' => 'form-control select2']) !!}
                                        @include('admin.error.validation_error', ['field' => 'status'])
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group" id="">
                                        <label for="rating">{{__('messages.rating')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('rating', config('constants.REVIEW_RATING'), null, ['id' => 'rating', 'class' => 'form-control select2']) !!}
                                        @include('admin.error.validation_error', ['field' => 'rating'])
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group icon-calendr-position">
                                        <label>{{__('messages.publish_date')}}</label>
                                        <div class="input-group">
                                            {!! Form::text('publish_date',null, ['id' => 'publish_date', 'placeholder' => __('messages.publish_date'), 'class' => 'form-control']) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-lg-5">
                                    <div class="form-group" id="">
                                        <label for="rating">{{__('messages.products')}}</label>
                                        {!! Form::select('product_id', $products, $products, ['id' => 'products_select', 'class' => 'form-control select2']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <a href="{{route('review.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                                <button class="btn btn-success">{{__('messages.submit')}}</button>
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
{!! JsValidator::formRequest('App\Http\Requests\ReviewRequest', '#add-review-form') !!}
<script type="text/javascript" src="{!! asset('js/plugin/datepicker/bootstrap-datetimepicker.min.js') !!}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap"
        });
        $('#publish_date').datetimepicker({
            format: 'YYYY/MM/DD',
            defaultDate: new Date(),
        });
    });
</script>
@endsection
