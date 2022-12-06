@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.admin_users')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('user.create')}}">
                        {{__('messages.add_admin_user')}}
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
                                            {{__('messages.email')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $indexKey=>$user)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            <div class="row image-gallery avatar">
                                                @if (!empty($user->medias))
                                                    <a href="{{$user->medias->getUrl()}}" class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{$user->medias->getUrl('thumb')}}">
                                                    </a>
                                                @else
                                                    <span class="col-6 col-md-3 mb-4">
                                                        <img alt="preview" class="avatar-img img-fluid" src="{{asset('images/150x150.png')}}">
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{$user->name}}
                                        </td>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_admin_user')}}" data-toggle="tooltip" href="{{route('user.edit', ['user' => $user->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['user.delete', 'user' => $user->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_admin_user')}}" data-toggle="tooltip" href="{{route('user.delete', ['user' => $user->id])}}">
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
<div class="modal fade" id="show-user-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
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
    $('body').on('click', 'a.view-user', function (e) {
        $('#show-user-detail').load($(this).attr("data-url"), function (result) {
            $('#show-user-detail').modal({show: true});
        });
    });
</script>
@endsection