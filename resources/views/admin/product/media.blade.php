<div class="row image-gallery avatar">
    @if (!empty($product->medias[0]))
    <a href="{{ $product->medias[0]->getUrl() }}" class="col-6 col-md-3 mb-4">
        <img alt="preview" class="avatar-img rounded img-fluid" src="{{ $product->medias[0]->getUrl('thumb') }}">
    </a>
    @else
    <span class="col-6 col-md-3 mb-4">
        <img alt="preview" class="avatar-img rounded img-fluid" src="{{ asset('images/150x150.png') }}"/>
    </span>
    @endif
</div>
