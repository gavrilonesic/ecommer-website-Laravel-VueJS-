<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{__('messages.order_cancel')}}
            </h5>
            {{-- <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                <span aria-hidden="true">
                    ×
                </span>
            </button> --}}
        </div>
        {!! Form::open(['route' => ['order.status'], 'name' => 'order-cancel-form', 'id' => 'order-cancel-form', 'method' => "POST"]) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::hidden("order_id", $order->id) !!}
                            {!! Form::hidden("order_status_id", config('constants.ORDER_STATUS.DECLINED_CANCELLED')) !!}
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>
                                            {{__('messages.comment')}}
                                        </label>
                                        {!! Form::textarea('comment', null, ['id' => 'comment','class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="table-responsive">
                                <table class="display table table-head-bg-primary table-striped datatable-with-image">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                {{__('messages.image')}}
                                            </th>
                                            <th>
                                                {{__('messages.name')}}
                                            </th>
                                            <th>
                                                {{__('messages.option')}}
                                            </th>
                                            <th>
                                                {{__('messages.quantity')}}
                                            </th>
                                            <th>
                                                {{__('messages.price')}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                            @if ($item->order_status_id == config('constants.ORDER_STATUS.COMPLETED') || $item->order_status_id == config('constants.ORDER_STATUS.DECLINED_CANCELLED'))
                                                @continue;
                                            @endif
                                        <tr>
                                            <td>
                                                {!! Form::checkbox('order_item[]', $item->id, null) !!}
                                            </td>
                                            <td>
                                                <div class="row image-gallery avatar">
                                                    <span class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{(!empty($item->productSku->medias) ? $item->productSku->medias->getUrl() : (!empty($item->product->medias[0]) ? $item->product->medias[0]->getUrl() : ''))}}">
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                {{$item->product->name}}
                                            </td>
                                            <td>
                                                @if (!empty($item->variations))
                                                  @foreach ($item->variations as $key => $row)
                                                    <strong>
                                                      {{$key}}:
                                                    </strong>
                                                    {{$row}}
                                                    <br/>
                                                  @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                {{$item->quantity}}
                                            </td>
                                            <td>
                                                {{setting('currency_symbol')}}<span>{{$item->price * $item->quantity}}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> --}}
                            <p style="margin-left: 10px;"><strong>  Note: Refund will be manually settled with Customer.</strong></p>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('order.index') }}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                            <button class="btn btn-success" id="submit">{{__('messages.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
