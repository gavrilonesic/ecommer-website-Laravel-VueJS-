<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.view_order_status')}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="name">{{__('messages.name')}}</label>
                        <p>{{$orderStatus->name ?? '-'}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="name">{{__('messages.status')}}</label>
                        <p>{{config('constants.STATUS_LIST')[$orderStatus->status] ?? '-'}}</p>
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