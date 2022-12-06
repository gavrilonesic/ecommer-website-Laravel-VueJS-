<h4 class="page-title">{{__($breadcrumbs->last()->title)}}</h4>
<ul class="breadcrumbs">
    <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
            <i class="icon-home"></i>
        </a>
    </li>
    @if (count($breadcrumbs))
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                @if ($breadcrumb->url && !$loop->last)
                    <a href="{{$breadcrumb->url}}">{{ __($breadcrumb->title) }}</a>
                @else
                    {{ __($breadcrumb->title) }}
                @endif
            </li>
        @endforeach
    @endif
</ul>