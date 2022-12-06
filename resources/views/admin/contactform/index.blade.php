@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.contact_form_entries')}}
                    </h2>
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
                                            {{__('messages.name')}}
                                        </th>
                                        <th>
                                            {{__('messages.email')}}
                                        </th>
                                        <th>
                                            {{__('messages.mobile_no')}}
                                        </th>
                                        <th>
                                            {{__('messages.description')}}
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
                                    @foreach($contactlist as $indexKey=>$contactdata)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            {{$contactdata->name}}
                                        </td>
                                        <td>
                                            {{$contactdata->email}}
                                        </td>
                                        <td>
                                            @if(!empty($contactdata->telephone)) {{$contactdata->telephone}} @else - @endif
                                        </td>
                                        <td>
                                            @if(!empty($contactdata->comments)) {{$contactdata->comments}} @else - @endif
                                        </td>
                                        <td>{{ Form::open(['method' => 'PUT', 'route' => ['contactform.update', 'contactform' => $contactdata->id]]) }}
                                        <button class="btn @if($contactdata->status == '0') btn-link btn-danger @elseif($contactdata->status == '1') btn-link btn-primary @else - @endif btn-round ispublish" data-original-title="@if($contactdata->status == '0') Pending
                                           @elseif($contactdata->status == '1') Completed
                                           @else - @endif" data-toggle="tooltip" href="{{route('contactform.update', ['contactform' => $contactdata->id])}}">
                                           @if($contactdata->status == '0') <i class="icon-close"></i>
                                           @elseif($contactdata->status == '1') <i class="icon-check"></i>
                                           @else - @endif
                                           {{ Form::hidden('changestatus', $contactdata->status) }}</button>
                                           {{ Form::close() }}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['contactform.delete', 'contactform' => $contactdata->id]]) }}
                                                    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_entry')}}" data-toggle="tooltip" href="{{route('contactform.delete', ['contactform' => $contactdata->id])}}">
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