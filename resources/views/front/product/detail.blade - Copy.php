@extends('front.layouts.app')
@section('content')
<section>
         <div class="product-details-page">
            <div class="container">
              <form id="add-to-cart-form">
               <div class="row">
                  <div class="col-md-12 col-lg-4 text-center">
                     <div class="productimg">
                        <div id="slider">
                           <ul>
                            @if($product->medias)
                              @foreach($product->medias as $key => $image)
                              <li><img src="{{ $image->getUrl() }}"></li>
                              @endforeach
                            @endif
                           </ul>
                        </div>
                     </div>
                  </div>
                      <div class="col-md-12 col-lg-8">
                       <h4>@if($product->name) {{$product->name}} @endif</h4>
                       <div class="price">@if($product->price) {{setting('currency_symbol')}}<span id="price-count">{{$product->price}}</span>@endif</div>
                       <div class="rating123">
                          <span class="rateicon">
                             <div class="rate" data-rate-value=5></div>
                          </span> 
                          <a href="#myTab" id="gotoreview">{{__('messages.view_all_reviews')}}</a>
                       </div>
                       <div class="details">
                          <span><strong>{{__('messages.sku')}}:</strong>@if($product->sku) {{$product->sku}} @endif</span> 
                          <span><strong>{{__('messages.weight')}}:</strong>@if($product->sku) {{$product->sku}} @endif {{ env('PRODUCT_WEIGHT_UNIT'), 'LBS' }}</span> 
                          <span><strong>{{__('messages.shipping')}}:</strong>{{__('messages.calculated_at_checkout')}}</span>
                          <span>
                            @if (isset($attributes) && $attributes->count())
                                @foreach($attributes as $attribute)
                                    @foreach ($product->productSkus[0]->productSkuValues as $productSkuValues)
                                        @if ($productSkuValues->attribute_id)
                                            @php ($selectedId = $productSkuValues->attribute_option_id)
                                        @endif
                                    @endforeach
                                    <div class="selectoption">
                                        <strong>
                                          <sup>*</sup>{{$attribute->name}}:
                                        </strong>
                                        {!! Form::select("attribute_options[$attribute->id]", $attribute->attributeOptions()->whereIn('id', $product->attribute_option_id)->pluck('option','id'), $selectedId, ['id' => 'attributes', 'class' => 'select2 form-control attribute-option-change']) !!}
                                    </div>
                                @endforeach
                            @endif
                          </span>
                       </div>
                        <div class="quantity">
                          <h5>QTY </h5>
                          <div class="count">
                              <i class="icon-minus icon-minus-quantity"></i>
                              {!! Form::hidden("quantity", 1, ['class' => 'quantity-count', 'id' => "quantity"]) !!}
                              {!! Form::hidden("slug", $product->slug) !!}
                              <span class="quantity-count">1</span>
                              <i class="icon-plus icon-plus-quantity"></i>
                          </div>
                       </div>
                       <button class="btn btn-primary">
                       	<i class="icon-bag"></i> {{__('messages.add_to_shopping_bag')}}
                       </button>
                       <button class="btn btn-primary">
                       	<i class="icon-star"></i> {{__('messages.add_to_favourite')}} 
                       </button>
                    </div>
               </div>
               </form>
               <div class="col-sm-12 detailtabing">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('messages.product_description')}}</a>
                     </li>
                     @if (!empty(setting('display_reviews_frontend')))
                     <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{__('messages.reviews')}}</a>
                     </li>
                     @endif
                  </ul>
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <p>@if($product->description) {!! $product->description !!} @endif</p>
                     </div>
                     @if (!empty(setting('display_reviews_frontend')))
                     <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                     @if(count($product->reviews) > 0)
                        @foreach($product->reviews as $reviewdata)
                           <div class="review-row">
                              <h6>{{ $reviewdata->author }}</h6>
                              <div class="rating123 rateicon">
                                 <div class="rate2" data-rate-value={{$reviewdata->rating}}></div>
                              </div>
                              <div class="date">{{__('messages.posted_on')}}: {{ date('d F, Y',strtotime($reviewdata->updated_at)) }}</div>
                              <p>{{ strlen(strip_tags($reviewdata->review_description)) > 200 ? substr(strip_tags($reviewdata->review_description), 0, 200) . "..." : strip_tags($reviewdata->review_description)}}</p>
                           </div>
                        @endforeach
                     @endif
                          <div>
                            {!! Form::open(['url' => 'product/addreviews', 'name' => 'add-rating-form', 'id' => 'add-rating-form']) !!}
                        
                              <div class="formdesign addreviewform">
                              <h5>Add Review</h5>
                              <div class="addrating rateicon" data-rate-value="5"></div>
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
                              </div> </div>

                              {!! Form::hidden('user_id', 0, ['id' => 'review_user_id']) !!}
                               {!! Form::hidden('product_id', $product->id, ['id' => 'review_product_id']) !!}
                               {!! Form::hidden('product_name', $product->slug, ['id' => 'review_product_name']) !!}
                               {!! Form::hidden('rating', 0, ['id' => 'rating']) !!}
                               {!! Form::hidden('status', null, ['id' => 'status']) !!}
                               <div class="col-lg-12">
                              <div class="card-action">
                                <button class="btn btn-success">{{__('messages.submit')}}</button>
                             </div> </div>
                             </div>

                             {!! Form::close() !!}
                          </div>
                          </div>

                     </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         </div>
         @if(count($product->relatedProducts) > 0)
            @include('front.product.relatedproduct')
         @endif
      </section>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\ReviewRequest', '#add-rating-form') !!}
<script src="{{ asset('js/product-detail.js') }}"></script>
<script src="{{ asset('js/rater.js') }}" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
      productPrice = parseFloat($("#price-count").text()).toFixed(2);
      $('#gotoreview').click(function() {
        $('#myTab a[href="#profile"]').tab('show');
      });

      var options = {
       max_value: 4.5,
       step_size: 0.5,
       initial_value: 0,
       //symbols: {},
       //selected_symbol_type: 'utf8_star', // Must be a key from symbols
       //convert_to_utf8: false,
       cursor: 'default',
       readonly: true,
       change_once: false, // Determines if the rating can only be set once
       //ajax_method: 'POST',
       //url: 'http://localhost/test.php',
       //additional_data: {}, // Additional data to send to the server
       //only_select_one_symbol: false, // If set to true, only selects the hovered/selected symbol and nothing prior to it
       //update_input_field_name = some input field set by the user
      }
      var addoptions = {
       max_value: 5,
       step_size: 0.5,
       initial_value: 0,
       cursor: 'default',
       readonly: false,
       change_once: false, // Determines if the rating can only be set once
       //ajax_method: 'POST',
       //url: 'http://localhost/test.php',
       //additional_data: {}, // Additional data to send to the server
       //update_input_field_name = some input field set by the user
      }
      $(".rate").rate(options);
      $(".rate2").rate(options);
      $(".addrating").rate(addoptions);
      $(".addrating").on("change", function(ev, data){
          $("#rating").val(data.to);
      });
    });

</script>
@endsection