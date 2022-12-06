<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.view_attribute')}}
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.name')}}</label>
                                        <p>{{$attribute->name ?? '-'}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.attribute_type')}}</label>
                                        <p>{{config('constants.ATTRIBUTE_TYPE')[$attribute->attribute_type] ?? '-'}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.options')}}</label>
                                        @foreach($attribute->attributeOptions as $key => $option)
                                            <p>{{$option->option ?? '-'}}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" type="button">
                Close
            </button>
        </div>
    </div>
</div>