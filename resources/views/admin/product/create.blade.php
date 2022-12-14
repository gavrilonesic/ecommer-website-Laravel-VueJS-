@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('AddProduct') !!}
        </div>
        {!! Form::open(['name' => 'add-product-form', 'id' => 'add-product-form', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.basic_information')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">
                                        {{__('messages.name')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'name'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">
                                        {{__('messages.sku')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('sku', null, ['id' => 'sku', 'placeholder' => __('messages.enter_sku'), 'class' => "form-control " . ($errors->has('sku') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'sku'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="brand_id">
                                        {{__('messages.brand')}}
                                    </label>
                                    <span class="required-label">
                                        * </span>
                                    {!! Form::select('brand_id', $brands, null, ['id' => 'brand_id', 'placeholder' => __('messages.select_brand'), 'class' => 'select2 form-control']) !!}
                                        @include('admin.error.validation_error', ['field' => 'brand_id'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="price">
                                        {{__('messages.default_price')}} ({{setting('currency_symbol')}})
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('price', null, ['id' => 'price', 'placeholder' => __('messages.enter_default_price'), 'class' => "form-control " . ($errors->has('price') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'price'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="weight">
                                        {{__('messages.weight')}} ({{setting('weight_in')}})
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('weight', null, ['id' => 'weight', 'placeholder' => __('messages.enter_weight'), 'class' => "form-control " . ($errors->has('weight') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'weight'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="depth">
                                        {{__('messages.depth')}} ({{setting('depth_in')}})
                                    </label>
                                    {!! Form::text('depth', null, ['id' => 'depth', 'placeholder' => __('messages.enter_depth'), 'class' => "form-control " . ($errors->has('depth') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'depth'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="height">
                                        {{__('messages.height')}} ({{setting('height_in')}})
                                    </label>
                                    {!! Form::text('height', null, ['id' => 'height', 'placeholder' => __('messages.enter_height'), 'class' => "form-control " . ($errors->has('height') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'height'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="width">
                                        {{__('messages.width')}} ({{setting('width_in')}})
                                    </label>
                                    {!! Form::text('width', null, ['id' => 'width', 'placeholder' => __('messages.enter_width'), 'class' => "form-control " . ($errors->has('width') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'width'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="status">
                                        {{__('messages.status')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::select('status', $status, null, ['id' => 'status', 'class' => 'select form-control']) !!}
                                        @include('admin.error.validation_error', ['field' => 'status'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.categories')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group expand-collapse">
                                    <button class="btn-link ml-auto" data-toggle="modal" type="button" id="expand-all">
                                    <i class="icon-plus"></i>
                                     {{__('messages.expand_all')}}
                                    </button>
                                    <button class="btn-link ml-auto" data-toggle="modal" type="button" id="collapse-all">
                                    <i class="icon-minus"></i>
                                    {{__('messages.collapse_all')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check checkboxdesign">
                                        <ul class="row">
                                        @include('admin.product.manage_category',['childs' => $categories, 'parent' => 0])
                                        </ul>
                                </div> </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <label for="short_description">
                                        {{__('messages.short_description')}}
                                    </label>
                                    {!! Form::textarea('short_description', null, ['id' => 'short_description','class'=>'form-control']) !!}
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
                <div class="card" id="image-card-div">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                {{__('messages.images')}}
                            </h4>
                            <a class="onlyicon ml-auto" data-target="#add-image-url" data-toggle="modal">
                                <i class="icon-plus"  data-toggle="tooltip" title="" data-original-title="{{__('messages.add_from_url')}}">
                                </i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="p-3 mb-2 bg-danger text-white" id="image-upload-error">{{__('messages.you_can_not_upload_more_files',['fileno' =>config('constants.PRODUCT_MAX_UPLOAD')])}}</div>
                        <div class="table-responsive image-section">
                            <table class="display table table-head-bg-primary table-striped dataTable no-footer" id="image-table">
                                <thead>
                                    <tr>
                                        <th>
                                            {{__('messages.image')}}
                                        </th>
                                        <th>
                                            {{__('messages.description')}}
                                        </th>
                                        <th>
                                            {{__('messages.default_image')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div action="/" class="dropzone" id="my-awesome-dropzone">
                            <div class="dz-message" data-dz-message="">
                                <div class="icon">
                                    <i class="icon-picture">
                                    </i>
                                </div>
                                <h4 class="message">
                                    {{__('messages.drag_and_drop_files_here')}}
                                </h4>
                                <div class="note">
                                    {{__('messages.click_the_add_from_url_button')}}
                                </div>
                            </div>
                            <div class="fallback">
                                <input multiple="" name="file[]" type="file"/>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div aria-hidden="true" class="modal fade" id="add-image-url" role="dialog" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header no-bd">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                {{__('messages.add_image_from_url')}}
                                            </span>
                                        </h5>
                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                            <span aria-hidden="true">
                                                ??
                                            </span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>
                                                        {{__('messages.url')}}
                                                    </label>
                                                    {!! Form::text('upload_url', null, ['id' => 'upload-url', 'placeholder' => "http://", 'class' => "form-control "]) !!}
                                                    <span class="invalid-feedback" id="upload_url-error">
                                                        {{__('messages.enter_valid_url')}}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer no-bd">
                                        <button class="btn btn-primary" onclick="validateImageURL()" type="button">
                                            {{__('messages.add')}}
                                        </button>
                                        <button class="btn btn-danger" data-dismiss="modal" type="button">
                                            {{__('messages.close')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                {{__('messages.videos')}}
                            </h4>
                            <div class="ml-md-auto py-2 py-md-0">
                                <a class="ml-auto onlyicon" data-target="#add-video" data-toggle="modal">
                                    <i class="icon-plus"  data-toggle="tooltip" title="{{__('messages.add_video_from_library')}}">
                                    </i>
                                </a>
                                <a class="ml-auto onlyicon" data-target="#add-video-youtube" data-toggle="modal">
                                    <i class="icon-social-youtube"  data-toggle="tooltip" title="{{__('messages.add_video_from_youtube')}}">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row video-row">
                        </div>
                        {{-- @include('admin.product.video') --}}
                    </div>
                        <!-- video Modal -->
                        <div aria-hidden="true" class="modal fade" id="add-video" role="dialog" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                {{__('messages.select_video')}}
                                            </span>
                                        </h5>
                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                            <span aria-hidden="true">
                                                ??
                                            </span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @include('admin.product.video')
                                    </div>
                                    <div class="modal-footer no-bd">
                                        <button class="btn btn-primary" onclick="validateVideo()" type="button">
                                            {{__('messages.add')}}
                                        </button>
                                        <button class="btn btn-danger" data-dismiss="modal" type="button">
                                            {{__('messages.close')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- youtube Modal -->
                        <div aria-hidden="true" class="modal fade" id="add-video-youtube" role="dialog" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold">
                                                {{__('messages.add_video_from_youtube')}}
                                            </span>
                                        </h5>
                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                            <span aria-hidden="true">
                                                ??
                                            </span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>
                                                        {{__('messages.url')}}
                                                    </label>
                                                    {!! Form::text("youtube_upload_url", null, ['id' => 'youtube_upload_url', 'placeholder' => "https://www.youtube.com/watch?v=abcde", 'class' => "form-control"]) !!}
                                                    <span class="invalid-feedback" id="youtube_upload_url_error">
                                                        {{__('messages.enter_valid_youtube_url')}}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer no-bd">
                                        <button class="btn btn-primary" onclick="validateYoutubeVideo()" type="button">
                                            {{__('messages.add')}}
                                        </button>
                                        <button class="btn btn-danger" data-dismiss="modal" type="button">
                                            {{__('messages.close')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.inventory')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        {!! Form::checkbox('inventory_tracking', '1', null, ['class' => 'custom-control-input', 'id' => 'inventory_tracking']) !!}
                                        <label class="custom-control-label" for="inventory_tracking">
                                            {{ __('messages.track_inventory') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="inventory-tracking">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('inventory_tracking_by', 0, true, ['class' => 'custom-control-input inventory-level', 'id' => 'product_level']) !!}
                                            <label class="custom-control-label" for="product_level">
                                                {{ __('messages.product_level') }}
                                            </label>
                                        </div>
                                    </div> </div> <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            {!! Form::radio('inventory_tracking_by', 1, null, ['class' => 'custom-control-input inventory-level', 'id' => 'attribute_level']) !!}
                                            <label class="custom-control-label" for="attribute_level">
                                                {{ __('messages.attribute_level') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row show-product-level-inventory">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="quantity">
                                            {{__('messages.quantity')}}
                                        </label>
                                        {!! Form::text('quantity', null, ['id' => 'quantity', 'class' => "form-control"]) !!}
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="low_stock">
                                            {{__('messages.low_stock')}}
                                        </label>
                                        {!! Form::text('low_stock', null, ['id' => 'low_stock', 'class' => "form-control"]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.include_product_in_feed')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        {!! Form::checkbox('include_in_feed', '1', true, ['class' => 'custom-control-input', 'id' => 'include_in_feed']) !!}
                                        <label class="custom-control-label" for="include_in_feed">
                                            {{ __('messages.include_product_in_feed') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                {{__('messages.attributes')}}
                            </h4>
                            <a class="onlyicon ml-auto" href="javascript:void(0)" data-url="{{route('attribute.create')}}" id="add-attribute" >
                                <i class="icon-plus"  data-toggle="tooltip" title="" data-original-title="{{__('messages.add_attribute')}}">
                                </i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    {!! Form::select('attribute_id[]', $attributes, null, ['id' => 'attributes', 'class' => 'select2 form-control', 'multiple' => true]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="attribute-options">
                            @if(!empty(old('attribute')))
                                @include('admin.product.create_matrix', ['attributeMatrix' => old('attribute'), 'oldData' => true])
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                {{__('messages.custom_fields')}}
                            </h4>
                            <div class="ml-md-auto py-2 py-md-0">
                                <a class="onlyicon ml-auto" id="copy-product-field" data-value="copy_custom_fields" data-url="{{route('product.copy_product_field')}}">
                                    <i class="icon-arrow-down-circle"  data-toggle="tooltip" title="" data-original-title="{{__('messages.copy_from_product')}}">
                                    </i>
                                </a>
                                <a class="onlyicon ml-auto" id="add-custom-field">
                                    <i class="icon-plus"  data-toggle="tooltip" title="" data-original-title="{{__('messages.add_custom_fields')}}">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body custom-fields"></div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                {{__('messages.related_products')}}
                            </h4>
                            <a class="onlyicon ml-auto" id="copy-product-field" data-value="copy_related_products" data-url="{{route('product.copy_product_field')}}">
                                <i class="icon-arrow-down-circle"  data-toggle="tooltip" title="" data-original-title="{{__('messages.copy_from_product')}}">
                                </i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    @php
                                        if (!empty(old('related_product'))) {
                                            $relatedProduct = array_map(function ($value) {
                                                return $value['related_product_id'];
                                            }, old('related_product'));
                                        }
                                     @endphp
                                    {!! Form::select('related_product[][related_product_id]', $products, $relatedProduct ?? [], ['id' => 'related_product_id', 'class' => 'select2 form-control', 'multiple' => true]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.promotion')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        {!! Form::checkbox('mark_as_new', 1, true, ['class' => 'custom-control-input', 'id' => 'mark_as_new_yes']) !!}
                                        <label class="custom-control-label" for="mark_as_new_yes">
                                            {{__('messages.mark_as_new')}}
                                        </label>
                                    </div>
                                    {{-- <div class="custom-control custom-radio">
                                        {!! Form::radio('mark_as_new', 0, null, ['class' => 'custom-control-input', 'id' => 'mark_as_new_no']) !!}
                                        <label class="custom-control-label" for="mark_as_new_no">
                                            {{ __('messages.no') }}
                                        </label>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        {!! Form::checkbox('mark_as_featured', 1, null, ['class' => 'custom-control-input', 'id' => 'mark_as_featured_yes']) !!}
                                        <label class="custom-control-label" for="mark_as_featured_yes">
                                            {{__('messages.mark_as_featured')}}
                                        </label>
                                    </div>
                                    {{-- <div class="custom-control custom-radio">
                                        {!! Form::radio('mark_as_featured', 0, true, ['class' => 'custom-control-input', 'id' => 'mark_as_featured_no']) !!}
                                        <label class="custom-control-label" for="mark_as_featured_no">
                                            {{ __('messages.no') }}
                                        </label>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.search_engine_optimization')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="page_title">
                                        {{__('messages.page_title')}}
                                    </label>
                                    {!! Form::text('page_title', null, ['id' => 'page_title', 'placeholder' => __('messages.enter_page_title'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="meta_tag_keywords">
                                        {{__('messages.meta_keywords')}}
                                    </label>
                                    {!! Form::text('meta_tag_keywords', null, ['id' => 'meta_tag_keywords', 'placeholder' => __('messages.enter_meta_keywords'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="meta_tag_description">
                                        {{__('messages.meta_description')}}
                                    </label>
                                    {!! Form::text('meta_tag_description', null, ['id' => 'meta_tag_description', 'placeholder' => __('messages.enter_meta_description'), 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a class="btn btn-danger fw-bold" href="{{route('product.index')}}">
                            {{__('messages.cancel')}}
                        </a>
                        <button class="btn btn-success">
                            {{__('messages.submit')}}
                        </button>
                        <button type="submit" class="btn btn-primary" name="save_as_draft">
                            {{__('messages.save_as_draft')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<!-- Modal -->
<div aria-hidden="true" class="modal fade" id="crop-image-popup" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                        {{__('messages.add_image_from_url')}}
                    </span>
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ??
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group image-wrapper" id="image-4-wrapper">

                    </div>
                </div>
            </div>
            <div class="modal-footer no-bd">
                <button class="btn btn-primary" onclick="cropImage()" type="button">
                    {{__('messages.crop')}}
                </button>
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    {{__('messages.close')}}
                </button>
            </div>
        </div>
    </div>
</div>

<div aria-hidden="true" class="modal fade" id="add-attribute-modal" role="dialog" tabindex="-1"></div>
@endsection

@section('css')
<style type="text/css">
#image-4-wrapper .rcrop-outer-wrapper {
    opacity: .75;
}
#image-4-wrapper .rcrop-outer{
    background: #000
}
#image-4-wrapper .rcrop-croparea-inner{
    border: 1px dashed #fff;
}

#image-4-wrapper .rcrop-handler-corner{
    width:12px;
    height: 12px;
    background: none;
    border : 0 solid #51aeff;
}
#image-4-wrapper .rcrop-handler-top-left{
    border-top-width: 4px;
    border-left-width: 4px;
    top:-2px;
    left:-2px
}
#image-4-wrapper .rcrop-handler-top-right{
    border-top-width: 4px;
    border-right-width: 4px;
    top:-2px;
    right:-2px
}
#image-4-wrapper .rcrop-handler-bottom-right{
    border-bottom-width: 4px;
    border-right-width: 4px;
    bottom:-2px;
    right:-2px
}
#image-4-wrapper .rcrop-handler-bottom-left{
    border-bottom-width: 4px;
    border-left-width: 4px;
    bottom:-2px;
    left:-2px
}
#image-4-wrapper .rcrop-handler-border{
    display: none;
}

// For touch devices we must use clayfy handler
#image-4-wrapper .clayfy-touch-device.clayfy-handler{
    background: none;
    border : 0 solid #51aeff;
    border-bottom-width: 6px;
    border-right-width: 6px;
}
</style>
<link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/rcrop.min.css') }}" rel="stylesheet"/>
@endsection

@section('script')
<script src="{{ asset('js/plugin/summernote/summernote-bs4.min.js') }}">
</script>
<script src="{{ asset('js/rcrop.min.js') }}">
</script>
<script src="{{ asset('js/plugin/dropzone/dropzone.min.js') }}">
</script>
<script src="{{ asset('js/plugin/easy-autocomplete/jquery.easy-autocomplete.min.js') }}">
</script>
{!! JsValidator::formRequest('App\Http\Requests\ProductRequest', '#add-product-form') !!}
<script>
maxFiles = {{config('constants.PRODUCT_MAX_UPLOAD')}}
</script>
<script src="{{ asset('js/product.js') }}"></script>
<script>
    customFieldArray = {!! $customField !!},
    descriptionPlaceholder = "{{__('messages.description')}}",
    shortDescriptionPlaceholder = "{{__('messages.short_description')}}",
    creatMatrixUrl = "{{route('product.matrix')}}",
    deleteButtonTooltip = "{{__('messages.delete_image')}}";
    @if (!empty(old('custom_fields')))
        @foreach(old('custom_fields')['name'] as $key => $value)
            addCustomField("{{$value}}", "{{old('custom_fields')['value'][$key]}}")
        @endforeach
    @endif
    @if (!empty(old('product_images')))
        @foreach (old('product_images')['description'] as $key => $element)
            addImage("{{old('product_images')['image'][$key]}}", parseInt("{{old('product_images')['url'][$key] ?? ''}}"), "{{old('product_images')['file_name'][$key] ?? ''}}", "{{(old('default_image') == $key) ? true : false}}", "{{$element}}")
        @endforeach
    @endif
    $('#image-table tbody').sortable();
</script>
@endsection
