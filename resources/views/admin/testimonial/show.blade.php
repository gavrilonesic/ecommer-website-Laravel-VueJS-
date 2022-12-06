<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.view_testimonial')}}
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
                                        <label>{{__('messages.title')}}</label>
                                        <p>{{$testimonial->title ?? '-'}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('messages.date')}}</label>
                                        <p>{{$testimonial->date ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="input-file input-file-image">
                                        <img class="img-upload-preview" width="150" src="{{$testimonial->getMedia('testimonial')->first() ? $testimonial->getMedia('testimonial')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('messages.author_name')}}</label>
                                        <p>{{$testimonial->author ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('messages.status')}}</label>
                                        <p>{{config('constants.STATUS_LIST')[$testimonial->status] ?? '-'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.description')}}</label>
                                        {!! $testimonial->description ?? '<p>-</p>' !!}
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
                Close
            </button>
        </div>
    </div>
</div>