@extends('front.layouts.app')
@section('content')
  <section>
      <!-- ads2 start -->
      @if (!empty($topBanner))
        <div class="ads-row">
            <div class="container">
              <a href="{{$topBanner->link}}">
                <img src="{{ $topBanner->getMedia('banner')->first()->getUrl() }}" alt="{{$topBanner->name}}" title="{{$topBanner->name}}" class="wow slideInUp"/>
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
                  <div class="col-md-3">
                      <aside>
                          <img src="{{ asset('images/cg-logo.png') }}" alt="Add" title="Add" class="wow slideInLeft"/>
                          <div class="category-name-list">
                            @if ($categories->count() > 0)
                              @foreach ($categories as $key => $value)
                                <a href="{{ route('category.view', ['parentCategory' => $value->slug]) }}">
                                    {{$value->name}}
                                </a>
                              @endforeach
                            @endif
                          </div>
                          @if (!empty($leftSideBanner))
                            <div class="ads-row">
                                <a href="{{$leftSideBanner->link}}">
                                  <img src="{{ $leftSideBanner->getMedia('banner')->first()->getUrl() }}" alt="{{$leftSideBanner->name}}" title="{{$leftSideBanner->name}}" class="wow slideInUp"/>
                                </a>
                            </div>
                          @endif
                      </aside>
                  </div>
                  <!-- sidebar end-->
                  <!-- rightside content start-->
                  <div class="col-md-9">
                      <article>
                          <div class="category-list col-sm-12">
                              <ul class="row">
                                  @if ($category->childs->count())
                                    @foreach ($category->childs as $key => $category)
                                        <li class="col-12 col-sm-6 col-md-6 col-lg-6 wow fadeIn">
                                            <figure style="background-image:url('{{ asset('images/category-list-img.png') }}')">
                                            </figure>
                                            <h4>
                                                {{$category->name}}
                                            </h4>
                                            <p>
                                              {{ strlen(strip_tags($category->description)) > 200 ? substr(strip_tags($category->description), 0, 200) . "..." : strip_tags($category->description)}}
                                            </p>
                                            <a href="#" class="btn btn-round">
                                                buy now
                                            </a>
                                        </li>
                                      @endforeach
                                  @endif
                              </ul>
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
<script>
  
  $('.button-minus, .button-plus').on('click', function(e) {
      e.preventDefault();
      var parent = $(e.target).closest('.number-wrapper'),
      $element = parent.find('input.quantity-count');
      if($(e.target).hasClass('button-plus') && $element.val() < 10) $element[0].stepUp(1);
      if($(e.target).hasClass('button-minus') && $element.val() > 1) $element[0].stepDown(1);
      $element.change().blur();
  });

</script>
@endsection