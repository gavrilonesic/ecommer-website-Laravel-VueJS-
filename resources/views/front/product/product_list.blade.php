<div class="innerpg-product-list popular-products">
    <div class="container">
        <div class="row">
           @if ($products->count() > 0)
              @foreach ($products as $product)
                 <div class="{{ isset($showFourProduct) ? 'col-lg-3' : 'col-lg-4' }} mb-3 col-md-6 col-sm-6 text-center col-xs-12 wow zoomIn" itemscope itemtype="http://schema.org/ItemList">
                    @include('front.product.product')
                 </div>
              @endforeach
           @endif
        </div>
        <div class="text-center">
            @if($products->total() > $products->perPage())
                <div class="pagination-row">
                  {{ $products->appends($_GET)->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@section('upper_script')
  <script type="text/javascript">
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
    </script>
@endsection