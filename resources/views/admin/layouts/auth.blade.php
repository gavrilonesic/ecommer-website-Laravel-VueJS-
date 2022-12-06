<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {!! SEOMeta::generate() !!}
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!-- <link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/> -->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
</head>
<body class="login">
    <div class="wrapper wrapper-login wrapper-login-full p-0">
        <div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-color-primary">
            <h1 class="title fw-bold text-white mb-3">{{__('messages.welcome_to_application_name')}}</h1>
            <!-- <p class="subtitle text-white op-7">Ayo bergabung dengan komunitas kami untuk masa depan yang lebih baik</p> -->
        </div>
        @yield('content')
    </div>
    <script src="{{ asset('js/admincommon.js') }}"></script>
    <script src="{{ asset('js/admincustom.js') }}"></script>
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}"></script>
    <!-- Laravel Javascript Validation -->
    @yield('script')
</body>
</html>
