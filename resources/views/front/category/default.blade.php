@extends('front.layouts.app')
@section('content')
  <section>
      <!-- ads2 start -->
      @if($topBanner->count()>0)
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
                        @if(!empty($category->medias) || !empty($category->parent->medias) )
                          <img src="{{ !empty($category->medias) ? $category->medias->getUrl('thumb') : (!empty($category->parent->medias) ? $category->parent->medias->getUrl('thumb') : asset('images/no-image/default-category-list.png')) }}" alt="{{$category->name.' '.__('messages.logo')}}" title="{{__('messages.logo')}}" class="wow slideInLeft"/>
                          @endif
                          <div class="category-name-list">
                            @if ($parentCategory->count() > 0)
                              @foreach ($parentCategory as $key => $value)
                                <a href="{{ route('category.view', ['parentCategory' => $value->slug]) }}" class="{{$value->slug == request()->parentCategory ? 'active' : ''}}">
                                    {{$value->name}}
                                </a>
                              @endforeach
                            @endif
                          </div>
                          @if($leftSideBanner->count()>0)
                            <div class="ads-row">
                                <a href="{{$leftSideBanner->link}}">
                                  <img src="{{ $leftSideBanner->getMedia('banner')->first()->getUrl() }}" alt="{{$leftSideBanner->name}}" title="{{$leftSideBanner->name}}" class="wow slideInUp"/>
                                </a>
                            </div>
                          @endif
                          <div class="col-sm-12" style="margin-bottom: 20px; text-align: center;">
                            <a href="javascript:void(0)" data-url="{{ route('category.inquiry',['parentCategory' => \Request::route('parentCategory')]) }}" class="btn btn-primary custom-btn product-quick-view">{{__('messages.contact_us')}}</a>
                          </div>
                      </aside>
                  </div>
                  <!-- sidebar end-->
                  <!-- rightside content start-->
                  <div class="col-md-9">
                      <article>
                        @if(!empty(strip_tags($category->description)))
                          <div class="content">
                              {!! $category->description !!}
                          </div>
                        @endif
                          <div class="category-list col-sm-12">
                              <ul class="row">
                                  @if ($category->childs->count())
                                    @foreach ($category->childs as $key => $category)
                                        <li class="col-12 col-sm-6 col-md-6 col-lg-6 wow fadeIn">
                                            <figure style="background-image:url('{{ !empty($category->medias) ? $category->medias->getUrl('thumb') : asset('images/no-image/default-category-list.png') }}')">
                                            </figure>
                                            <h4>
                                                {{$category->name}}
                                            </h4>
                                            <p>
                                              {{ strlen(strip_tags($category->short_description)) > 200 ? substr(strip_tags($category->short_description), 0, 200) . "..." : strip_tags($category->short_description)}}
                                            </p>
                                            <a href="{{ route('category.view', ['parentCategory' => $category->slug]) }}" class="btn btn-round">
                                                {{__('messages.view')}}
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