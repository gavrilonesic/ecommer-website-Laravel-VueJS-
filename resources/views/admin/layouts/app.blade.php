<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('admin.includes.head')
    </head>
{{--     <style type="text/css">
        /* Remove default bullets */
    ul {
      list-style-type: none;
      padding:0;
      margin:0
    }
    li > i.collapsed:before {
        font-style: normal;
        content: "\e095";
    }
    li > i:before {
        font-family: "simple-line-icons";
        font-style: normal;
        content: "\e615";
    }
    </style> --}}
    <body>
        <div class="wrapper">
            @include('admin.includes.header')
            @include('admin.includes.sidebar')
            <div class="main-panel">
                @yield('content')
                @include('admin.includes.footer')
            </div>
        </div>
        <script src="{{ asset('js/admincommon.js') }}">
        </script>
        <script src="{{ asset('js/admincustom.js') }}">
        </script>
        <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}"></script>
        @yield('script')
        <script>
            @foreach (['error', 'warning', 'success', 'info'] as $message)
                @if(Session::has($message))
                    flashMessage("{{ $message }}","{{ Session::get($message) }}");
                @endif
            @endforeach
        </script>
    </body>
</html>
