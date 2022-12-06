@extends('front.layouts.app')
@section('content')
   <section>
      <!-- ads2 start -->
      @if($topBanner->count()>0)
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
               <div class="col-md-3">
                  <aside>
                     <img src="{{ !empty($category->medias) ? $category->medias->getUrl('thumb') : (!empty($category->parent->medias) ? $category->parent->medias->getUrl('thumb') : asset('images/no-image/default-category-list.png')) }}" alt="{{$category->name.' '.__('messages.logo')}}" title="{{__('messages.logo')}}"
                        class="wow slideInLeft">
                      <div class="category-name-list">
                           @if ($parentCategory->count() > 0)
                              @foreach ($parentCategory as $key => $value)
                                 <a href="{{ route('category.view', ['parentCategory' => $value->slug]) }}" class="{{$value->slug == request()->parentCategory ? 'active' : ''}}"> {{$value->name}} </a>
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
                  </aside>
               </div>
               <!-- sidebar end-->
              <!-- rightside content start-->
              <div class="col-md-9">
                  <article>
                      <h2>{{$category->name}}</h2>
                      <div class="content">
                          {{-- <div class="row imgcontent">
                              <div class="col-sm-12">
                                  <img src="{{ $category->getMedia('category')->count() > 0 ? $category->getMedia('category')->first()->getUrl() : asset('images/img1.png') }}" alt="Add" title="Add" class="wow slideInUp">
                              </div>
                          </div> --}}
                          {!! $category->description !!}
                      </div>
                       <!-- Table data-->
        @if (!empty($compareProductFields))
          <div class="table2-data wow slideInUp">
              <div class="container">
                  <table>
                      <tr>
                          <th> {{__('messages.product')}} </th>
                          @foreach ($compareProductFields as $row)
                            <th> {{ ucfirst($row) }} </th>
                          @endforeach
                      </tr>
                      @foreach ($compareProductList as $product)
                      <tr>
                          <td>
                              {{ $product['name'] }}
                          </td>
                          @foreach ($compareProductFields as $row)
                            <td>
                                {{ isset($product['custom_fields'][$row]) ? $product['custom_fields'][$row] : "NA"}}
                            </td>
                          @endforeach
                      </tr>
                      @endforeach
                  </table>
              </div>
          </div>
        @endif
        <!-- Table data end-->
    <!-- innere page product listing-->
    @include('front.product.product_list')
    <!-- innere page product listing end-->
                  </article>
              </div>
              <!-- rightside content start end-->
            </div>
         </div>
      </div>
      <!-- sidbar and categorylist end-->

   </section>
@endsection