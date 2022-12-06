{{ Form::open(['method' =>'GET', 'route' =>['product.status', 'product' =>$product->id]]) }}
@if($product->
status == config('constants.STATUS.STATUS_ACTIVE'))
<a class="btn btn-link btn-primary btn-lg ispublish" data-toggle="tooltip" href="{{ route('product.status', ['product' =>$product->id]) }}">
    <i aria-hidden="true" class="icon-check">
    </i>
</a>
@else
<a class="btn btn-link btn-danger btn-lg ispublish" data-toggle="tooltip" href="{{ route('product.status', ['product' =>$product->id]) }}">
    <i aria-hidden="true" class="icon-close">
    </i>
</a>
@endif
{{ Form::close() }}
