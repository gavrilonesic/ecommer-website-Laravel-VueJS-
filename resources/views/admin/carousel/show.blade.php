<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.view_carousel_details')}}
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
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.heading')}}</label>
                                        <p>{{$carousel->heading ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="description">{{__('messages.description')}}</label>
                                        <p>{{$carousel->description ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="description">{{__('messages.button_text')}}</label>
                                        <p>{{$carousel->button_text ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label for="description">{{__('messages.link')}}</label>
                                        <p>{{$carousel->link ?? '-'}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.images')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                               <div class="col-md-4 col-lg-4">
                                    <div class="form-group input-file input-file-image">
                                        <label for="carousel_image">{{__('messages.image')}}</label>
                                        <img class="img-upload-preview" width="150" src="{{$carousel->getMedia('carousel')->first() ? $carousel->getMedia('carousel')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group input-file input-file-image">
                                        <label for="carousel_image">{{__('messages.background_image')}}</label>
                                        <img class="img-upload-preview" width="150" src="{{$carousel->getMedia('background_carousel')->first() ? $carousel->getMedia('background_carousel')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
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