<div class="page-navs bg-white">
    <div class="nav-scroller">
        <div class="nav nav-tabs nav-line nav-color-secondary">
            <a class="nav-link {{ empty($paymentSetting)? 'active show':'' }}" href="{{route('payment_settings')}}">
                {{__('messages.settings')}}
            </a>
            @foreach($paymentSettings as $pSetting)
            @if($pSetting->
            status !== 0 && $pSetting->
            isFree ==0 )
            <a class="nav-link {{ (!empty($paymentSetting) && ($paymentSetting->id==$pSetting->id)) ? 'active show':'' }}" href="{{route('payment_settings.edit',['paymentSetting'=>$pSetting->id])}}">
                {!! $pSetting->title.'&nbsp'.__('messages.settings') !!}
            </a>
            @endif
            @endforeach
        </div>
    </div>
</div>
