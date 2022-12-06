<div class="form-button-action">
    <a class="btn btn-link btn-primary btn-lg view-product" data-original-title="{{ __('messages.edit_product') }}" data-toggle="" href="{{ route('product.detail', ['product' =>$product->slug]) }}" target="_blank">
        <i class="icon-eye">
        </i>
    </a>
    <a class="btn btn-link btn-primary btn-lg" data-original-title="{{ __('messages.edit_product') }}" data-toggle="tooltip" href="{{ route('product.edit', ['product' =>$product->id]) }}" {{\Request::route()->getName()=='product.search' ? "target=_blank" :''}}>
        <i class="icon-note">
        </i>
    </a>
    {{ Form::open(['method' =>'DELETE', 'route' =>['product.delete', 'product' =>$product->id]]) }}
    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{ __('messages.delete_product') }}" data-toggle="tooltip" href="{{ route('product.delete', ['product' =>$product->id]) }}">
        <i aria-hidden="true" class="icon-close">
        </i>
    </button>
    {{ Form::close() }}
</div>
