<div class="col-md-9 col-lg-9 myprofile-right">
    <h2>
        {{__('messages.my_wishlist')}}
    </h2>
    <div class="cart-data">
        @if ($wishlists->count() > 0)
            @foreach ($wishlists as $product)
                <div class="col-md-12 cart-data-list">
                    <a class="removeproduct" href="javascript:void();" data-id="{{$product->id}}">
                        <i class="icon-close">
                        </i>
                    </a>
                    <div class="row text-left">
                        <div class="imgbox datacol">
                            <img src="{{ $product->medias->count() > 0 ? $product->medias->first()->getUrl() : asset('images/no-image/default-product-page-list.png') }}" alt="" title="">
                        </div>
                        <div class="detailbox datacol">
                            <h5>
                                {{$product->name}}
                            </h5>
                            @if (!empty($product->brand))
                                <strong>
                                    {{__('messages.brand')}}:
                                </strong>
                                    {{$product->brand->name}}
                                <br/>
                            @endif
                            <strong>
                                Specifications:
                            </strong>
                            API CF 4, 15W-40
                            <br/>
                            <strong>
                                Type of Product:
                            </strong>
                            Diesel Engine Oil
                            <br/>
                            <br/>
                            <a href="{{ route('product.detail', ['product' => $product->slug]) }}" class="btn btn-blue-txt">
                                {{__('messages.click_to_view_product')}}
                            </a>
                        </div>
                        <div class="add-remove-row datacol">
                            <div class="price">
                                {{setting('currency_symbol')}}{{$product->price}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>