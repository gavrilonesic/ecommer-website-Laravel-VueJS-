<div class="content"   itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
    <meta itemprop="sku" content="{{$product->sku}}" />
    <a href="javascript:void(0)" data-url="{{ route('product.quick_view', ['slug' =>$product->slug]) }}" class="product-quick-view" style="{{ empty(setting('quick_product_view')) ? 'display: none' : '' }}">
        <span class="icon-magnifier">
        </span>
    </a>
    <div class="tagline">
        @if (!empty(setting('new_products_tags_on_products_listing')) && !empty($product->mark_as_new))
        <span>
            <div class="newarrival tagtxt">
                New
            </div>
        </span>
        @endif
        @if (!empty(setting('featured_tag_on_products_listing')) && !empty($product->mark_as_featured))
        <span>
            <div class="featured tagtxt">
                featured
            </div>
        </span>
        @endif
    </div>
    @if($product->medias->count()>0)
        @foreach($product->medias as $image)
            <link itemprop="image" href="{{ $image->getFullUrl() }}" />
        @endforeach
    @endif
    <figure class="text-center">
        <a href="{{ route('product.detail', ['product' =>$product->slug]) }}" class="jq-view-product">
            <img src="{{ $product->medias->count()>0 ? $product->medias[0]->getUrl('thumb') : asset('images/no-image/default-product-page-list.png') }}" alt="{{ $product->medias->count()>0 ? ($product->medias[0]->custom_properties['description'] ?? $product->medias[0]->file_name) : $product->name }}">
        </a>
    </figure>
    <h3>
        <a href="{{ route('product.detail', ['product' =>$product->slug]) }}" class="jq-view-product">
            <span  itemprop="name">{{ $product->name }}</span>
        </a>
    </h3>
    <div class="price" itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
        <link itemprop="url" href="{{ route('product.detail', ['product' =>$product->slug]) }}" />
        <meta itemprop="availability" content="https://schema.org/InStock" />
        <meta itemprop="priceCurrency" content="{{ setting('currency_code') }}" />
        <meta itemprop="price" content="{{ $product->price }}" />
        {{ setting('currency_symbol') }}{{ $product->price }}
    </div>
    <div class="pro-desc">
        {{-- {!! $product->short_description !!} --}}
        {!! strlen(strip_tags($product->short_description)) > 50 ? substr(strip_tags($product->short_description), 0, 70).'...'  : $product->short_description !!}
</div>
    <div class="options">
        <a href="javascript:void(0)" data-url="{{ route('checking_cart', ['slug' =>$product->slug]) }}" class="checking-cart">
            <span class="icon-basket">
            </span>
            {{ __('messages.add_to_cart') }}
        </a>
        @if (!empty(setting('wish_list_in_the_frontend')))
        <a href="javascript:void(0)" class="add-to-wishlist" data-product="{{ $product->slug }}">
            <span class="icon-heart">
            </span>
            {{ __('messages.add_to_favourite') }}
        </a>
        @endif
    </div>
     <div itemprop="brand" itemtype="http://schema.org/Thing" itemscope>
        <meta itemprop="name" content="{{$product->brand->name}}" />
    </div>
     <meta itemprop="description" content="{{$product->description}}" />
</div>
