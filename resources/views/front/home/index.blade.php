@extends('front.layouts.app')
@section('content')
<!-- banner secton start-->
<div class="banner-row">
   <div class="">
      <div class="bannerslide wow bounceInDown">
         <div class="owl-carousel owl-theme" id="home-page-banner">
            @if ($carousels->count() > 0)
               @foreach ($carousels as $carousel)
                  <div class="item">
                  <div class="bannerbg" style="background-image:url({{ !empty($carousel->backgroundimg) ? $carousel->backgroundimg->getUrl('large') : asset('images/banner1.jpg') }})">
                  </div>
                     <div class="container">
                     <div class="item-caption">

                        <div class="content">
                          @if(!empty($carousel->heading))
                           <h2>
                                   {{$carousel->heading}}
                           </h2>
                           @endif
                           @if(!empty($carousel->description))
                           <div class="slide-description">
                              @if($carousel->heading == "Hand Sanitizer 1171")
                                 <ul>
                                    <li>World Health Organization Recommended Formula</li>
                                    <li>75% Isopropyl Alcohol</li>
                                    <li>Fragrance-free</li>
                                    <li>Liquid, not gel</li>
                                    <li>Bottled in USA</li>
                                 </ul>
                                 <p>Available in 1 gallon jug, 5 gallon pail, 4 gallon case, and 55 gallon drum</p>
                              @else
                                 {!! $carousel->description !!}
                              @endif

                           </div>
                           @endif
                           @if(!empty($carousel->button_text))
                           <a class="btn btn-transparent" href="{{$carousel->link ?? "javascript:void(0)"}}" {{$carousel->link ? 'target="_blank"':''}}>
                                  {{$carousel->button_text}}
                           </a>
                           @endif
                        </div>
                        @if(!empty($carousel->medias))
                        <div class="bannerimg">
                              <img alt="{{$carousel->heading}}" src="{{ !empty($carousel->medias) ? $carousel->medias->getUrl() : asset('images/banner-product.png') }}">
                        </div>
                        @endif
                     </div>
                  </div>
                  </div>
               @endforeach
            @endif
         </div>
      </div>
   </div>
</div>
<!-- banner secton end-->
@if($smallWidthBanner->count()>0)
<!-- ads row-->
<div class="ads-row">
    <div class="container">
        <div class="row">
          @foreach($smallWidthBanner as $banner)
            <div class="col-sm-12 col-md-4 wow bounceInUp">
                <a target="_blank" href="{{!empty($banner->link)?$banner->link:'javascript:void(0);'}}">
                    <img alt="{{$banner->name}}" title ="{{$banner->name}}" src="{{ !empty($banner->medias) ? $banner->medias->getUrl() : asset('images/samll-ads.png') }}">
                </a>
            </div>
          @endforeach
        </div>
    </div>
</div>
<!-- ads row end-->
@endif
@if($fullWidthBanner->count()>0)
<!-- ads2 start -->
<div class="ads-row">
    <div class="container">
      <a target="_blank" href="{{!empty($fullWidthBanner->link)?$fullWidthBanner->link:'javascript:void(0);'}}">
        <img alt="{{$fullWidthBanner->name}}" class="wow slideInLeft" src="{{ !empty($fullWidthBanner->medias) ? $fullWidthBanner->medias->getUrl() : asset('images/our-goal-img.jpg') }}">
      </a>
    </div>
</div>
<!-- ads2 end -->
@endif


