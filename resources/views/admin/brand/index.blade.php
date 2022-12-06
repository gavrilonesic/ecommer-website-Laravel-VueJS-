@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.brands')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('brand.create')}}">
                        {{__('messages.add_brand')}}
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
                            <table class="display table table-head-bg-primary table-striped datatable-with-image">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            {{__('messages.image')}}
                                        </th>
                                        <th>
                                            {{__('messages.name')}}
                                        </th>
                                        <th>
                                            {{__('messages.page_title')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $indexKey=>$brand)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            <div class="row image-gallery avatar">
                                                @if (!empty($brand->medias))
                                                    <a href="{{$brand->medias->getUrl()}}" class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{$brand->medias->getUrl('thumb')}}">
                                                    </a>
                                                @else
                                                    <span class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{asset('images/150x150.png')}}">
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{$brand->name}}
                                        </td>
                                        <td>
                                            {{$brand->page_title}}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="#" class="btn btn-link btn-primary btn-lg view-brand" data-toggle="modal" data-url="{{route('brand.show', ['brand' => $brand->id])}}">
                                                    <i class="icon-eye"  data-toggle="tooltip" data-placement="top" title="View Brand Detail">
                                                    </i>
                                                </a>
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_brand')}}" data-toggle="tooltip" href="{{route('brand.edit', ['brand' => $brand->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['brand.delete', 'brand' => $brand->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_brand')}}" data-toggle="tooltip" href="{{route('brand.delete', ['brand' => $brand->id])}}">
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
<div class="modal fade" id="show-brand-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
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
            enabled:false,
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
    $('body').on('click', 'a.view-brand', function (e) {
        $('#show-brand-detail').load($(this).attr("data-url"), function (result) {
            $('#show-brand-detail').modal({show: true});
        });
    });
</script>
@endsection