@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.clients')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('client.create')}}">
                        {{__('messages.add_client')}}
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
                                            {{__('messages.date')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                    <tr>
                                        <td>{{ $client->id }}</td>
                                        <td>
                                            <div class="row image-gallery">
                                                @if ($client->getMedia('clients')->first())
                                                <a href="{{$client->getMedia('clients')->first() ? $client->getMedia('clients')->first()->getUrl() : asset('images/150x150.png')}}" class="col-10 col-md-12 mb-4">
                                                    <img alt="preview" class="img-fluid" src="{{$client->getMedia('clients')->first() ? $client->getMedia('clients')->first()->getUrl() : asset('images/150x150.png')}}" style="max-width: 60px;">
                                                </a>
                                                @else
                                                    <span class="col-10 col-md-12 mb-4">
                                                        <img alt="preview" class="img-fluid" src="{{$client->getMedia('clients')->first() ? $client->getMedia('clients')->first()->getUrl() : asset('images/150x150.png')}}" style="max-width: 60px;">
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{$client->name}}
                                        </td>
                                        <td>{{ Form::open(['method' => 'PUT', 'route' => ['client.update', 'client' => $client->id]]) }}
                                                    <button class="btn @if($client->active == '0') btn-link btn-danger @elseif($client->active == '1') btn-link @else - @endif btn-primary btn-round btn-deactivate" data-original-title="@if($client->active == 1) Active @else Inactive @endif" data-toggle="tooltip" href="{{route('client.update', ['client' => $client->id])}}">
                                                        @if($client->active == 1) <i class="icon-check"></i> @else <i class="icon-close"></i> @endif
                                                    {{ Form::hidden('changestatus', $client->active) }}
                                                    </button>
                                                {{ Form::close() }}
                                        </td>
                                        <td>
                                            {{ $client->created_at }}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_client')}}" data-toggle="tooltip" href="{{route('client.edit', ['client' => $client->id])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['client.delete', 'client' => $client->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_client')}}" data-toggle="tooltip" href="{{route('client.delete', ['client' => $client->id])}}">
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
<div class="modal fade" id="show-client-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
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
</script>
@endsection