<!--New arriaval-->
<div class="new-arriavals text-center">
   <div class="container">
      <div class="row">
         <div class="col align-self-center">
         <div class="subttl">
         What we do
            </div>
            <h2>
            OUR SERVICES
            </h2>
         </div>
      </div>
   </div>
   <div class="product-list">
      <ul class="row">
         @if ($categories->count() > 0)
            @foreach ($categories as $category)
               <li class="col-sm-6 wow zoomIn">
                  <a href="{{ route('category.view', ['parentCategory' => $category->slug]) }}">
                     <div class="content">
                        <figure>
                           <img alt="{{$category->name}}" src="{{ !empty($category->medias) ? $category->medias->getUrl('medium') : asset('images/no-image/default-new-arrival-home.png') }}">
                        </figure>
                           <h4>
                              {{$category->name}}
                           </h4>
                           {{-- <p>
                              {{ strlen(strip_tags($category->name)) > 35 ? substr(strip_tags($category->name), 0, 33) . "..." : strip_tags($category->name)}}
                        </p> --}}
                     </div>
                  </a>
               </li>
            @endforeach
         @endif
      </ul>
   </div>
</div>
<!--New arriaval end-->
<!--tabing section-->
<div class="hometab-section">
<div class="container wow slideInUp">
<div class="row text-center">
         <div class="col-sm-12 align-self-center">
         <div class="subttl">
          Shop Now
            </div>
             <h2>
              our products
             </h2>

         </div>
 </div>
<ul class="nav nav-tabs">
   @if ($popularProducts->count() > 0)
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#popularpro"> Popular products</a>
      </li>
    @endif
    @if ($newProducts->count() > 0)
      <li class="nav-item">
        <a class="nav-link {{ ($popularProducts->count() == 0) ? 'active':''}}" data-toggle="tab" href="#Newpro">NEW PRODUCTS</a>
      </li>
    @endif
    @if ($featuredProducts->count() > 0)
      <li class="nav-item">
        <a class="nav-link {{ (($popularProducts->count() == 0) && ($newProducts->count() == 0))  ? 'active':''}}" data-toggle="tab" href="#featuredpro">FEATURED PRODUCTS</a>
      </li>
    @endif
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    @if ($popularProducts->count() > 0)
    <div id="popularpro" class="tab-pane active">
<!-- popular product-->
<div class="popular-products text-center">

             <div class="owl-carousel owl-theme" id="popular-products">
               {{-- @if ($popularProducts->count() > 0) --}}
                  @foreach ($popularProducts as $product)
                     <div class="item">
                      @include('front.product.product',with(['product' => $product->product]))
                     </div>
                  @endforeach
               {{-- @endif --}}
            </div>
         </div>
<!-- popular product end-->
</div>
@endif
@if ($newProducts->count() > 0)
    <div id="Newpro" class="tab-pane {{ ($popularProducts->count() == 0)  ? 'active':'fade'}}">
<!-- New product-->
<div class="new-products text-center">
             <div class="owl-carousel owl-theme" id="new-products">
               {{-- @if ($popularProducts->count() > 0) --}}
                  @foreach ($newProducts as $product)
                     <div class="item">
                        @include('front.product.product')
                     </div>
                  @endforeach
               {{-- @endif --}}
            </div>
         </div>
<!-- New product end-->
</div>
@endif
    @if ($featuredProducts->count() > 0)
    <div id="featuredpro" class="tab-pane {{ (($popularProducts->count() == 0) && ($newProducts->count() == 0))  ? 'active':'fade'}}">
<!-- featured product-->
<div class="featured-products text-center">
             <div class="owl-carousel owl-theme" id="featured-products">
                  @foreach ($featuredProducts as $product)
                     <div class="item">
                        @include('front.product.product')
                     </div>
                  @endforeach
            </div>
         </div>
<!-- featured product end-->
</div>
@endif
  </div>
</div>
</div>
<!--tabing end-->


@if ($clients->isNotEmpty())
<!-- clients carousel -->
<div class="container my-4 my-xl-5">
    <div class="row">
        <div class="col">
            <h2 class="text-center">Clients</h2>
            <p class="text-center mb-3">We deliver products on time to hundreds of valued customers,<br>from small end users to large Fortune 500 clients, across a diverse range of industries.</p>
            <div id="clients" class="owl-carousel owl-theme col-12">
                  @foreach ($clients as $client)
                     <div class="item text-center position-relative" style="min-height: 200px;">
                        <div class="absolute-y-center px-2">
                            <img src="{{$client->getMedia('clients')->first() ? $client->getFirstMediaUrl('clients') : asset('images/150x150.png')}}" alt="{{ $client->name }}" class="img-fluid" style="max-height: 150px;"/>
                        </div>
                     </div>
                  @endforeach
            </div>
        </div>
    </div>
