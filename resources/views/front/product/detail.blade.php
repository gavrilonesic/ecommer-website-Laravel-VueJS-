@extends('front.layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('js/plugin/slick/slick.css') }}"/>
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('js/plugin/slick/slick-theme.css') }}"/> --}}
@endsection
@section('content')
<section>
         <div class="product-details-page">
            <div class="container" itemtype="http://schema.org/Product" itemscope>
              @if($product->medias)
                @foreach($product->medias as $key => $image)
                  <link itemprop="image" href="{{$image->getFullUrl()}}" />
                @endforeach
                @if(!empty($productSkus->medias))
                  <link itemprop="image" href="{{$productSkus->medias->getFullUrl()}}" />
                @endif
              @endif
              <meta itemprop="sku" content="{{$product->sku}}" />
              <div itemprop="brand" itemtype="http://schema.org/Thing" itemscope>
                <meta itemprop="name" content="{{$product->brand->name}}" />
              </div>
              <form id="add-to-cart-form">
                <div class="row">
                  <div class="col-lg-6 text-center">
                     <div class="productimg">
                      <div class="slider-for" id="slider">
                          @if(!empty($productSkus->medias))
                          <div class="att_image" ><img src="{{$productSkus->medias->getUrl('medium')}}" alt="{{$productSkus->medias->custom_properties['description'] ?? $productSkus->medias->file_name}}"></div>
                          @endif
                          @if($product->medias)
                            @foreach($product->medias as $key => $image)
                            <div><img src="{{ $image->getUrl('medium') }}"  alt="{{$image->custom_properties['description'] ?? $image->file_name}}" /></div>
                            @endforeach
                          @endif
                          @if($product->videos)
                            @foreach($product->videos as $video)
                            <div class="videothumb videopopup"><img class="video"  data-video="{{ $video->medias->getUrl() }}" data-toggle="modal" data-target="#videoModal"  src="{{ $video->medias->getUrl('medium') }}" alt="{{$video->file_name}}"></div>
                            @endforeach
                          @endif
                          @if($product->youtube_url)
                            @foreach($product->youtube_url as $youtube)
                            <div class="videothumb videopopup"><img class="video"  data-video="//www.youtube.com/embed/{{ $youtube->id }}" data-toggle="modal" data-target="#videoModalYoutube"  src="https://img.youtube.com/vi/{{ $youtube->id }}/hqdefault.jpg"></div>
                            @endforeach
                          @endif
                          @if(empty($productSkus->medias) && ($product->medias->count()==0) && ($product->videos->count()==0) && empty($product->youtube_url) )
                             <div><img src="{{asset('images/no-image/default-product-page-list.png') }}"></div>
                          @endif
                      </div>
                      <div class="slider-nav" id="pager">
                        @if(!empty($productSkus->medias))
                        <a class="att_image"><img src="{{$productSkus->medias->getUrl('thumb')}}" alt="{{$productSkus->medias->custom_properties['description'] ?? $productSkus->medias->file_name}}"></a>
                        @endif
                        @if($product->medias)
                          @foreach($product->medias as $key => $image)
                          <a><img src="{{ $image->getUrl('thumb') }}" alt="{{$image->custom_properties['description'] ?? $image->file_name}}"></a>
                          @endforeach
                        @endif
                        @if($product->videos)
                          @foreach($product->videos as $video)
                          <a><div class="videothumb"><img src="{{ $video->medias->getUrl('thumb') }}" alt="{{$video->file_name}}"></div></a>
                          @endforeach
                        @endif
                        @if($product->youtube_url)
                          @foreach($product->youtube_url as $youtube)
                          <a><div class="videothumb"><img class="youtube_img" src="https://img.youtube.com/vi/{{ $youtube->id }}/default.jpg"></div></a>
                          @endforeach
                        @endif
                      </div>
                        <label id="out-of-stock" class="out-of-stock"> {{__('messages.out_of_stock')}} </label>
                     </div>
                  </div>
                  <div class="col-lg-6">
                       <h4 itemprop="name">@if($product->name) {{$product->name}} @endif</h4>
                       <div class="price"  itemprop="offers" itemtype="http://schema.org/Offer" itemscope>
                        <link itemprop="url" href="{{ route('product.detail', ['product' =>$product->slug]) }}" />
                        <meta itemprop="availability" content="https://schema.org/InStock" />
                        <meta itemprop="priceCurrency" content="{{ setting('currency_code') }}" />
                        <meta itemprop="price" content="{{ $product->price }}" />
                        {{setting('currency_symbol')}}<span id="price-count">{{ !empty($productSkus) ? $productSkus->price : $product->price}}</span>
                       </div>
                        @if (!empty(setting('display_reviews_frontend')))
                         <div class="rating123">
                            @if($product->reviews->count() > 0)
                              <div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
                                <meta itemprop="reviewCount" content="{{$product->reviews->count()}}" />
                                <meta itemprop="ratingValue" content="{{$avg}}" />
                              </div>
                            @endif
                              <span class="rateicon">
                                 <div class="rate" data-rate-value="{{$avg}}" ></div>
                              </span>
                              <a href="#" id="gotoreview">{{__('messages.view_all_reviews')}}</a>
                         </div>
                        @endif
                        <div class="details">
                          <span><strong>{{__('messages.sku')}}:</strong>@if($product->sku) {{$product->sku}} @endif</span>

                          <span>
                            <strong>{{__("messages.weight")}}:</strong>
                            <span class="weight">{{!empty($productSkus) ? $productSkus->weight : $product->weight}}</span> {{setting('weight_in')}}
                          </span>
                        </div>
                        <div class="col-lg-12 row px-0">
                          @if($product->status)
                            @if (isset($attributes) && $attributes->count())
                              <div class="attribute-selector col-lg-4">
                                  @foreach($attributes as $attribute)
                                      @foreach ($productSkus->productSkuValues as $productSkuValues)
                                          @if ($productSkuValues->attribute_id)
                                              @php ($selectedId = app('request')->input('option') ?? $productSkuValues->attribute_option_id)
                                          @endif
                                      @endforeach
                                      <div class="selectoption">
                                          <strong>
                                            <sup>*</sup>{{$attribute->name}}:
                                          </strong>
                                          {!! Form::select("attribute_options[$attribute->id]", 
                                            $attribute->attributeOptions()->whereIn('id', $product->attribute_option_id)->pluck('option','id'),
                                            $selectedId,
                                            ['id' => 'attributes', 'class' => 'select2 form-control attribute-option-change mb-0']) !!}
                                      </div>
                                  @endforeach
                              </div>
                            @endif
                            <div class="quantity col-lg-4 mb-lg-0">
                              <strong>QTY</strong>
                              <div class="count col-12 px-0">
                                  {{-- <i class="icon-minus icon-minus-quantity"></i> --}}
                                  {{-- {!! Form::numberWrapped("quantity", 1, ['class' => 'quantity-count form-control mb-0', 'id' => "quantity" , 'min'=>'1', 'data-id' => $product->id ]) !!} --}}
                                  <div class="input-group number-wrapper">

                                    <input type="button" value="-" class="button-minus" data-field="quantity">
                                      {!! Form::number("quantity", 1, ['class' => 'quantity-count form-control mb-0', 'id' => "quantity" , 'min'=>'1']) !!}
                                      <input type="button" value="+" class="button-plus" data-field="quantity">
                                  </div>
                                  {!! Form::hidden("slug", $product->slug) !!}
                                  {{-- <span class="quantity-count">1</span> --}}
                                  {{-- <i class="icon-plus icon-plus-quantity"></i> --}}
                              </div>
                            </div>
                            <div class="col-xl-4">
                              <br />
                              <button type="button" class="btn btn-primary add-to-cart px-3" data-product="{{$product->slug}}">
                              <i class="icon-bag"></i> {{__('messages.add_to_cart')}}
                              </button>
                              @if (!empty(setting('wish_list_in_the_frontend')))
                              <button type="button" class="btn btn-primary add-to-wishlist" data-product="{{$product->slug}}">
                              <i class="icon-star"></i> {{__('messages.add_to_favourite')}}
                              </button>
                              @endif
                            </div>
                          @else
                            <div class="col-lg-12 details">
                              <span><strong>{{__('messages.unavailable')}}</strong>{{__('messages.availability')}}</span>
                            </div>
                            <br />
                            <div class="col-xl-4">
                              <a href="/contact-us" class="btn btn-primary add-to-cart px-3">
                                {{__('messages.contact_us')}}</a>
                            </div>
                          @endif
                        </div>
                    </div>
                  </div>
               </form>
               <div class="clearfix"></div>
               <div class="productdetail-content">

                  <div class="" id="myTabContent">
                        <h6>product description</h6>
                     <div class="contentarea" id="home" role="" aria-labelledby="home-tab"  itemprop="description">
                        @if($product->description) {!! $product->description !!} @endif
                     </div>

                       @if (!empty(setting('display_reviews_frontend')))
                          <h6>reviews</h6>
                          <div class="" id="profile" role="" aria-labelledby="profile-tab">
                          @if(count($product->reviews) > 0)
                             @foreach($product->reviews as $reviewdata)
                                <div class="review-row"  itemprop="review" itemtype="http://schema.org/Review" itemscope>
                                    <h5 itemprop="name">{{ $reviewdata->review_title }}</h5>
                                   <div class="rating123 rateicon" itemscope itemtype="http://schema.org/Rating">
                                      <div class="rate2" itemprop="ratingValue" content="{{$reviewdata->rating}}" data-rate-value={{$reviewdata->rating}} ></div>
                                       <meta itemprop="bestRating" content="5" />
                                       <meta itemprop="worstRating" content = "1">
                                   </div>
                                   <meta itemprop="datePublished" content="{{$reviewdata->publish_date}}">
                                   <meta itemprop="author" content="{{$reviewdata->author}}">
                                   <p itemprop="reviewBody">
                                    {{-- {{ strlen(strip_tags($reviewdata->review_description)) > 200 ? substr(strip_tags($reviewdata->review_description), 0, 200) . "..." : strip_tags($reviewdata->review_description)}} --}}
                                   {!! nl2br($reviewdata->review_description) !!}
                                 </p>

                                   <div class="date">{{__('messages.posted_by')}} {!! (empty($reviewdata->author ) || strtoupper($reviewdata->author) == 'N/A' ) ? 'Unknown': $reviewdata->author !!} {{__('messages.on')}} {{ \Carbon\Carbon::parse(strtotime($reviewdata->publish_date))->isoFormat('Do MMM YYYY')  }}</div>
                                </div>
                             @endforeach
                             <hr/>
                          @endif
                          @if(empty(setting('user_allowed_review')) || Auth::check())
                          <div id="{{setting('user_allowed_review')}}">
                            {!! Form::open(['url' => 'product/addreviews', 'name' => 'add-rating-form', 'id' => 'add-rating-form']) !!}

                                {!! RecaptchaV3::field('rating') !!}

                            @honeypot
                              <div class="reviewform">
                              <h5>Add Review</h5>
                              <div class="addrating rateicon" data-rate-value="0">
                                {!! Form::number('rating', 0, ['id' => 'rating', 'class' => 'form-control']) !!}
                              </div>
                              <div class="row">
                                 <div class="col-lg-6 col-md-12">
                              <div class="form-group">
                                 <!-- <label for="review_author">{{__('messages.author_name')}}</label> -->
                                 {!! Form::text('author', null, ['id' => 'review_author', 'class' => 'form-control', 'placeholder' => __('messages.author_name')]) !!}
                              </div>  </div>   <div class="col-lg-6 col-md-12">
                              <div class="form-group">
                                 <!-- <label for="review_title">{{__('messages.review_title')}}</label> -->
                                 {!! Form::text('review_title', null, ['id' => 'review_title', 'class' => 'form-control', 'placeholder' => __('messages.review_title')]) !!}
                              </div></div>   <div class="col-lg-12">
                              <div class="form-group" id="{{setting('default_user_review_status')}}">
                                 <!-- <label for="rating_review">{{__('messages.description')}}</label> -->
                                 {!! Form::textarea('review_description', null, ['id' => 'rating_review', 'class' => 'form-control', 'placeholder' => __('messages.description')]) !!}
                              </div>
                              <div class="form-group">
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                              {!! Form::hidden('user_id', 0, ['id' => 'review_user_id']) !!}
                               {!! Form::hidden('product_id', $product->id, ['id' => 'review_product_id']) !!}
                               {!! Form::hidden('product_name', $product->slug, ['id' => 'review_product_name']) !!}

                               {!! Form::hidden('status', (setting('default_user_review_status')) ? setting('default_user_review_status') : 2, ['id' => 'status']) !!}
                               <div class="col-lg-12">
                              <div class="card-action">
                                <button class="btn btn-success">{{__('messages.submit')}}</button>
                             </div> </div>
                             </div>

                             {!! Form::close() !!}
                            </div>
                          </div>
                          @endif
                          </div>
                      @endif
                  </div>
               </div>
            </div>
         </div>
         </div>
         @if(count($product->relatedProducts) > 0 && !empty(setting('related_products_on_product_detail_page')))
            @include('front.product.relatedproduct')
         @endif
      </section>
      <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <div id="video_content"></div>
            </div>
          </div>
        </div>
      </div>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('js/plugin/slick/slick.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\ReviewRequest', '#add-rating-form') !!}
