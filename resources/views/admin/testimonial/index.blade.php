@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.testimonials')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('testimonial.create')}}">
                        {{__('messages.add_testimonial')}}
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
                                            {{__('messages.title')}}
                                        </th>
                                        <th>
                                            {{__('messages.author_name')}}
                                        </th>
                                        <th>
                                            {{__('messages.status')}}
                                        </th>
                                        <th>
                                            {{__('messages.date')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($testimonials as $indexKey=>$testimonial)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            <div class="row image-gallery avatar">
                                                @if ($testimonial->getMedia('testimonial')->first())
                                                <a href="{{$testimonial->getMedia('testimonial')->first() ? $testimonial->getMedia('testimonial')->first()->getUrl() : asset('images/150x150.png')}}" class="col-6 col-md-3 mb-4">
                                                    <img alt="preview" class="avatar-img img-fluid" src="{{$testimonial->getMedia('testimonial')->first() ? $testimonial->getMedia('testimonial')->first()->getUrl('thumb') : asset('images/150x150.png')}}">
                                                </a>
                                                @else
                                                    <span class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{$testimonial->getMedia('testimonial')->first() ? $testimonial->getMedia('testimonial')->first()->getUrl('thumb') : asset('images/150x150.png')}}">
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{$testimonial->title}}
                                        </td>
                                        <td>
                                            {{$testimonial->author}}
                                        </td>
                                        <td>{{ Form::open(['method' => 'PUT', 'route' => ['testimonial.update', 'testimonial' => $testimonial->id]]) }}
                                                    <button class="btn @if($testimonial->status == '0') btn-link btn-danger @elseif($testimonial->status == '1') btn-link @else - @endif btn-primary btn-round btn-deactivate" data-original-title="@if($testimonial->status == 1) Active @else Inactive @endif" data-toggle="tooltip" href="{{route('testimonial.update', ['testimonial' => $testimonial->id])}}">
                                                        @if($testimonial->status == 1) <i class="icon-check"></i> @else <i class="icon-close"></i> @endif
                                                    {{ Form::hidden('changestatus', $testimonial->status) }}
                                                    </button>
                                                {{ Form::close() }}
                                        </td>
                                        <td>
                                            {{$testimonial->date}}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="#" class="btn btn-link btn-primary btn-lg view-testimonial" data-toggle="modal" data-url="{{route('testimonial.show', ['testimonial' => $testimonial->id])}}">
                                                    <i class="icon-eye"  data-toggle="tooltip" data-placement="top" title="" data-original-title="View Testimonial">
                                                    </i>
                                                </a>
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_testimonial')}}" data-toggle="tooltip" href="{{route('testimonial.edit', ['testimonial' => $testimonial->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['testimonial.delete', 'testimonial' => $testimonial->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_testimonial')}}" data-toggle="tooltip" href="{{route('testimonial.delete', ['testimonial' => $testimonial->id])}}">
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
<div class="modal fade" id="show-testimonial-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
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
    $('body').on('click', 'a.view-testimonial', function (e) {
        $('#show-testimonial-detail').load($(this).attr("data-url"), function (result) {
            $('#show-testimonial-detail').modal({show: true});
        });
    });
</script>
@endsection
