@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.attributes')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('attribute.create')}}">
                        {{__('messages.add_attribute')}}
                    </a>
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
                                            {{__('messages.name')}}
                                        </th>
                                        <th>
                                            {{__('messages.attribute_type')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attributes as $indexKey=>$attribute)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            {{$attribute->name}}
                                        </td>
                                        <td>
                                            {{config('constants.ATTRIBUTE_TYPE')[$attribute->attribute_type]}}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="#" class="btn btn-link btn-primary btn-lg view-attribute" data-original-title="{{__('messages.view_attribute')}}" data-toggle="modal" data-url="{{route('attribute.show', ['attribute' => $attribute->id])}}">
                                                    <i class="icon-eye"   data-toggle="tooltip" data-placement="top" title="{{__('messages.view_attribute')}}">
                                                    </i>
                                                </a>
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_attribute')}}" data-toggle="tooltip" href="{{route('attribute.edit', ['attribute' => $attribute->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['attribute.delete', 'attribute' => $attribute->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_attribute')}}" data-toggle="tooltip" href="{{route('attribute.delete', ['attribute' => $attribute->id])}}">
                                                        <i class="icon-close"   data-toggle="tooltip" data-placement="top" title="{{__('messages.delete_attribute')}}"></i>
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
<div class="modal fade" id="show-attribute-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
@endsection
@section('script')
<script src="{{ asset('js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
    // This will create a single gallery from all elements that have class "gallery-item"
    $('body').on('click', 'a.view-attribute', function (e) {
        $('#show-attribute-detail').load($(this).attr("data-url"), function (result) {
            $('#show-attribute-detail').modal({show: true});
        });
    });
</script>
@endsection