<script src="{{ asset('js/home.js') }}"></script>
<script src="{{ asset('js/rater.js') }}" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $(".videopopup").click(function () {
        var theModal = $(this).children('img').data("target")
        var videoSRC = $(this).children('img').attr("data-video")
        if(theModal=='#videoModalYoutube')
        {
          var videoSRCauto = videoSRC + "?modestbranding=1&rel=0&controls=1&showinfo=0&html5=1&autoplay=1";
          html = '<iframe width="100%" height="350" src="'+videoSRCauto+'" frameborder="0" allowfullscreen allow="autoplay"></iframe>'
        }else{
          html=' <video width="100%" controls autoplay>'
          html+='<source src="'+videoSRC+'">'
          html+='Your browser does not support the video tag.'
          html+='</video>';
        }
        $("#video_content").html(html);
        $("#videoModal").modal('show');
           $("#videoModal").on('hidden.bs.modal', function () {
              $("#video_content").html('');
          });
        });
      $('.out-of-stock').hide();
      productPrice = parseFloat($("#price-count").text()).toFixed(2);
      existQuantity = parseInt({{$quantity}});
      @if ($product->inventory_tracking == 1 && empty($quantity))
          $('.out-of-stock'). show();
          $('.add-to-cart').attr('disabled',true);
      @else
        existQuantity = maximumQuantity;
      @endif

      $('#gotoreview').click(function() {
        $('html, body').animate({
          scrollTop: $("#profile").offset().top - 150
        }, 1000)
      });

      var options = {
       max_value: 5,
       step_size: 1,
       initial_value: 0,
       cursor: 'default',
       readonly: true,
       change_once: false,
      }
      var addoptions = {
       max_value: 5,
       step_size: 1,
       initial_value: 0,
       cursor: 'default',
       readonly: false,
       change_once: false,
      }
      $(".rate").rate(options);
      $(".rate2").rate(options);
      $(".addrating").rate(addoptions);
      $(".addrating").on("change", function(ev, data){
          $("#rating").val(data.to);
      });
      slickSlider();
    });

</script>

<script>
  
  $('.button-minus, .button-plus').on('click', function(e) {
      e.preventDefault();
        var parent = $(this).parents('.number-wrapper'),
        $element = parent.find('.quantity-count');
        if($(this).hasClass('button-plus') && $element.val() < 10){
            $element.val(parseInt($element.val())+1)
        } 
        if($(this).hasClass('button-minus') && $element.val() > 1) {
            $element.val(parseInt($element.val())-1)
        }
        $element.change().blur();
  });

</script>

@if (app('request')->input('option'))
    <script>
        $(function() {
            $('#attributes').trigger('change')
        })
    </script>
@endif


@endsection

