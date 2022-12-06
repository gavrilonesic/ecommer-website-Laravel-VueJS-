@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.order_status')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round order-status" href="javascript:void(0)" data-url="{{route('order_status.create')}}">
                        {{__('messages.add_order_status')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <!--  <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                {{__('messages.order_status')}}
                            </h4>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-head-bg-primary table-striped datatable-without-image">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            {{__('messages.name')}}
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
                                    @foreach($orderStatus as $indexKey=>$status)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            {{$status->name}}
                                        </td>
                                        <td>
                                            {{config('constants.STATUS_LIST')[$status->status] ?? '-'}}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="javascript:void(0)" class="btn btn-link btn-primary btn-lg order-status" data-original-title="{{__('messages.view_order_status')}}" data-toggle="tooltip" data-url="{{route('order_status.show', ['orderStatus' => $status->id])}}">
                                                    <i class="fa fa-eye">
                                                    </i>
                                                </a>
                                                <a class="btn btn-link btn-primary btn-lg order-status" data-original-title="{{__('messages.edit_order_status')}}" data-toggle="tooltip" href="javascript:void(0)" data-url="{{route('order_status.edit', ['orderStatus' => $status->id])}}">
                                                    <i class="fa fa-edit">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['order_status.delete', 'orderStatus' => $status->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_order_status')}}" data-toggle="tooltip" href="{{route('order_status.delete', ['orderStatus' => $status->id])}}">
                                                        <i class="fa fa-times"></i>
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
<div class="modal fade" id="show-order-status-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
@endsection
@section('script')
<script src="{{ asset('js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
    // This will create a single gallery from all elements that have class "gallery-item"
    $('.image-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        removalDelay: 300,
        gallery:{
            enabled:true,
        },
        mainClass: 'mfp-with-zoom',
        zoom: {
            enabled: true,
            duration: 300,
            easing: 'ease-in-out',
            opener: function(openerElement) {
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
    $('body').on('click', 'a.order-status', function (e) {
        $('#show-order-status-detail').load($(this).attr("data-url"), function (result) {
            $('#show-order-status-detail').modal({show: true});
        });
    });
</script>
@endsection