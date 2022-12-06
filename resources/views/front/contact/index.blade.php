@extends('front.layouts.app')
@section('content')
<section>
    <div class="contactdetail">
        <div class="container">
            <div class="row">
                <!-- contact detail-->
                <div class="col-md-6 col-sm-12 wow fadeInLeft">
                    <h2>get in touch</h2>
                    <p>Please complete all the information below to help us<br> understand your manufacturing process and chemical requirements.</p>
                    <div class="hours">
                        <h5>Office Working hours</h5>
                        @php
                        $str = explode("\r\n",setting('working_hours'))
                        @endphp
                        @foreach($str as $key => $value)
                            {!! "<span>".$value."</span>"!!}
                        @endforeach
                       {{--  <span>Monday to Friday: 7:30 am to 4:30 pm</span>
                        <span>Saturday - Sunday Closed</span> --}}
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 wow fadeInRight">
                    <h5>{{__('messages.contact_information')}}</h5>
                    <div class="address-box">
                        <span>
                            <strong>{{__('messages.head_office')}}</strong>{{ setting('address_line1') ? setting('address_line1') : '' }} {{ setting('address_line2') ? setting('address_line2') : '' }} {{ setting('city') ? setting('city').', ' : '' }} {{ setting('state') ? setting('state') : '' }} {{ setting('zipcode') ? setting('zipcode').', ' : '' }} {{ setting('country') ? setting('country') : '' }}
                        </span>
                        <span>
                            <strong>{{__('messages.phone_fax')}}</strong> <a href="tel:{{setting('mobile_no')}}">{{setting('mobile_no')}}</a> / {{!empty(setting('fax')) ? setting('fax') : '-'}}
                        </span>
                        <span>
                            <strong>{{__('messages.email')}}</strong> <a href="mailto:{{setting('email')}}">{{setting('email')}}</a>
                        </span>
                    </div>
                    <div class="social-icon">
                        @if (!empty(setting('twitter_link')))
                            <a href="{{setting('twitter_link')}}" target="_blank" class="twit"></a>
                        @endif
                        @if (!empty(setting('facebook_link')))
                            <a href="{{setting('facebook_link')}}" target="_blank" class="fb"></a>
                        @endif
                        @if (!empty(setting('linkedin_link')))
                            <a href="{{setting('linkedin_link')}}" target="_blank" class="linkedin"></a>
                        @endif
                        @if (!empty(setting('google_plus_link')))
                            <a href="{{setting('google_plus_link')}}" target="_blank" class="gplus"></a>
                        @endif
                        @if (!empty(setting('youtube_link')))
                            <a href="{{setting('youtube_link')}}" target="_blank" class="youtube"></a>
                        @endif
                    </div>
                </div>
                 <!-- contact detail end-->
            </div>
        </div>
    </div>
    <!-- map design-->
    {{-- <div id="map" class="wow fadeInUp"></div> --}}
    <div class="wow fadeInUp">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2941.641449930902!2d-83.70032378503457!3d42.49917473429832!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882350de0f11c4d3%3A0x1587d32737fb6076!2sGeneral%20Chemical%20Corp!5e0!3m2!1sen!2sin!4v1581589315307!5m2!1sen!2sin" width="100%" height="350px" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
    </div>
    <!-- map design end-->
    <!-- contact form design start-->
    <div class="formdesign wow zoomIn" >
        <div class="container">
            <div class="text-center">
                <div class="subttl">What they say</div>
                <h2>CONTACT US</h2>
            </div>

            {!! Form::open(['name' => 'contact-form', 'id' => 'contact_form']) !!}
                
                @honeypot

                {!! RecaptchaV3::field('name') !!}

                <div class="row">
                    <div class="col-md-4">
                        <!-- <input type="text" class="form-control" placeholder="Your Name"> -->
                        {!! Form::text('name', null, ['id' => 'name', 'placeholder' => __('messages.enter_name') . ' *', 'required' => 'required', 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'name'])
                    </div>
                    <div class="col-md-4">
                        <!-- <input type="email"  class="form-control"  placeholder="Email"> -->
                        {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email') . ' *', 'required' => 'required', 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'email'])
                    </div>
                    <div class="col-md-4">
                        <!-- <input type="tel"  class="form-control"  placeholder="Telephone"> -->
                        {!! Form::tel('telephone', null, ['id' => 'telephone', 'placeholder' => __('messages.enter_mobile_no') . ' *', 'required' => 'required', 'class' => "form-control " . ($errors->has('telephone') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'telephone'])
                    </div>
                    <div class="col-sm-12">
                        <!-- <textarea placeholder="Comments" class="form-control"></textarea> -->
                        {!! Form::textarea('comments', null, ['id' => 'comments', 'placeholder' => __('messages.description') . ' *', 'required' => 'required', 'class' => "form-control " . ($errors->has('comments') ? 'is-invalid' : '')]) !!}
                        @include('front.error.validation_error', ['field' => 'comments'])
                    </div>
                    <div class="col-sm-12">
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="formfooter text-center">
                    <!-- <input type="submit" value="Send message" class="btn btn-primary"> -->
                    {!! Form::submit('Send message', ['id' => 'submit_contactform', 'class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\ContactFormRequest', '#contact_form') !!}
{{-- <script async defer
 src="https://maps.googleapis.com/maps/api/js?key=api_key&callback=initMap"></script> --}}
{{-- <script>
      function initMap() {
        // Styles a map in night mode.
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 42.4997131, lng: -83.698611},
          zoom: 16,
          styles: [
    {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#e9e9e9"
            },
            {
                "lightness": 17
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f5f5f5"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 17
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 29
            },
            {
                "weight": 0.2
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 18
            }
        ]
    },
    {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f5f5f5"
            },
            {
                "lightness": 21
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#dedede"
            },
            {
                "lightness": 21
            }
        ]
    },
    {
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#ffffff"
            },
            {
                "lightness": 16
            }
        ]
    },
    {
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "saturation": 36
            },
            {
                "color": "#333333"
            },
            {
                "lightness": 40
            }
        ]
    },
    {
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f2f2f2"
            },
            {
                "lightness": 19
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#fefefe"
            },
            {
                "lightness": 20
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#fefefe"
            },
            {
                "lightness": 17
            },
            {
                "weight": 1.2
            }
        ]
    }
]
        });
        var marker = new google.maps.Marker({
    position: new google.maps.LatLng(42.4997131, -83.698611),
    map: map,
    icon: '{{ asset('images/map-marker.png') }}'
  });
      }
    </script> --}}
@endsection