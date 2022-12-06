<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.' . $popupDetail['popup_title'])}}
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button>
        </div>
        {!! Form::open(['name' => 'add-order-status-form', 'id' => 'add-order-status-form', 'files' => true]) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="name">{{__('messages.file')}}</label>
                        <span class="required-label">*</span>
                        {!! Form::file('file', ['class' => "form-control"]); !!}

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <a href="{{asset('/sample_csv/' . $popupDetail['sample_csv'])}}">
                            Sample CSV
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript::void(0)" data-dismiss="modal" class="btn btn-danger">{{__('messages.cancel')}}</a>
            <button class="btn btn-success">{{__('messages.submit')}}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

{{-- {!! JsValidator::formRequest('App\Http\Requests\OrderStatusRequest', '#add-order-status-form') !!} --}}
<script type="text/javascript">
    $('#status').select2({
        theme: "bootstrap"
    });
</script>
