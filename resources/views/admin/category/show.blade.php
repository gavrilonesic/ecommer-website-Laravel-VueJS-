<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.view_category')}}
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
                                        <label for="name">{{__('messages.name')}}</label>
                                        <p>{{$category->name ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="input-file input-file-image">
                                        <img class="img-upload-preview" width="150" src="{{$category->getMedia('category')->first() ? $category->getMedia('category')->first()->getUrl() : asset('images/150x150.png')}}" alt="preview">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.description')}}</label>
                                        <p>{!! $category->description ?? '-' !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.parent_category')}}</label>
                                        <p>{{$category->parent->name ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.template_layout')}}</label>
                                        <p>{{config('constants.TEMPLATE_LAYOUT')[$category->template_layout] ?? '-'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.sort_order')}}</label>
                                        <p>{{$category->sort_order}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.search_engine_optimization')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="page_title">{{__('messages.page_title')}}</label>
                                        <p>{{$category->page_title ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="meta_tag_keywords">{{__('messages.meta_keywords')}}</label>
                                        <p>{{$category->meta_tag_keywords ?? '-'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="meta_tag_description">{{__('messages.meta_description')}}</label>
                                        <p>{{$category->meta_tag_description ?? '-'}}</p>
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