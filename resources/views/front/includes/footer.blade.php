<!-- sign up section-->
@include('front.includes.newsletter')
<!-- sign up section end-->
<!-- footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 text-lg-left text-md-left text-sm-center col-lg-3 col1">
                    <a href="{{ url('/') }}" ><img src="{{ asset('images/footer-logo.png') }}" alt="" title=""></a>
                 <div><span class="icon-location-pin map"></span>
                        <p>{{ setting('address_line1') ? setting('address_line1') : '' }} {{ setting('address_line2') ? setting('address_line2') : '' }} <br/>{{ setting('city') ? setting('city').', ' : '' }} {{ setting('state') ? setting('state') : '' }} {{ setting('zipcode') ? setting('zipcode').', ' : '' }} {{ setting('country') ? setting('country') : '' }} </p>
                  </div>
                 <div><span class="icon-call-end  phone"></span><a href="tel:{{setting('mobile_no')}}">{{setting('mobile_no') ? setting('mobile_no') : ''}}</a></div>
                 <div><span class="icon-envelope  mail"></span> <a href="mailto:{{setting('email')}}">{{setting('email')}}</a></div>
           </div>
           <div class="col-sm-12 col-md-2 text-lg-left text-md-left text-sm-center col-lg-3 col2">
               <h6>HELPFUL LINKS</h6>
               <ul>
                   <li><a href="{{ route('home') }}">{{__('messages.home')}}</a></li>
                   <li><a href="{{ route('pages.slug', ['slug' => 'about-us']) }}"> {{__('messages.about_us')}} </a></li>
                   <li><a href="{{ route('store') }}">Shop Online </a></li>
                   <li><a href="{{ route('sds') }}">SDS </a></li>
                   <li><a href="{{ route('contact_us') }}"> {{__('messages.contact_us')}} </a></li>
                   <li><a href="{{ route('become_a_distributor.index') }}">Become a Distributor</a></li>
                   <li><a href="{{ route('pages.slug', ['slug' => 'privacy-policy']) }}"> {{__('messages.privacy_policy')}} </a></li>
                   <li><a href="{{ route('pages.slug', ['slug' => 'terms-conditions']) }}"> {{__('messages.terms_and_conditions')}} </a></li>
                   <li><a href="{{ route('pages.slug', ['slug' => 'returns-warranty']) }}"> {{__('messages.returns_and_warranty')}} </a></li>
               </ul>
           </div>
           <div class="col-sm-12 col-md-3 text-lg-left text-md-left text-sm-center col-lg-3 col2">
               <h6>working hours</h6>
               <p>
                {!! setting('working_hours') ? nl2br(setting('working_hours')) : '' !!}
                </p>
           </div>
           <div class="col-sm-12 col-md-3  text-lg-left text-md-left text-sm-center col-lg-3 col2">
               <h6>{{__('messages.my_account')}}</h6>
               <ul>
               <li><a href=" {{ route('login') }} ">{{__('messages.login')}}</a></li>
               <li><a href="{{ route('my_profile') }} ">{{__('messages.my_account')}}</a></li>
               <li><a href="{{ route('cart') }}">My Cart</a></li>
                @if (!empty(setting('wish_list_in_the_frontend')))
               <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
               @endif
               <li><a href="{{ route('checkout') }}">Checkout</a></li>
               </ul>
           </div>
        </div>
        <div class="row">
           <div class="copyright text-center col-12">
       &copy; General Chemical Corp. All Rights Reserved
        </div></div>
    </div>
</footer>
