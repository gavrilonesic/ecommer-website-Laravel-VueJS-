<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <!-- CSRF Token -->
        <meta content="{{ csrf_token() }}" name="csrf-token"/>
        {!! SEO::generate(true) !!}

        <script src="{{ asset('js/app.js') }}"></script>
        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.css') }}?v=2.0.1" rel="stylesheet"/>
        <link href="{{ asset('css/front.css') }}?v=2.0.1" rel="stylesheet"/>
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.ico') }}"/>
        <meta name="google-site-verification" content="oNn2SzDONH1uWysIoisNMVEajOQiU_UjOVWS1_Xb_ZU" />

        @yield('css')
        @if(!empty( setting('webmaster_google_analytics')))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{setting('webmaster_google_analytics')}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            
            gtag('config', "{{setting('webmaster_google_analytics')}}");
            </script>
        @endif
        
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-58BS5BZ');</script>
        <!-- End Google Tag Manager -->
        @yield('upper_script')

        {!! RecaptchaV3::initJs() !!}
        <style>
            /*.grecaptcha-badge { visibility: hidden !important; }*/
        </style>

    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src=“https://www.googletagmanager.com/ns.html?id=GTM-58BS5BZ”
            height="0" width=“0” style=“display:none;visibility:hidden”></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <!--loader-->
        <div  class="loader" id="loading">
        </div>
        @include('front.includes.header')
        @yield('content')
        @include('front.includes.footer')
        <!-- Fonts -->
        <script type="text/javascript">
            maximumQuantity = {{config('constants.MAXIMUM_QUANTITY_PER_PRODUCT')}}
        </script>
        <script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
        <script src="{{ asset('js/frontcommon.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/frontcustom.js') }}?v=1.2"></script>
        <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}"></script>
        <!-- Error / Success message starts-->
        @if (Session::has('success'))
        <script>
            flashMessage('success', "{{Session::get('success')}}");
        </script>
        @endif
        @if (Session::has('error'))
        <script>
            flashMessage('error', "{{Session::get('error')}}");
        </script>
        @endif
        <!-- Error / Success message ends-->
        @yield('script')
        {!! JsValidator::formRequest('App\Http\Requests\NewsletterRequest', '#newsletter') !!}
        <div class="modal quickdetail-popup" id="product-quick-view-popup">
        </div>
    </body>
</html>
