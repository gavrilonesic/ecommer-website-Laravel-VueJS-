<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.view_banner_details')}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.basic_information')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.banner_name')}}</label>
                                        <p>{{$banner->name ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.link')}}</label>
                                        <p>{{$banner->link ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group input-file input-file-image">
                                        <label for="banner_image">{{__('messages.banner_image')}}</label>
                                        <img class="img-upload-preview" width="150" src="{{$banner->getMedia('banner')->first() ? $banner->getMedia('banner')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
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
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="show_on_page">{{__('messages.show_on_page')}}</label>
                                            <p>@if($banner->show_on_page == 'home_page') Home Page @elseif($banner->show_on_page == 'for_specific_brand') For Brand @elseif($banner->show_on_page == 'for_specific_category') For Category  @elseif($banner->show_on_page == 'search_result_page') Search Results Page @else N/A @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="category">{{__('messages.category')}}</label>
                                        <p>@if(!empty($banner->category_name)) {{ $banner->category_name }} @else - @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.brand')}}</label>
                                        <p>@if(!empty($banner->brand_name)) {{ $banner->brand_name }} @else - @endif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="date_range">{{__('messages.valid_till')}}</label>
                                            <p>@if($banner->date_range_option == 0) Specific Dates @else when i remove it @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>{{__('messages.date_start')}}</label>
                                        <p>@if(!empty($banner->date_start)) {{ date('F j, Y', strtotime($banner->date_start)) }} @else - @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.date_end')}}</label>
                                            <p>@if(!empty($banner->date_end)) {{ date('F j, Y', strtotime($banner->date_end)) }} @else - @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="price_type">{{__('messages.visible_on_site')}}</label>
                                        <p>@if($banner->visibility == 1) Yes @else No @endif</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" data-dismiss="modal" type="button">
                {{__('messages.close')}}
            </button>
        </div>
    </div>
</div>