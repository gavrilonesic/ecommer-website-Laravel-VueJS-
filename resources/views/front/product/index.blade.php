@extends('front.layouts.app')
@section('content')
   <section>
      <!-- ads2 start -->
      @if (!empty($topBanner))
        <div class="ads-row">
           <div class="container">
              <a href="{{$topBanner->link}}">
                <img src="{{ $topBanner->getMedia('banner')->first()->getUrl() }}" alt="{{$topBanner->name}}" title="{{$topBanner->name}}" class="wow slideInUp">
              </a>
           </div>
        </div>
      @endif
      <!-- ads2 end -->
      <!-- sidbar and categorylist-->
      <div class="container">
         <div class="sidebar-and-content">
            <div class="row">
               <!-- sidebar-->
                <div class="col-md-12 stickycategory">
                  <aside class="stickyaside">
                      @if (!empty($leftSideBanner))
                        <div class="ads-row">
                            <a href="{{$leftSideBanner->link}}">
                              <img src="{{ $leftSideBanner->getMedia('banner')->first()->getUrl() }}" alt="{{$leftSideBanner->name}}" title="{{$leftSideBanner->name}}" class="wow slideInLeft"/>
                            </a>
                        </div>
                      @endif

                      <!--listing-->
                      <div id="accordion" class="wow zoomIn category-accordion">
                        @if ($categories->count() > 0)
                          @foreach ($categories as $value)
                            <div class="card parent-category {{ Request::input('category') == $value->slug ? 'active' : '' }}">
                                <div class="card-header">
                                    @if ($value->childs->count() > 0)
                                      <a class="card-link" data-toggle="collapse" href="#collapse-{{$value->id}}">
                                         {{$value->name}}
                                      </a>
                                    @else
                                      <a class="card-link" href="{{route('store', ['category' => $value->slug])}}">
                                        {{$value->name}}
                                      </a>
                                    @endif
                                </div>
                                @if ($value->childs->count() > 0)
                                  <div id="collapse-{{$value->id}}" class="collapse" data-parent="#accordion">
                                      <div class="card-body">
                                        @foreach ($value->childs as $child)
                                          <a href="{{route('store', ['category' => $child->slug])}}" class="{{Request::input('category') == $child->slug ? 'active' : '' }}">{{$child->name}}</a>
                                        @endforeach
                                      </div>
                                  </div>
                                @endif
                            </div>
                          @endforeach
                        @endif
                      </div>
                      <!--listing end-->
                      {{-- <div class="ads-row">
                          <img src="{{ asset('images/sidebar-ads.png') }}" alt="Add" title="Add" class="wow slideInUp">
                      </div> --}}
                  </aside>
                </div>
                <div class="col-md-12">
                  <article>

                     @if(!empty(Request::input('search_query')))
                      {{'Search Results for '}}<strong>{{Request::input('search_query')}}</strong>
                     @else
                     <div class="breadcrumb-row">
                     <h2>{{__('messages.products')}}</h2>
                       @if (!empty($category) && !empty($category->parent))
                          <ul class="breadcrumbs">
                            <li class="breadcrumb-item">
                              <a href="{{ route('store') }}">
                                  <i class="icon-home"></i>
                              </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="breadcrumb-item"><a>{{$category->parent->name}}</a></li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
                          </ul>
                       @endif</div>
                     @endif
                      <div class="content">
                        <!-- innere page product listing-->
                        @if ($products->count() > 0)
                          @include('front.product.product_list', ['showFourProduct' => 1])
                        @else
                          <div class="row">
                            <div class="col-lg-12 wow zoomIn notfound mt-4 ">
                              <h3>{{__('messages.product_not_found')}}</h3>
                            </div>
                          </div>
                        @endif

                      </div>
                  </article>
                </div>
               <!-- rightside content start end-->
            </div>
         </div>
      </div>
      <!-- sidbar and categorylist end-->
   </section>
@endsection
@section('script')
<script type="text/javascript">
  @if(!empty(Request::input('category')))
    var section = $(".category-accordion").find('a.active');
    if (section.length == 1) {
      // $(section).closest('div.collapse').addClass('show');
      $(section).closest('div.parent-category').addClass('parent-active');
    }
  @endif
</script>
@endsection