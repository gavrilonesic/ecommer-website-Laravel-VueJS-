@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.videos')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('video.create')}}">
                        {{__('messages.add_video')}}
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
                                            {{__('messages.video')}}
                                        </th>
                                        <th>
                                            {{__('messages.title')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($videos  as $indexKey=>$video)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            <div class="row image-gallery avatar">
                                                @if($video->medias)
                                                    <a href="{{$video->medias->getUrl() }}" class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{$video->medias->getUrl('thumb')}}">
                                                    </a>
                                                @else
                                                    <span class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{asset('images/150x150.png')}}">
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{$video->title}}
                                        </td>
                                        <td>
                                            <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_video')}}" data-toggle="tooltip" href="{{route('video.edit', ['video' => $video->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                            <div class="form-button-action">
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['video.delete', 'video' => $video->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_video')}}" data-toggle="tooltip" href="{{route('video.delete', ['video' => $video->id])}}">
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
@endsection
@section('script')
<script src="{{ asset('js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
    // This will create a single gallery from all elements that have class "gallery-item"
    $('.image-gallery').magnificPopup({
        delegate: 'a',
        type: 'iframe',
    });
</script>
@endsection