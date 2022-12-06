@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.emails')}}
                    </h2>
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
                                {{__('messages.emails')}}
                            </h4>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-head-bg-primary table-striped datatable-without-image">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            {{__('messages.id')}}
                                        </th>
                                        <th>
                                            {{__('messages.description')}}
                                        </th>
                                        <th>
                                            {{__('messages.to')}}
                                        </th>
                                        <th>
                                            {{__('messages.subject')}}
                                        </th>
                                        <th>
                                            {{__('messages.body')}}
                                        </th>
                                        <th>
                                            {{__('messages.action')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($emails as $indexKey=>$email)
                                    <tr>
                                        <td>
                                            {{-- {{$indexKey+1}} --}}
                                        </td>
                                        <td>
                                            {{$indexKey}}
                                        </td>
                                        <td>
                                            {{$email['desc']}}
                                        </td>
                                        <td>
                                            {{$email['to']}}
                                        </td>
                                        <td>
                                            {{$email['subject']}}
                                        </td>
                                        <td>
                                            {{$email['body']}}
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_email')}}" data-toggle="tooltip" href="{{route('email.edit', ['email' => $indexKey])}}">
                                                    <i class="icon-note">
                                                    </i>
                                                </a>
                                                 {{ Form::open(['method' => 'get', 'route' => ['email.send_test', 'email' => $indexKey]]) }}
                                                 <button class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.send_test_email')}}" data-toggle="tooltip" href="{{route('email.delete', ['email' => $indexKey])}}">
                                                        <i class="icon-cursor"></i>
                                                    </button>
                                                {{ Form::close() }}
                                                @if($email['fromDB'])
                                                {{ Form::open(['method' => 'DELETE', 'route' => ['email.delete', 'email' => $indexKey]]) }}
                                                    <button class="btn btn-link btn-danger btn-restore" data-original-title="{{__('messages.restore_default')}}" data-toggle="tooltip" href="{{route('email.delete', ['email' => $indexKey])}}">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                {{ Form::close() }}
                                                @endif
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
