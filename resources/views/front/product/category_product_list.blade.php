<div class="innerpg-product-list popular-products">
    <div class="container">
        <div class="row">
           @if ($products->count() > 0)
              @foreach ($products as $key => $value)
                 <div class="{{ \Route::current()->getName() == 'store' ? 'mb-3 col-lg-4 col-md-6 col-sm-12 col-12 wow zoomIn' : 'col-lg-4 col-md-6 col-sm-6 col-12' }}">
                    <div class="content">
                    <a href="javascript:void(0)" data-url="{{ route('product.quick_view', ['slug' => $value->slug]) }}" class="product-quick-view" style="{{ empty(setting('quick_product_view')) ? 'display: none' : ''}}"><span class="icon-magnifier"></span></a>
                    <div class="tagline">
                            @if (!empty(setting('new_products_tags_on_products_listing')) && !empty($value->mark_as_new))
                            <span> <div class="newarrival tagtxt" >New</div>  </span>
                            @endif
                           @if (!empty(setting('featured_tag_on_products_listing')) && !empty($value->mark_as_featured))
                           <span>  <div class="featured tagtxt">featured</div>  </span>
                           @endif</div>

                        <figure class="text-center">
                            <a href="{{ route('product.detail', ['product' => $value->slug]) }}">
                              <img src="{{ $value->medias->count() > 0 ? $value->medias[0]->getUrl('thumb') : asset('images/no-image/default-product-page-list.png') }}" alt="{{$value->name}}">
                            </a>
                            </figure>

                            <h3> <a href="{{ route('product.detail', ['product' => $value->slug]) }}" class="">{{$value->name}} </a></h3>

                      {{--   <p>
                            {{ strlen(strip_tags($value->short_description)) > 132 ? substr(strip_tags($value->short_description), 0, 132) . "..." : strip_tags($value->short_description) }}
                        </p> --}}
                        <div class="price">{{setting('currency_symbol')}}{{$value->price}}</div>
                        <div class="options">

                         <a href="javascript:void(0)" data-url="{{route('checking_cart', ['slug' => $value->slug])}}" class="checking-cart"><span class="icon-basket"></span> {{__('messages.add_to_cart')}}</a>
                               @if (!empty(setting('wish_list_in_the_frontend')))
                         <a href="javascript:void(0)" class="add-to-wishlist" data-product="{{$value->slug}}"><span class="icon-heart"></span> {{__('messages.add_to_favourite')}}</a>
                               @endif
                           </div>
                    </div>
                 </div>
              @endforeach
           @endif
        </div>
        <div class="text-center">
            @if($products->total() > $products->perPage())
                <div class="pagination-row">
                  {{ $products->appends($_GET)->links() }}
                   {{-- <a href="">prew</a>
                   <a href="">1</a>
                   <a href="">2</a>
                   <a href="">3</a>
                   <a href="">Next</a> --}}
                </div>
            @endif
        </div>
    </div>
</div>