</div>
<!-- clients carousel end -->
@endif

@if ($testimonials->count() > 0)
<!-- testimonial row-->
<div class="testimonial-row">
   <div class="container wow slideInRight">
      <div class="row">
         <div class="col-sm-12 align-self-center text-center">
            <div class="subttl">
               What they say
            </div>
            <h2>
               client TESTIMONIALS
            </h2>

         </div>
         <div class="col-sm-12">
            <div class="owl-carousel owl-theme" id="client-testimonials">
                  @foreach ($testimonials as $testimonial)
                     <div class="item">
                        <div class="content text-left">
                           <div class="month">
                              {{\Carbon\Carbon::parse($testimonial->date)->format('M')}}
                           </div>
                           <div class="date">
                              {{\Carbon\Carbon::parse($testimonial->date)->format('d')}}
                           </div>
                           <h4>
                              {{ strlen($testimonial->title) > 20 ? substr($testimonial->title, 0, 20) . "...": $testimonial->title}}
                           </h4>
                           <p>
                              {!! $testimonial->description !!}
                           </p>
                           <div class="name">
                                by
                              <strong>
                                 {{ucfirst($testimonial->author)}}
                              </strong>
                           </div>
                        </div>
                     </div>
                  @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
<!-- testimonial row end-->
@endif


<!-- about section -->
{{-- <div class="about-row text-center">
    <div class="container wow slideInUp">
        <div class="row">
            <div class="col align-self-center">
                <div class="subttl">
                    about general chemical
                </div>
                <h2>
                    SERVICES & SOLUTIONS
                </h2>

            </div>
        </div>
        <div class="about-link">
            <a href="{{ route('pages.slug', ['slug' => 'a-full-service']) }}">
                a full service
            </a>
            <a href="{{ route('pages.slug', ['slug' => 'let-the-savings-begin']) }}">
                Let the savings begin
            </a>
            <a href="{{ route('pages.slug', ['slug' => 'products-plus-services']) }}">
                PRODUCTS PLUS SERVICES
            </a>
            <a href="{{ route('pages.slug', ['slug' => 'full-cycle-solutions']) }}">
                FULL CYCLE SOLUTIONS
            </a>
            <a href="{{ route('pages.slug', ['slug' => 'proven-results']) }}">
                PROVEN RESULTS
            </a>
        </div>
        <div class="social-icons">
            @if (!empty(setting('twitter_link')))
              <a href="{{setting('twitter_link')}}" target="_blank">
                  <span class="icon-social-twitter twt">
                  </span>
              </a>
            @endif
            @if (!empty(setting('facebook_link')))
              <a href="{{setting('facebook_link')}}" target="_blank">
                  <span class="icon-social-facebook fb">
                  </span>
              </a>
            @endif
            @if (!empty(setting('dribbble_link')))
              <a href="{{setting('dribbble_link')}}" target="_blank">
                  <span class="icon-social-dribbble dribble">
                  </span>
              </a>
            @endif
            @if (!empty(setting('youtube_link')))
              <a href="{{setting('youtube_link')}}" target="_blank">
                  <span class="icon-social-youtube yt">
                  </span>
              </a>
            @endif
            @if (!empty(setting('email')))
              <a href="mailto:{{setting('email')}}" target="_blank">
                  <span class="icon-envelope mail">
                  </span>
              </a>
            @endif
        </div>
    </div>
</div> --}}
<!-- about section end-->
@endsection
@section('script')
  <script src="{{ asset('js/home.js') }}"></script>
@endsection
