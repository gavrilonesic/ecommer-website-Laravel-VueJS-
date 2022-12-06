@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.categories')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <!-- <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a> -->

                    <a class="btn btn-white btn-border btn-round category-popup" href="javascript:void(0)" data-url="{{route('file.import', ['importType' => "categories"])}}">
                        {{__('messages.import')}}
                    </a>
                    <a class="btn btn-white btn-border btn-round" href="{{route('categories.export')}}">
                        {{__('messages.export')}}
                    </a>
                    <a class="btn btn-white btn-border btn-round" href="{{route('category.create')}}">
                        {{__('messages.add_category')}}
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
                            <h4 class="card-title">
                                {{__('messages.categories')}}
                            </h4>
                        </div>
                    </div> -->
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
                                            {{__('messages.categories')}}
                                        </th>
                                        <th>
                                            {{__('messages.parent')}}
                                        </th>
                                        <th>
                                            {{__('messages.products')}}
                                        </th>
                                        <th>
                                            {{__('messages.inquiries')}}
                                        </th>
                                        <th>
                                            {{__('messages.visible_in_menu')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $indexKey => $category)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey + 1}} --}}
                                        </td>
                                        <td>
                                            <div class="row image-gallery avatar">
                                                @if($category->medias)
                                                    <a href="{{$category->medias->getUrl() }}" class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{$category->medias->getUrl('thumb')}}">
                                                    </a>
                                                @else
                                                    <span class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{asset('images/150x150.png')}}">
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{$category->name}}
                                        </td>
                                        <td>
                                            {{$category->parent->name ?? '-'}}
                                        </td>
                                        <td>
                                            <a href="{{route('product.search',['category_id' => $category->id])}}" target="_blank">{{$category->productsCount[0]->aggregate ?? '0'}}</a>
                                        </td>
                                        <td>
                                            <a href="{{route('inquiry.search',['category_id' => $category->id])}}" target="_blank">{{$category->inquiry_count ?? '0'}}</a>
                                        </td>
                                        <td>
                                            {{ Form::open(['method' => 'GET', 'route' => ['category.status', 'category' => $category->id]]) }}
                                            @if($category->status == config('constants.STATUS.STATUS_ACTIVE'))
                                            <a class="btn btn-link btn-primary btn-lg ispublish" data-toggle="tooltip" href="{{route('category.status', ['category' => $category->id])}}">
                                                <i aria-hidden="true" class="icon-check">
                                                </i>
                                            </a>
                                            @else
                                            <a class="btn btn-link btn-danger btn-lg ispublish" data-toggle="tooltip" href="{{route('category.status', ['category' => $category->id])}}">
                                                <i aria-hidden="true" class="icon-close">
                                                </i>
                                            </a>
                                            @endif
                                            {{ Form::close() }}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="#" class="btn btn-link btn-primary btn-lg category-popup" data-original-title="{{__('messages.view_category')}}" data-toggle="modal" data-url="{{route('category.show', ['category' => $category->id])}}">
                                                    <i class="icon-eye"  data-toggle="tooltip" data-placement="top" title="View Category Detail">
                                                    </i>
                                                </a>
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_category')}}" data-toggle="tooltip" href="{{route('category.edit', ['category' => $category->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['category.delete', 'category' => $category->id]]) }}
                                                    <a class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_category')}}" data-toggle="tooltip" href="#">
                                                        <i class="icon-close"></i>
                                                    </a>
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
<div class="modal fade" id="show-category-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
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
    $('body').on('click', 'a.category-popup', function (e) {
        $('#show-category-detail').load($(this).attr("data-url"), function (result) {
            $('#show-category-detail').modal({show: true});
        });
    });
</script>
@endsection