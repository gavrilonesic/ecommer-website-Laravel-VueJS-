@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('EditEmail') !!}
        </div>
        {!! Form::model($email, ['name' => 'edit-email-form', 'method' => 'PUT', 'id' => 'edit-email-form']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.basic_information')}}
                        </h4>
                    </div>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject">
                                        {{__('messages.subject')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('subject',null, ['id' => 'name', 'placeholder' => __('messages.subject'), 'class' => "form-control " . ($errors->has('name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'subject'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="variables">
                                        {{__('messages.variables')}}
                                    </label>
                                    <br/>
                                    @foreach($email['variables'] as $v)
                                        [{{$v}}]
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    {!! $email['header'] !!}
                                    {!! Form::textarea('content', null, ['id' => 'content']) !!}
                                    {!! $email['footer'] !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="{{route('email.index')}}" class="btn btn-danger">{{__('messages.cancel')}}</a>
                        <button class="btn btn-success">{{__('messages.submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/plugin/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
    $('#content').summernote({
        placeholder: "{{__('messages.description')}}",
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
        // tabsize: 2,
        // height: 300
    });
</script>
@endsection
