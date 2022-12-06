@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">{{__('messages.coupon')}}</h4>
        </div>
        {!! Form::open(['name' => 'add-coupon-form', 'id' => 'add-coupon-form']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group ">
                                        <label for="name">{{__('messages.coupon_name')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_coupon_name'), 'class' => 'form-control '. ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="code">{{__('messages.coupon_code')}}</label>
                                        <span class="required-label">*</span>
                                        {!! Form::text('code', null, ['id' => 'code', 'placeholder' => __('messages.enter_coupon_code'), 'class' => 'form-control']) !!}

                                        <input type="button" onclick="generatecode()" id="" value="Generate Code" name="generate_code" />  

                                        @include('admin.error.validation_error', ['field' => 'code'])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.price_type')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <div>
                                            <label for="price_type">{{__('messages.type')}}</label>
                                            <span class="required-label">*</span>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('price_type', 'flat_price', null, ['id' => 'flatprice', 'class' => 'custom-control-input']) !!} 
                                            <label class="custom-control-label" for="flatprice">{{__('messages.flat_price')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('price_type', 'percentage', null, ['id' => 'percentage', 'placeholder' => __('messages.enter_coupon_name'), 'class' => 'custom-control-input']) !!}
                                            <label class="custom-control-label" for="percentage">{{__('messages.percentage')}}</label>
                                        </div>
                                    </div>
                                </div>
                                @include('admin.error.validation_error', ['field' => 'price_type'])
                                <div class="col-md-6 col-lg-6">
                                   <div class="show-hide form-group">
                                        <div class="price">
                                            <label for="name">{{__('messages.price')}}</label>
                                            <span class="required-label">*</span>
                                            {!! Form::text('price', null, ['id' => 'price', 'placeholder' => __('messages.enter_price'), 'class' => 'form-control']) !!}
                                        </div>
                                        <div class="percentage">
                                            <label for="name">{{__('messages.percentage')}}</label>
                                            <span class="required-label">*</span>
                                            {!! Form::text('percentage_value', null, ['id' => 'percentage_value', 'placeholder' => __('messages.enter_percentage'), 'class' => 'form-control', 'max_length' => '3']) !!}
                                        </div>
                                    </div>
                                </div>
                                @include('admin.error.validation_error', ['field' => 'percentage_value'])
                                @include('admin.error.validation_error', ['field' => 'price'])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.discount_type')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="name">{{__('messages.uses_per_coupon')}}</label>
                                        {!! Form::text('uses_per_coupon', null, ['id' => 'uses_per_coupon', 'placeholder' => __('messages.no_uses_per_coupon'), 'class' => 'form-control '. ($errors->has('name') ? 'is-invalid' : '')]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="page_title">{{__('messages.uses_per_customer')}}</label>
                                        {!! Form::text('uses_per_customer', null, ['id' => 'uses_per_customer', 'placeholder' => __('messages.no_uses_per_customer'), 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-12">

                                    <div class="form-group d-flex flex-row">
                                        <label for="order_coupon"><input id="order_coupon" type="radio" name="coupon_type" value="order_coupon" checked> &nbsp;Order Coupon</label>
                                        &nbsp;
                                        &nbsp;
                                        <label for="product_coupon"><input id="product_coupon" type="radio" name="coupon_type" value="product_coupon"> &nbsp;Product Coupon</label>
                                    </div>

                                    <div class="form-group" style="display: none;">
                                        <label for="page_title">{{__('messages.coupon_products')}}</label>
                                        {!! Form::textarea('products_list', null, ['id' => 'coupon_products', 'placeholder' => __('messages.coupon_products'), 'class' => 'form-control']) !!}
                                        <span class="text-danger">Product SKU, Comma "," separated</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.date_start_end')}}</h4>
                        </div>
                        <div class="card-body">
                             <div class="row">
                                <div class="col-md-6 col-lg-4">
                                   <div class="form-group icon-calendr-position">
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
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group  icon-calendr-position">
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
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="status">{{__('messages.status')}}</label>
                                        {!! Form::select('status', ['1' => 'Active','0' => 'Inactive'], null, ['id' => 'status', 'class' => 'form-control form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="card-action">
                                <a href="{{route('coupon.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
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
{!! JsValidator::formRequest('App\Http\Requests\CouponRequest', '#add-coupon-form') !!}
<script type="text/javascript" src="{!! asset('js/plugin/datepicker/bootstrap-datetimepicker.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('js/plugin/select2/select2.full.min.js') !!}"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){

        $('body').on('input', '[name="coupon_type"]', function(event) {
            if ($(this).val() == 'order_coupon') {
                $(this).parents('.form-group').next().hide()
            } else {
                $(this).parents('.form-group').next().show()
            }
        });

        jQuery(".show-hide").hide();
        jQuery('#date_end').datetimepicker({
            format: 'YYYY/MM/DD',
        });
        jQuery('#date_start').datetimepicker({
            format: 'YYYY/MM/DD',
        });
        jQuery('#status').select2({
            theme: "bootstrap"
        });
        jQuery('#flatprice').click();
        jQuery("#uses_per_coupon").on("blur", function(){
            var mobNum = $(this).val();
            var filter = /^\d*(?:\.\d{1,2})?$/;
            if(mobNum.length>0) {
                if(filter.test(mobNum)) {
                    if(mobNum.length<=5){
                          return true;
                     } else {
                        alert('Upto 5 digits allowed !');
                        return false;
                      }
                }else {
                  jQuery('#uses_per_coupon').val('');
                  alert('Numbers only');
                  return false;
               }
            }
        });
        jQuery("#uses_per_customer").on("blur", function(){
            var cusNum = $(this).val();
            var filter = /^\d*(?:\.\d{1,2})?$/;
            if(cusNum.length>0) {
              if (filter.test(cusNum) && cusNum.length>0) {
                if(cusNum.length<=5){
                      return true;
                 } else {
                    alert('Upto 5 digits allowed !');
                    return false;
                  }
                }else {
                  jQuery('#uses_per_customer').val('');
                  alert('Numbers only');
                  return false;
               }
            }
        });
  
    });
    jQuery("input[name='price_type']").on('click',function(){
        var pricetype = jQuery(this).val();
        if(pricetype == 'percentage'){
            jQuery(".show-hide").show();
            jQuery(".percentage").show();
            jQuery(".price").hide();
        }else if(pricetype == 'flat_price'){
            jQuery(".show-hide").show();
            jQuery(".percentage").hide();
            jQuery(".price").show();
        }
    });

    function generatecode(){
        var randomString = function(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            for(var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            return text;
        }
        var random = randomString(8);
        var elem = document.getElementById("code").value = random;
    }
</script>
@endsection
