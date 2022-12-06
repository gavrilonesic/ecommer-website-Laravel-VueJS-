@extends('front.layouts.app')

@section('content')
<section>
    <div class="cartpage">
        <div class="container">
            <div class="text-center">
                <h2>
                    {{__('messages.shopping_cart')}}
                </h2>
                <div class="row">
                  @php
                    $grandTotal = 0.00;
                  @endphp
                  @if (!empty($cart))
                      <div class="col-md-8  wow slideInLeft ">
                        <div class="cart-data">
                          <span id="product-remove"></span>
                          @foreach($cart as $value)
                            @php
                              $productSku = '';
                              //Select here product sku key from products object
                              if (!is_string($value['id']) && $products[$value['attributes']['product_id']]->productSkus->count() > 0) {
                                $product = $products[$value['attributes']['product_id']];
                                $productSku = $product->productSkus->filter(function($item) use($value) {
                                    return $item->id == $value['id'];
                                })->first();
                              } else {
                                $product = $products[$value['attributes']['product_id']];
                              }
                              $price = !empty($productSku) ? $productSku->price : $product->price;
                              $grandTotal = $grandTotal + ($price * $value['quantity']);
                            @endphp
                            <div class="col-md-12 cart-data-list">
                                <a class="removeproduct" href="javascript:void(0)" data-id="{{$value['id']}}">
                                    <i class="icon-close">
                                    </i>
                                </a>
                                <div class="row text-left">
                                    <div class="imgbox datacol">
                                        <img src="{{ ((!empty($productSku) && !empty($productSku->medias)) ? $productSku->medias->getUrl() : (!empty($product->medias[0]) ? $product->medias[0]->getUrl() : asset('images/no-image/default-new-arrival-home.png'))) }}" alt="{{$product->name}}" />
                                    </div>
                                    <div class="detailbox datacol">
                                        <h5><a href="{{ route('product.detail', ['product' =>$product->slug]) }}">{{$value['name']}}</a></h5>
                                        @if (!empty($product->brand->name))
                                          <strong>
                                              {{__('messages.brand')}}:
                                          </strong>
                                          {{$product->brand->name}}
                                          <br/>
                                        @endif
                                        {{-- Display here attribute and attribute option --}}
                                        @if (!empty($productSku))
                                          @foreach ($productSku->productSkuValues as $row)
                                            <strong>
                                              {{$row->attribute->name}}:
                                            </strong>
                                            {{$row->attributeOptions->option}}
                                            <br/>
                                          @endforeach
                                        @endif
                                        @php
                                          if($product->inventory_tracking == 0) {
                                            $quantity = config('constants.MAXIMUM_QUANTITY_PER_PRODUCT');
                                          } else if (!empty($product->inventory_tracking) && !empty($product->inventory_tracking_by)) {
                                              $quantity = $productSku->quantity;
                                          } else {
                                              $quantity = $product->quantity;
                                          }
                                        @endphp
                                        <div class="count exist-quantity" data-quantity="{{$quantity}}">
                                          <strong>{{__('messages.qty')}} </strong>
                                          @php
                                              $ind = rand(0,12304123123);
                                          @endphp
                                          <div class="input-group number-wrapper">
                                            <input type="button" value="-" class="button-minus" data-field="quantity">
                                              {!! Form::number("quantity", $value['quantity'], ['class' => 'quantity-field quantity-count form-control', 'id' => "quantity-".$value['id'] , 'min'=>'1','data-id'=> $value['id']]) !!}
                                              <input type="button" value="+" class="button-plus" data-field="quantity">
                                          </div>
                                        </div>
                                    </div>
                                    <div class="add-remove-row datacol">
                                        <div class="price">
                                            {{setting('currency_symbol')}}<span id="price-{{$value['id']}}">{{ number_format(round($price * $value['quantity'],2),2)}}</span>
                                        </div>
                                    </div>
                                </div>
                                @if($quantity < $value['quantity']  && $product->inventory_tracking != 0)
                                  <label class="out-of-stock"> {{__('messages.out_of_stock')}} </label>
                                @endif
                            </div>
                          @endforeach
                          <div class="text-right action">
                              <a href="{{ route('store') }}" class="btn btn-primary">
                                  {{__('messages.continue_shopping')}}
                              </a>
                              <a href="javascript:void(0)" class="btn btn-primary place-order">
                                  <!-- {{__('messages.place_order')}} -->
                                  {{__('messages.checkout')}}
                              </a>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-4 wow slideInRight ">
                        {{-- <div class="couponbox">
                            <input type="text" placeholder="Enter Your Code" id="coupon_code" />
                            <button type="button" id="apply-coupon" class="btn btn-round">
                                {{__('messages.apply_coupon')}}
                            </button>
                            <br/>
                            <span id="coupon-error"></span>
                        </div> --}}
                        <div class="pricedetail text-left">
                            <h5>
                                {{__('messages.price_details')}}
                            </h5>
                            <div class="content">
                                <table>
                                    <tr>
                                        <td>
                                            {{__('messages.price')}} (<span id="total-quantity">{{ !empty($cart) ? array_sum(array_column($cart, 'quantity')) : 0}}</span> {{__('messages.items')}})
                                        </td>
                                        <td>
                                            {{setting('currency_symbol')}}<span id="total-price">{{number_format(round($grandTotal,2),2)}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{__('messages.shipping_fee')}}
                                        </td>
                                        <td>
                                            -
                                        </td>
                                    </tr>
                                    <tr class="discount {{ (!$displayCoupon) ? 'd-none':''}}">
                                        <td>
                                            {{__('messages.discount')}}
                                        </td>
                                        <td>
                                            {{setting('currency_symbol')}}<span id="discount">0.00</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{__('messages.total_payable')}}
                                        </th>
                                        <th>
                                            {{setting('currency_symbol')}}<span id="grand-total">{{number_format(round($grandTotal,2),2)}}</span>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                      <div class="col-md-12 cart-data-list no-item-cart">
                        <p> {{__('messages.no_item_in_your_cart')}} </p>
                      </div>
                      <br/>
                      <br/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script type="text/javascript">
  var grandTotal = "{{$grandTotal}}";
  function incDecQuantity($this, count)
  {
    existQuantity = $this.parent('div.exist-quantity').data('quantity');
    if (count) {
      var quantity = parseInt($("#quantity-" + $this.data('id')).val());
      if(!quantity) {
        quantity = $this.val();
      }
      // if (quantity < 1 || maximumQuantity < quantity || quantity > existQuantity) {
      //   return;
      // }
      $("#quantity-" + $this.data('id')).val(quantity);
    }

    $.ajax({
        type: "POST",
        url: '/cart/update-to-cart',
        dataType: "json",
        data: {
          'id': $this.data('id'), 'quantity': quantity
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            triggerCheckoutEvent(1)

            if (response.status) {
              $("#total-price").text(addCommas(response.grandTotal.toFixed(2)));
              $("#total-quantity").text(response.quantity);
              if(! quantity){
                emptyCart($this);
                // $this.closest('.removeproduct').trigger('click');
                // alert();
              }
              $("#price-" + $this.data('id')).text(addCommas(response.price.toFixed(2)));
              grandTotal = response.grandTotal.toFixed(2);
              /*if ($("#coupon_code").val().trim() != "" && couponValid == true) {
                $("#apply-coupon").trigger('click');
              } else {
                $("#grand-total").text(grandTotal);
              }*/
              $("#grand-total").text(addCommas(grandTotal));
            } else {
              console.log("error - ")
            }
        }
    });
  }

  $('.place-order').click(function() {
    if ($('.out-of-stock').length == 0) {
      location.href = "{{ route('checkout') }}"
    } else {
      alert('Please remove first out of stock product');
    }
  });

  $('body').on('click', '.removeproduct', function(e) {
    incDecQuantity($(this));
    // emptyCart($(this));
    // $("#product-remove").text("{{__('messages.product_successfully_removed')}}");
    // $("#product-remove").css("color","green");
    // setTimeout(function(){
    //         $("#product-remove").text('');
    // }, 3000);
    /*if ($("#coupon_code").val().trim() != "" && couponValid == true) {
      $("#apply-coupon").trigger('click');
    }*/
  });
  function emptyCart($this)
  {
    flashMessage('success', "{{__('messages.product_successfully_removed')}}");
    $this.closest('.cart-data-list').remove();
    if ($(".cart-data-list").length == "0") {
      $(".cart-data").closest('div.row').remove();
    }
  }
  var couponValid = false;
  /*$('body').on('click', '#apply-coupon', function(e) {
    if ($("#coupon_code").val().trim() == "") {
      $("#coupon-error").text("{{__('messages.please_enter_coupon_code')}}");
      return;
    }

    $.ajax({
        type: "POST",
        url: '/apply-coupon',
        dataType: "json",
        data: {
          'coupon_code': $("#coupon_code").val(), grand_total: grandTotal
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success == true) {
              couponValid = true;
              $("#grand-total").text(response.grandTotal)
              $("#discount").text(response.discount)
            } else {
              couponValid = false;
              $("#coupon-error").text(response.error);
            }
        }
    });
  });*/
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

@endsection