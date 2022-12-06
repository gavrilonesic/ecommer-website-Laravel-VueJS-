<div class="form-button-action">
 {{--    <a href="#" class="btn btn-link btn-primary btn-lg view-order" data-toggle="modal" data-url="{{route('itemshow', ['order' => $order->id])}}">
        <i class="icon-eye"  data-toggle="tooltip" data-placement="top" title="View Order Detail">
        </i>
    </a> --}}
    <a href="{{route('order.invoice', ['type'=>'download','order_id[]' => $order->id])}}" class="btn btn-link btn-primary btn-lg download-invoice" data-original-title="{{__('messages.download_invoice')}}" data-url="">
        <i class="icon-cloud-download" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Invoice">
        </i>
    </a>
    <a href="javascript:void(0);" class="btn btn-link btn-primary btn-lg print-invoice" data-original-title="{{__('messages.print_invoice')}}" onClick=doPrint("{{route('order.invoice', ['type'=>'print','order_id[]' => $order->id])}}")>
        <i class="icon-printer" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('messages.print_invoice')}}">
        </i>
    </a>
    @if(config('constants.ORDER_DELETE'))
        {{ Form::open(['method' => 'DELETE', 'route' => ['order.delete', 'order' => $order->id]]) }}
        <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_order')}}" data-toggle="tooltip" href="{{route('order.delete', ['order' => $order->id])}}">
            <i class="icon-close">
            </i>
        </button>
        {{ Form::close() }}
    @endif
</div>