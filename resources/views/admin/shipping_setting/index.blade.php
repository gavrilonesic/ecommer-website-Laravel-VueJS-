@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.shipping_settings')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    @foreach ($shippingZones as $key => $shippingZone)
                        @if ($key == 2 && $restOfTheWorld->count() > 0)
                            @continue;
                        @endif
                        <a class="btn btn-white btn-border btn-round shipping-zone" href="javascript:void(0)" data-url="{{route('shipping_settings.add', ['shippingZone' => $key])}}">
                            {{__('messages.' . $shippingZone['title'])}}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-head-bg-primary table-striped datatable-without-image">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            {{__('messages.shipping_zone')}}
                                        </th>
                                        <th>
                                            {{__('messages.freight_name')}}
                                        </th>
                                        <th>
                                            {{__('messages.shipping_quotes')}}
                                        </th>
                                        <th>
                                            {{__('messages.status')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shippingSettings as $indexKey=>$shippingSetting)
                                        <tr>
                                            <td>
                                                {{-- {{$indexKey+1}} --}}
                                            </td>
                                            <td>
                                                {{$shippingSetting->title}}
                                                @if(!empty($shippingSetting->country_id) && !empty($shippingSetting->country_name))
                                                {{ ' - '.ucwords($shippingSetting->country_name) }}
                                                @elseif(!empty($shippingSetting->state_id) && !empty($shippingSetting->state_name))
                                                {{ ' - '.ucwords($shippingSetting->state_name) }}
                                                @endif
                                            </td>
                                            <td>
                                                @foreach(config('constants.SHIPPING_QUOTES') as $key => $shippingQuote)
                                                    @if($shippingQuote['view'] == 'truck_freight_shipping' && isset($shippingSetting->value->$key->freight_name))
                                                    {{ __('messages.' . $shippingQuote['view']).' : '.ucwords($shippingSetting->value->$key->freight_name) }}
                                                    <br/>
                                                    @endif

                                                    @if($shippingQuote['view'] == 'pickup_in_store' && isset($shippingSetting->value->$key->store_address))
                                                    {{ __('messages.' . $shippingQuote['view']).' :' .ucwords($shippingSetting->value->$key->store_address) }}
                                                    <br/>
                                                    @endif
                                                @endforeach

                                            </td>
                                            <td>
                                                @foreach(config('constants.SHIPPING_QUOTES') as $key => $shippingQuote)
                                                    @if (isset($shippingSetting->value->$key) && $shippingSetting->value->$key->is_enabled == 1)
                                                        {{__('messages.' . $shippingQuote['view'])}}
                                                        <br/>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ Form::open(['method' => 'GET', 'route' => ['shipping_settings.status', 'shippingSetting' => $shippingSetting->id]]) }}
                                                @if($shippingSetting->status == config('constants.STATUS.STATUS_ACTIVE'))
                                                    <a class="btn btn-link btn-primary btn-lg ispublish" data-toggle="tooltip" href="{{route('shipping_settings.status', ['shippingSetting' => $shippingSetting->id])}}">
                                                    <i aria-hidden="true" class="icon-check">
                                                        </i>
                                                    </a>
                                                @else
                                                    <a class="btn btn-link btn-danger btn-lg ispublish" data-toggle="tooltip" href="{{route('shipping_settings.status', ['shippingSetting' => $shippingSetting->id])}}">
                                                        <i aria-hidden="true" class="icon-close">
                                                        </i>
                                                    </a>
                                                @endif
                                                {{ Form::close() }}
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_shipping_zone')}}" data-toggle="tooltip" href="{{route('shipping_settings.edit', ['shippingSetting' => $shippingSetting->id])}}">
                                                        <i class="icon-note">
                                                        </i>
                                                    </a>
                                                    {{ Form::open(['method' => 'DELETE', 'route' => ['shipping_settings.delete', 'shippingSetting' => $shippingSetting->id]]) }}
                                                        <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_shipping_zone')}}" data-toggle="tooltip" href="{{route('shipping_settings.delete', ['shippingSetting' => $shippingSetting->id])}}">
                                                        <i aria-hidden="true" class="icon-close">
                                                        </i>
                                                        </button>
                                                    {{ Form::close() }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="shipping-zone" tabindex="-1" role="dialog" aria-hidden="true"> </div>
@endsection
@section('script')
<script src="{{ asset('js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
    $('body').on('click', 'a.shipping-zone', function (e) {
        $('#shipping-zone').load($(this).attr("data-url"), function (result) {
            $('#shipping-zone').modal({show: true});
        });
    });
</script>
@endsection