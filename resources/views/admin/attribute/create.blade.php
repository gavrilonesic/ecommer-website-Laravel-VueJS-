@extends('admin.layouts.app')
    
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('AddAttribute') !!}
        </div>
        {!! Form::open(['name' => 'add-attribute-form', 'id' => 'add-attribute-form']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.add_attribute')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="attribute_type">{{__('messages.attribute_type')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('attribute_type', config('constants.ATTRIBUTE_TYPE'), null, ['id' => 'attribute_type', 'class' => 'form-control']) !!}
                                        @include('admin.error.validation_error', ['field' => 'attribute_type'])
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">{{__('messages.options')}}</h4>

                        </div>  <div class="card-body">
                            <div class="row add-more-option">
                                <div class="col-md-6 col-lg-6 ">
                                    <div class="form-group">     
                                        <div class="row">
                                        <div class="col-sm-12">                              
                                        <span class="required-label">*</span>
                                        {!! Form::text('attribute_options[0][option]', null, ['class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}
                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div></div></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="">
                                        <button type="button" class="btn btn-primary add-more">{{__('messages.add_option')}} &nbsp; <i class="icon-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="{{route('attribute.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                            <button class="btn btn-success">{{__('messages.submit')}}</button>
                        </div>
                    </div>
                </div></div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\AttributeRequest', '#add-attribute-form') !!}
<script>
    $('#attribute_type').select2({
        theme: "bootstrap"
    });
    $('body').on('click', '.add-more', function(e){
        var html =  '<div class="col-md-6 col-lg-6"> <div class="form-group"><div class="row"><div class="col-sm-12">';
            html +=         '<input type="text" class="form-control" name="attribute_options[][option]" /></div>';
            html +=         '<button type="button" class="btn btn-link btn-danger btn-delete-option"><i class="icon-close"></i></button>'
            html += '</div></div></div></div>';
        $('.add-more-option').append(html);
    });
    $('body').on('click', '.btn-delete-option', function(e) {
        $(this).closest('div.col-md-6').remove();
    });
</script>
@endsection
