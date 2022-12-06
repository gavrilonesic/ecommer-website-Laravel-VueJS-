@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.cms_pages')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('cms_page.create')}}">
                        {{__('messages.add_cms_page')}}
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
                                {{__('messages.cms_pages')}}
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
                                            {{__('messages.title')}}
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
                                    @foreach($cmsPages as $indexKey => $cmsPage)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            <div class="row image-gallery avatar">
                                                <a href="{{$cmsPage->getMedia('cms_page')->first() ? $cmsPage->getMedia('cms_page')->first()->getUrl() : asset('images/150x150.png')}}" class="col-6 col-md-3 mb-4">
                                                    <img alt="preview" class="avatar-img img-fluid" src="{{$cmsPage->getMedia('cms_page')->first() ? $cmsPage->getMedia('cms_page')->first()->getUrl('thumb') : asset('images/150x150.png')}}">
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            {{$cmsPage->title}}
                                        </td>
                                        <td>
                                            {{$cmsPage->page_title}}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="#" class="btn btn-link btn-primary btn-lg view-cms-page" data-toggle="modal" data-url="{{route('cms_page.show', ['cmsPage' => $cmsPage->id])}}">
                                                    <i class="icon-eye"  data-toggle="tooltip" data-placement="top" title="" data-original-title="View CMS Page">
                                                    </i>
                                                </a>
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_cms_page')}}" data-toggle="tooltip" href="{{route('cms_page.edit', ['cmsPage' => $cmsPage->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['cms_page.delete', 'cmsPage' => $cmsPage->id]]) }}
                                                    <a class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_cms_page')}}" data-toggle="tooltip" href="#">
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
<!-- Modal -->
<div class="modal fade" id="show-cms-page-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
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
    $('body').on('click', 'a.view-cms-page', function (e) {
        $('#show-cms-page-detail').load($(this).attr("data-url"), function (result) {
            $('#show-cms-page-detail').modal({show: true});
        });
    });
</script>
@endsection