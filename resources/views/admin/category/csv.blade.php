@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('ImportCategory') !!}
        </div>
        {!! Form::open() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{__('messages.import_categories')}}</h4>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.category_update')}} {{$updateRecordCount}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="name">{{__('messages.new_category_insert')}} {{$newRecordCount}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a class="btn btn-danger btn-link fw-bold" href="{{route('category.index')}}">
                                {{__('messages.cancel')}}
                            </a>
                            <button class="btn btn-success">
                                {{__('messages.execute')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
