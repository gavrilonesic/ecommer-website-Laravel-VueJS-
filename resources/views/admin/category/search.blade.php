@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
         {!! Form::open(['name' => 'search', 'id' => 'search-product-form','method' => 'get']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.advance_search')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label for="category_id">
                                         {{__('messages.category')}}
                                    </label>
                                    {!! Form::select('category_id', $categories,  request()->get('category_id'), ['id' => 'category_id', 'placeholder' => __('messages.select_category'), 'class' => 'select2 form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <a class="btn btn-danger fw-bold" href="{{route('product.search')}}">
                            {{__('messages.reset')}}
                        </a>
                        <button class="btn btn-success">
                             {{__('messages.search')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
         {!! Form::close() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $dataTable->table(['class' => 'display table table-head-bg-primary table-striped'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="product-import" tabindex="-1" role="dialog" aria-hidden="true"> </div>
@endsection
@section('script')
{!! $dataTable->scripts() !!}
<script type="text/javascript" src="{!! asset('js/plugin/select2/select2.full.min.js') !!}"></script>
@endsection