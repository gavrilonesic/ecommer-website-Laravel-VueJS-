@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__("messages.$page")}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {!! Form::open() !!}
        <div class="page-inner mt--5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                     <!--  <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">
                                    {{__("messages.$page")}}
                                </h4>
                            </div>
                        </div> -->
                        <div class="card-body">
                            <div class="row">
                                @if(count(config("setting_fields.$page.elements", [])))
                                    @foreach(config("setting_fields.$page.elements") as $field)
                                        @if(!empty($field['classClear']))
                                            </div>  </div>  </div>  </div>
                                            <div class="col-md-12">
                    <div class="card">   <div class="card-body">
                            <div class="row">
                                        @endif
                                        <div class="col-md-6 col-lg-6">
                                            @include('admin.setting.' . $field['type'] )
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @if(count(config("setting_fields.$page.elements", [])))
                            <div class="card-action">
                                <a href="{{route('admin.dashboard')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                                <button class="btn btn-success">{{__('messages.submit')}}</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div> </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection