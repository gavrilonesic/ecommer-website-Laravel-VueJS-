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
                        <div class="row">
                           <div class="col-sm-12 col-md-12 {{ ($productApplication) ? 'col-lg-6' : "" }}">
                              {!! $category->description !!}
                           </div>
                           @if ($productApplication)
                              <div class="col-sm-12 col-md-12 col-lg-6">
                                 <!-- Table data-->
                                 <div class="table2-data">
                                    <table>
                                       <tr>
                                          <th>{{__('messages.products')}}</th>
                                          <th>{{__('messages.application')}}</th>
                                       </tr>
                                       <tr>
                                          @foreach($compareProductList as $product)
                                             @if (isset($product['custom_fields']['application']))
                                                <td>{{ $product['name'] }}</td>
                                                <td>{{ $product['custom_fields']['application'] }}</td>
                                             @endif
                                          @endforeach
                                       </tr>
                                    </table>
                                 </div>
                                 <!-- Table data end-->
                              </div>
                           @endif
                        </div>
                     </div>
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