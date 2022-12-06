<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.add_order_status')}}
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
                        <label for="name">{{__('messages.name')}} <span class="required-label">*</span></label>
                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                        @include('admin.error.validation_error', ['field' => 'name'])
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="name">{{__('messages.status')}} <span class="required-label">*</span></label>
                        {!! Form::select('status', config('constants.STATUS_LIST'), null, ['id' => 'status', 'class' => 'form-control select2']) !!}

                        @include('admin.error.validation_error', ['field' => 'status'])
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

{!! JsValidator::formRequest('App\Http\Requests\OrderStatusRequest', '#add-order-status-form') !!}
<script type="text/javascript">
    $('#status').select2({
        theme: "bootstrap"
    });
</script>
