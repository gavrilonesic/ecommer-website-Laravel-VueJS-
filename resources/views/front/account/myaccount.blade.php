@extends('front.layouts.app')
@section('content')
      <!-- Main navigation row end-->
<section>
   <!--ads row-->
   <div class="ads-row">
      <div class="container">
        <!--  <img src="http://generalchemical.test/images/our-goal-img.jpg" alt="Our Goal" title="Our Goal" class="wow slideInUp" style="visibility: visible;"> -->
      </div>
   </div>
   <!-- ads row end-->
   <div class="myprofile-pg">
      <div class="container">
         <div class="row">
            <div class="col-lg-3 col-md-3 wow slideInLeft" >
               <div class="sidebar">
                  <div class="text-center image-preview">
                     <figure>
                       <div class="input-file input-file-image" data-original-title="Edit picture" data-toggle="tooltip">
                          <img class="img-upload-preview" src="{{ Auth::guard('web')->user()->getMedia('profilepic')->count() > 0 ? Auth::guard('web')->user()->getMedia('profilepic')->first()->getUrl() : asset('images/default-avatar.png')}}" alt="My Profile" title="My Profile">
                          <div class="editpic">
                          {!! Form::file('profile_pic', ['id' => 'profile_pic', 'class' => 'form-control form-control-file', 'accept' => 'image/*']) !!}
                          <i class="icon-pencil"></i></div>
                        </div>
                     </figure>
                  </div>
                  <ul>
                     <li><a href="{{ route('my_profile') }}" class="{{ \Request::route()->getName() == 'my_profile' ? 'active' : ''}}"><i class="icon-user"></i> {{__('messages.my_profile')}} </a></li>
                     <li><a href="{{ route('my_order') }}" class="{{ \Request::route()->getName() == 'my_order' ? 'active' : ''}}"><i class="icon-basket-loaded"></i> {{__('messages.my_orders')}} </a></li>
                     @if (!empty(setting('wish_list_in_the_frontend')))
                     <li><a href="{{ route('wishlist') }}" class="{{ isset($wishlists) ? 'active' : '' }}"><i class="icon-heart"></i>{{__('messages.my_wishlist')}} </li>
                      @endif
                     <li><a href="{{ route('my_addresses') }}" class="{{ \Request::route()->getName() == 'my_addresses' ? 'active' : ''}}">
                        <i class="icon-home"></i> {{__('messages.my_addresses')}} </a>
                     </li>
                  </ul>
               </div>
            </div>
            @if (\Request::route()->getName() == 'my_profile')
               @include('front.account.myprofile')
            @elseif (\Request::route()->getName() == 'wishlist')
               @include('front.account.mywishlists')
            @elseif (\Request::route()->getName() == 'my_order')
               @include('front.account.myorder')
            @elseif (\Request::route()->getName() == 'my_addresses')
               @include('front.account.myaddresses')
            @endif
         </div>
      </div>
   </div>
</section>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\CustomerRequest', '#edit-customer-form') !!}
<script type="text/javascript">
   $(".cancel-order-btn").click(function(){
      $("#order_id").val($(this).data('id'));
   });

   $(".removeproduct").click(function(){
      $.ajax({
           type: "GET",
           url: '/remove-from-wishlist',
           dataType: "json",
           data: {
               'product_id': $(this).data('id')
           }, // serializes the form's elements.
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           success: function(response) {
               if (response.status) {
                 window.location.reload();
               }
           }
      });
   });
</script>
@endsection