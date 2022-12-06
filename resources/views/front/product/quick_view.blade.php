<!-- The Modal -->
@php
    $ind = rand(0,12304123123);
@endphp

<div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">
                {{$product->name}}
            </h4>
            <button type="button" class="close" data-dismiss="modal">
                &times;
            </button>
        </div>
        <!-- Modal body -->
        <form id="quick-add-to-cart-form">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-4 text-center quick-img-div">
                        @if  (!empty($productSkus) && !empty($productSkus->medias))
                            <img src="{{ $productSkus->medias->getUrl('thumb') }}" alt="{{$productSkus->medias->custom_properties['description'] ?? $productSkus->medias->file_name}}" />
                        @elseif ($product->medias->count() > 0)
                            <img src="{{ $product->medias->first()->getUrl('thumb') }}" alt="{{$product->medias->first()->custom_properties['description'] ?? $product->medias->first()->file_name}}" />
                        @else
                            <img src="{{ asset('images/no-image/default-product-page-list.png') }}"/>
                        @endif
                        <label id="quick-out-of-stock" class="out-of-stock"> {{__('messages.out_of_stock')}} </label>
                    </div>
                    <div class="col-md-12 col-lg-8">
                        <div class="detailbox datacol">
                            @if (!empty($product->brand->name))
                              <strong>
                                  {{__('messages.brand')}} :
                              </strong>
                              {{$product->brand->name}}
                              <br/>
                            @endif
                            <strong class="weight">
                                {{__("messages.weight")}}:
                            </strong>
                            <span class="quick-weight">{{!empty($productSkus) ? $productSkus->weight : $product->weight}}</span> {{setting('weight_in')}}
                            <br/>
                            {{-- <strong>
                                Type of Product:
                            </strong>
                            Diesel Engine Oil
                            <br/> --}}

                            @if (isset($attributes) && $attributes->count())
                                @foreach($attributes as $attribute)
                                    @foreach ($productSkus->productSkuValues as $productSkuValues)
                                        @if ($productSkuValues->attribute_id)
                                            @php ($selectedId = $productSkuValues->attribute_option_id)
                                        @endif
                                    @endforeach
                                    <div class="selectoption">
                                        <strong>
                                            *{{$attribute->name}}:
                                        </strong>
                                        <br/>
                                        {!! Form::select("attribute_options[$attribute->id]", $attribute->attributeOptions()->whereIn('id', $product->attribute_option_id)->pluck('option','id'), $selectedId, ['id' => 'attributes', 'class' => 'select2 form-control attribute-option-change']) !!}
                                    </div>
                                @endforeach
                            @endif
                            <div class="description">
                                <strong>
                                    {{__('messages.about_product')}}:
                                </strong>
                                <p>
                                    {{$product->short_description}}
                                </p>
                            </div>
                        </div>
                        <div class="price">
                            <div class="count">
                                {{-- <i class="icon-minus icon-minus-quantity">
                                </i> --}}
                                <strong>{{__('messages.qty')}} </strong>
                                {{-- {!! Form::numberWrapped('quantity', 1, [
                                    'class' => 'quick-quantity-count form-control',
                                    'data-id' => $product->id,
                                    'id' => 'quick-quantity',
                                    'min'=>'1'
                                    ]) !!} --}}

                                    
                                <div class="input-group number-wrapper" id="number-wrapper-{{ $ind }}">
                                        
                                    <input type="button" value="-" class="button-minus" data-field="quantity">
                                    {{-- <span id="quantity-{{$value['id']}}">
                                        {{$value['quantity']}}
                                    </span> --}}
                                    {{-- {!! Form::numberWrapped("quantity", $value['quantity'], ['class' => 'quantity-count form-control', 'id' => "quantity-".$value['id'] , 'min'=>'1','data-id'=> $value['id']]) !!} --}}
                                    {!! Form::number("quantity", 1, ['class' => 'quick-quantity-count quantity-field quantity-count form-control', 'id' => "quick-quantity" ,'min'=>'1']) !!}
                                    <input type="button" value="+" class="button-plus" data-field="quantity">
                                </div>

                                {!! Form::hidden("slug", $product->slug) !!}
                                {{-- <span class="quantity-count">
                                    1
                                </span> --}}
                                {{-- <i class="icon-plus icon-plus-quantity"> --}}
                                </i>
                            </div>
                            <br/>
                            {{setting('currency_symbol')}}<span id="quick-price-count">{{!empty($productSkus) ? $productSkus->price : $product->price}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary quick-add-to-cart" data-product="{{$product->slug}}">
                    <i class="icon-bag">
                    </i>
                    {{__('messages.add_to_cart')}}
                </button>
                @if (!empty(setting('wish_list_in_the_frontend')))
                <button type="button" class="btn btn-primary add-to-wishlist" data-product="{{$product->slug}}">
                    <i class="icon-heart">
                    </i>
                    {{__('messages.add_to_favourite')}}
                </button>
                @endif
                or <a href="{{ route('product.detail', ['product' =>$product->slug]) }}"> {{__('messages.view_details')}}</a>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.out-of-stock').hide();
    productPrice = parseFloat($("#quick-price-count").text()).toFixed(2);
    var existQuantity = parseInt({{$quantity}});
    @if ($product->inventory_tracking == 1 && empty($quantity))
        $('.out-of-stock'). show();
        $('.quick-add-to-cart').attr('disabled',true);
    @else
        existQuantity = maximumQuantity;
    @endif
</script>

<script>
  
    $('#number-wrapper-{{ $ind }} .button-minus, #number-wrapper-{{ $ind }} .button-plus').on('click', function(e) {
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