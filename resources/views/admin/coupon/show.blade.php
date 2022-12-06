<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.view_coupon')}}
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
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.coupon_name')}}</label>
                                        <p>{{$coupon->name ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.coupon_code')}}</label>
                                        <p>{{$coupon->code ?? '-'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.discount')}}</label>
                                        <p>@if($coupon->price_type == 'flat_price') ${{$coupon->percent_price}} @else {{$coupon->percent_price}}% @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.status')}}</label>
                                        <p>@if($coupon->status == 1) Active @else Inactive @endif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.date_start')}}</label>
                                        <p>@if(!empty($coupon->date_start)) {{ date('F j, Y', strtotime($coupon->date_start)) }} @else N/A @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.date_end')}}</label>
                                        <p>@if(!empty($coupon->date_start)) {{ date('F j, Y', strtotime($coupon->date_start)) }} @else N/A @endif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.uses_per_coupon')}}</label>
                                        <p>@if(!empty($coupon->uses_per_coupon)) {{ $coupon->uses_per_coupon }} @else - @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.uses_per_customer')}}</label>
                                        <p>@if(!empty($coupon->uses_per_customer)) {{ $coupon->uses_per_customer }} @else - @endif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" data-dismiss="modal" type="button">
                Close
            </button>
        </div>
    </div>
</div>