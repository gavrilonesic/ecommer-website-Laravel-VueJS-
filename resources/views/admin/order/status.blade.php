<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
               Change Order Status
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
                            {{-- <h4 class="card-title">Basic Information</h4> --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7 col-lg-7 br-line">
                                    <table class="table">
                                        @foreach($order->orderItems as $orderItem)
                                        <tr>
                                            <td><input type="checkbox" name="order_item[]" value="{{$orderItem->id}}" /></td>
                                            <td class="pdetail">
                                                <strong>{{$orderItem->quantity}} x {{$orderItem->product->name}} </strong> <br>
                                               @if($orderItem->product->sku){{$orderItem->product->sku}} <br>@endif
                                                @if (!empty($orderItem->variations))
                                                  @foreach ($orderItem->variations as $key => $row)
                                                    <strong>
                                                      {{$key}}:
                                                    </strong>
                                                    {{$row}}
                                                    <br/>
                                                  @endforeach
                                                @endif
                                                <strong>
                                                    {{__('messages.status')}}:
                                                </strong>
                                                {{ $orderItem->orderStatus->name ?? '' }}
                                            </td>
                                            <td class="price">
                                                {{setting('currency_symbol')}}{!! $orderItem->price * $orderItem->quantity !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="col-md-4 col-lg-5">
                                    <div class="show-hidden-div cancel-div {!! $order->order_status_id != config('constants.ORDER_STATUS.DECLINED_CANCELLED') ?'d-none':''!!}">
                                        <div class="form-group">
                                            <label>
                                                {{__('messages.comment')}}
                                            </label>
                                            {!! Form::textarea('comment', null, ['id' => 'comment','class'=>'form-control']) !!}
                                        </div>
                                        <p style="margin-left: 10px;"><strong>  Note: Refund will be manually settled with Customer.</strong></p>
                                    </div>
                                    <div class="show-hidden-div shipping-div {!! $order->order_status_id != config('constants.ORDER_STATUS.SHIPPED') ?'d-none':'' !!}">
                                       <div class="form-group">
                                            <label>
                                                Shipping Provider
                                            </label>
                                            {!! Form::select('tracking_provider_id', config('constants.SHIPPING_PROVIDERS'),'' ,['class' => 'select2 form-control','id'=>'tracking_provider_id']) !!}
                                        </div>
                                        <div class="form-group carrier-div {!! $order->tracking_provider_id != config('constants.CUSTOM_SHIPPING_PROVIDER_ID') ?'d-none':'' !!}">
                                            <label>
                                                Carrier
                                            </label>
                                            {!! Form::text('carrier_name', null, ['id' => 'carrier_name','class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>
                                               Tracking Number
                                            </label>
                                            {!! Form::text('tracking_number', null, ['id' => 'tracking_number','class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    {!! Form::checkbox('order_send_email','1',false,['id'=>'do_not_send_email']) !!}
                                    {!! Form::label('do_not_send_email', 'Do not send email') !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::select('order_status', $orderStatus, $order->order_status_id,['class' => 'select2 form-control','id'=>'order_status']) !!}
                                    {!! Form::hidden('order_id',$order->id,['id'=>'order_id']) !!}
                                    {!! Form::hidden('route_url',route('order.status', ['order' => $order->id]),['id'=>'route_url']) !!}
                                </div>
                                <div class="col-sm-6">
                                    {{-- <input type="button" id="change_status" class="btn btn-primary" name="submit" value="Change Status"> --}}
                                    <button class="btn btn-primary" type="button" id="change_status">
                                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="btnSpinner" style="display: none"></span>
                                        Change Status
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="modal-footer">
            <button class="btn btn-danger" data-dismiss="modal" type="button">
                Close
            </button>
        </div> --}}
    </div>
</div>