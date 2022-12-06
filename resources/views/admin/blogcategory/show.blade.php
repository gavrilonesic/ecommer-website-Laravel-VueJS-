<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.view_blogcategory_details')}}
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
                                        <label for="name">{{__('messages.blogcategory_name')}}</label>
                                        <p>{{$blogcategory->name ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.status')}}</label>
                                        <p>@if($blogcategory->status == 0) Inactive @else Active @endif</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group input-file input-file-image">
                                        <label for="banner_image">{{__('messages.blogcategory_image')}}</label>
                                        <img class="img-upload-preview" width="150" src="{{$blogcategory->getMedia('blogcategory')->first() ? $blogcategory->getMedia('blogcategory')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
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