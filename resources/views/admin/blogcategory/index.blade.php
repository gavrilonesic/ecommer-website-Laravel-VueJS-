@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.blogcategory')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('blogcategory.create')}}">
                        {{__('messages.add_blog_category')}}
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
                                            {{__('messages.status')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogcategory as $indexKey=>$blogcategory)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            <div class="row image-gallery avatar">
                                                <a href="{{$blogcategory->getMedia('blogcategory')->first() ? $blogcategory->getMedia('blogcategory')->first()->getUrl() : asset('images/150x150.png')}}" class="col-6 col-md-3 mb-4">
                                                    <img alt="preview" class="avatar-img img-fluid" src="{{$blogcategory->getMedia('blogcategory')->first() ? $blogcategory->getMedia('blogcategory')->first()->getUrl('thumb') : asset('images/150x150.png')}}">
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            {{$blogcategory->name}}
                                        </td>
                                        <td>{{ Form::open(['method' => 'PUT', 'route' => ['blogcategory.update', 'blogcategory' => $blogcategory->id]]) }}
                                                    <button class="btn @if($blogcategory->status == '0') btn-link btn-danger @elseif($blogcategory->status == '1') btn-link @else - @endif btn-primary btn-round btn-deactivate" data-original-title="@if($blogcategory->status == 1) Active @else Inactive @endif" data-toggle="tooltip" href="{{route('blogcategory.update', ['blogcategory' => $blogcategory->id])}}">
                                                        @if($blogcategory->status == 1) <i class="icon-check"></i> @else <i class="icon-close"></i> @endif
                                                    {{ Form::hidden('changestatus', $blogcategory->status) }}
                                                    </button>
                                                {{ Form::close() }}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="#" class="btn btn-link btn-primary btn-lg view-blogcategory" data-original-title="{{__('messages.edit_blogcategory')}}" data-toggle="modal" data-url="{{route('blogcategory.show', ['blogcategory' => $blogcategory->id])}}">
                                                    <i class="icon-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Blog Category">
                                                    </i>
                                                </a>
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_blogcategory')}}" data-toggle="tooltip" href="{{route('blogcategory.edit', ['blogcategory' => $blogcategory->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['blogcategory.delete', 'blogcategory' => $blogcategory->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_blogcategory')}}" data-toggle="tooltip" href="{{route('blogcategory.delete', ['blogcategory' => $blogcategory->id])}}">
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
<div class="modal fade" id="show-blogcategory-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
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
    $('body').on('click', 'a.view-blogcategory', function (e) {
        $('#show-blogcategory-detail').load($(this).attr("data-url"), function (result) {
            $('#show-blogcategory-detail').modal({show: true});
        });
    });
</script>
@endsection