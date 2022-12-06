<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
{!! SEOMeta::generate() !!}
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex, nofollow">
<!-- favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.ico') }}">
 <!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- Fonts -->
<script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
<script>
	WebFont.load({
		google: {"families":["Lato:300,400,700,900"]},
		custom: {"families":["simple-line-icons"], urls: ["{{asset('css/simplelineicons.css')}}"]},
		active: function() {
			sessionStorage.fonts = true;
		}
	});
</script>

<!-- CSS Files -->
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
<link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
@yield('css')
<!-- Global stylesheets -->
