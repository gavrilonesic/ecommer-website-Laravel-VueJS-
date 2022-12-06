<div class="innerpg-product-list popular-products text-center">
    <div class="container">
        <div class="row text-center">
            <div class="col">
                <h2>
                    Related Products
                </h2>
            </div>
        </div>
        <div class="owl-carousel owl-theme" id="popular-products">
            @foreach($product->relatedProducts as $product)
            <div class="item">
                @include('front.product.product')
            </div>
            @endforeach
        </div>
    </div>
</div>
