@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">{{__('messages.coupon')}}</h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a href="{{route('coupon.create')}}" class="btn btn-white btn-border btn-round">
                        {{__('messages.add_coupon')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                 <!--   <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">{{__('messages.coupons')}}</h4>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                                <table class="display table table-head-bg-primary table-striped datatable-without-image">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('messages.name')}}</th>
                                        <th>{{__('messages.code')}}</th>
                                        <th>{{__('messages.discount')}}</th>
                                        <th>{{__('messages.times_used')}}</th>
                                        <th>{{__('messages.date_start')}}</th>
                                        <th>{{__('messages.date_end')}}</th>
                                        <th>{{__('messages.status')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupons as $indexKey=> $coupon)
                                        <tr>
                                            <td>
                                                {{-- {{$indexKey+1}} --}}
                                            </td>
                                            <td>{{$coupon->name}}</td>
                                            <td>{{$coupon->code}}</td>
                                            <td>@if($coupon->price_type == 'flat_price') ${{$coupon->percent_price}} @else {{$coupon->percent_price}}% @endif </td>
                                            <td>@if(!empty($coupon->userCoupons))
                                            {{ count($coupon->userCoupons) }}  @else - @endif</td>
                                            <td>@if(!empty($coupon->date_start)) {{ date('F j, Y', strtotime($coupon->date_start)) }} @else N/A @endif</td>
                                            <td>@if(!empty($coupon->date_end)) {{ date('F j, Y', strtotime($coupon->date_end)) }} @else N/A @endif</td>
                                            <td>{{ Form::open(['method' => 'PUT', 'route' => ['coupon.update', 'coupon' => $coupon->id]]) }}
                                                    <button class="btn @if($coupon->status == '0') btn-link btn-danger @elseif($coupon->status == '1') btn-link @else - @endif btn-primary btn-round btn-deactivate" data-original-title="@if($coupon->status == 1) Active @else Inactive @endif" data-toggle="tooltip" href="{{route('coupon.update', ['coupon' => $coupon->id])}}">
                                                        @if($coupon->status == 1) <i class="icon-check"></i> @else <i class="icon-close"></i> @endif
                                                    {{ Form::hidden('changestatus', $coupon->status) }}
                                                    </button>
                                                {{ Form::close() }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="#" class="btn btn-link btn-primary btn-lg view-coupon" data-original-title="{{__('messages.edit_coupon')}}" data-toggle="modal" data-url="{{route('coupon.show', ['coupon' => $coupon->id])}}">
                                                        <i class="icon-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Coupon"></i>
                                                    </a>
                                                    <a href="{{route('coupon.edit', ['coupon' => $coupon->id])}}" data-toggle="tooltip" class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_coupon')}}">
                                                        <i class="icon-note"></i>
                                                    </a>
                                                    {{ Form::open(['method' => 'DELETE', 'route' => ['coupon.delete', 'coupon' => $coupon->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_coupon')}}" data-toggle="tooltip" href="{{route('coupon.delete', ['coupon' => $coupon->id])}}">
                                                        <i class="icon-close"></i>
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
<!-- Modal -->
<div class="modal fade" id="show-coupon-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
@endsection
@section('script')
<script>
    $('body').on('click', 'a.view-coupon', function (e) {
        $('#show-coupon-detail').load($(this).attr("data-url"), function (result) {
            $('#show-coupon-detail').modal({show: true});
        });
    });
</script>
@endsection