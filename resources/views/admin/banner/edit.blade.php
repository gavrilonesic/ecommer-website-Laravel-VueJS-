@extends('admin.layouts.app')
    
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
           {!! Breadcrumbs::render('EditBanner') !!}
        </div>
        {!! Form::model($banner, ['name' => 'edit-banner-form', 'method' => 'PUT', 'id' => 'edit-banner-form', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-12"><div class="form-group">
                                    <div class="input-file input-file-image">
                                        <img class="img-upload-preview" width="150" src="{{$banner->getMedia('banner')->first() ? $banner->getMedia('banner')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                        {!! Form::file('image', ['id' => 'image', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                                        @php ($img = $banner->getMedia('banner')->first()->getUrl())
                                        {!! Form::hidden('image_exists',$img) !!}
                                        <label for="image" class="label-input-file ">
                                            <span class="btn-label">
                                            <i class="icon-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('messages.add_image')}}"></i>
                                            </span>
                                        </label>
                                    </div> </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.banner_name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_banner_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>  </div> <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="link">{{__('messages.banner_link')}}</label>
                                        {!! Form::text('link', null, ['id' => 'link', 'placeholder' => __('messages.enter_banner_link'), 'class' => "form-control " . ($errors->has('link') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'link'])
                                    </div>
                                </div>
                           
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.visibility')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="price_type">{{__('messages.type')}}</label>
                                            <span class="required-label">*</span>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('type', 0, null, ['id' => 'small-width', 'class' => 'custom-control-input']) !!} 
                                            <label class="custom-control-label" for="small-width">{{__('messages.small_width')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('type', 1, null, ['id' => 'full-width', 'placeholder' => __('messages.enter_coupon_name'), 'class' => 'custom-control-input']) !!}
                                            <label class="custom-control-label" for="full-width">{{__('messages.full_width')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="">{{__('messages.position')}}</label>
                                            <span class="required-label">*</span>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('position', 0, true, ['id' => 'position-top', 'class' => 'custom-control-input']) !!} 
                                            <label class="custom-control-label" for="position-top">{{__('messages.top')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('position', 1, null, ['id' => 'position-left', 'class' => 'custom-control-input']) !!}
                                            <label class="custom-control-label" for="position-left">{{__('messages.left')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="price_type">{{__('messages.show_on_page')}}</label>
                                            <span class="required-label">*</span>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('show_on_page', 'home_page', null, ['id' => 'home_page', 'class' => 'custom-control-input']) !!} 
                                            <label class="custom-control-label" for="home_page">{{__('messages.home_page')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('show_on_page', 'for_specific_category', null, ['id' => 'for_specific_category', 'placeholder' => __('messages.enter_coupon_name'), 'class' => 'custom-control-input']) !!}
                                            <label class="custom-control-label" for="for_specific_category">{{__('messages.for_specific_category')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('show_on_page', 'for_specific_brand', null, ['id' => 'for_specific_brand', 'class' => 'custom-control-input']) !!}
                                            <label class="custom-control-label" for="for_specific_brand">{{__('messages.for_specific_brand')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('show_on_page', 'display_in_all_page', null, ['id' => 'display_in_all_page', 'placeholder' => __('messages.display_in_all_page'), 'class' => 'custom-control-input']) !!}
                                            <label class="custom-control-label" for="display_in_all_page">{{__('messages.display_in_all_page')}}</label>
                                        </div>
                                        @include('admin.error.validation_error', ['field' => 'show_on_page'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6" id="cat_banner">
                                    <div class="form-group" id="cat">
                                        <label for="name">{{__('messages.category')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('category_id', $categories, null, ['id' => 'category', 'class' => 'form-control form-control']) !!}
                                        <input type="hidden" value="" id="category_name" name="category_name">
                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                    <div class="form-group" id="brand">
                                        <label for="name">{{__('messages.brand')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::select('brand_id', $brands, null, ['id' => 'brand', 'class' => 'form-control form-control']) !!}
                                        <input type="hidden" value="" id="brand_name" name="brand_name">
                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="price_type">{{__('messages.date_range')}}</label>
                                            <span class="required-label">*</span>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('date_range_option', '1', null, ['id' => 'show_until_i_remove', 'class' => 'custom-control-input']) !!} 
                                            <label class="custom-control-label" for="show_until_i_remove">{{__('messages.show_until_i_remove')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('date_range_option', '0', null, ['id' => 'specific_dates', 'class' => 'custom-control-input']) !!}
                                            <label class="custom-control-label" for="specific_dates">{{__('messages.specific_dates')}}</label>
                                        </div>
                                        @include('admin.error.validation_error', ['field' => 'show_on_page'])
                                    </div>
                                </div>
                                <div class="row col-md-6" id="dates_section">
                                   <div class="form-group col-md-6 col-lg-6">
                                        <label>{{__('messages.date_start')}}</label>
                                        <div class="input-group">
                                            {!! Form::text('date_start', null, ['id' => 'date_start', 'placeholder' => __('messages.date_start'), 'class' => 'form-control']) !!}
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="icon-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6">
                                            <label for="name">{{__('messages.date_end')}}</label>
                                            <div class="input-group">
                                                {!! Form::text('date_end', null, ['id' => 'date_end', 'placeholder' => __('messages.date_end'), 'class' => 'form-control']) !!}
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="icon-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label for="price_type">{{__('messages.visible_on_site')}}</label><br>
                                        <div class="custom-control custom-checkbox">
                                        {!! Form::checkbox('visibility', 1, $banner->visibility, ['id' => 'customCheck1', 'class' => 'form-control custom-control-input']) !!}
                                        <label class="custom-control-label" for="customCheck1">{{__('messages.this_banner_should_be_visible_on_my_web_site')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="card-action">
                                <a href="{{route('banner.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
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
{!! JsValidator::formRequest('App\Http\Requests\BannerRequest', '#edit-banner-form') !!}
<script type="text/javascript" src="{!! asset('js/plugin/datepicker/bootstrap-datetimepicker.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/plugin/select2/select2.full.min.js') !!}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#cat_banner').hide();
        jQuery('#dates_section').hide();
        jQuery('#date_start').datetimepicker({
            format: 'YYYY/MM/DD',
        });
         jQuery('#date_end').datetimepicker({
            format: 'YYYY/MM/DD',
        });
        if(jQuery('#for_specific_category').is(':checked') == true) {
            jQuery('#cat_banner').show();
            jQuery('#cat').show();
            jQuery('#brand').hide();
        }else if(jQuery('#for_specific_brand').is(':checked') == true){
             jQuery('#cat_banner').show();
             jQuery('#cat').hide();
             jQuery('#brand').show();
        }else{
            jQuery('#cat_banner').hide();
        }

        if(jQuery('#specific_dates').is(':checked') == true) {
                jQuery('#dates_section').show();
        }else{
            jQuery('#dates_section').hide();
        }

    });

     jQuery('input[name="show_on_page"]').on('click',function(){
            var value = jQuery(this).val();
            if(value == 'for_specific_category'){
                jQuery('#cat_banner').show();
                jQuery('#cat').show();
                jQuery('#brand').hide();
                jQuery('#brand').val('');
                jQuery('#brand_name').val('');
            }else if(value == 'for_specific_brand'){
                jQuery('#cat_banner').show();
                jQuery('#cat').hide();
                jQuery('#brand').show();
                jQuery('#category').val('');
                jQuery('#category_name').val('');
            }else{
                jQuery('#cat_banner').hide();
            }
    });

    jQuery('input[name="date_range_option"]').on('click',function(){
            var value = jQuery(this).val();
            if(value == '0'){
                jQuery('#dates_section').show();
            }else{
                jQuery('#dates_section').hide();
            }
    });
     jQuery("#category").change(function () {
       var selval = jQuery('#category :selected').text();
       jQuery('#category_name').val(selval);
    });

    jQuery("#brand").change(function () {
       var braval = jQuery('#brand :selected').text();
       jQuery('#brand_name').val(braval);
    });
    
    jQuery('#category').select2({
       theme: "bootstrap"
   });
</script>
@endsection