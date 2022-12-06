@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.customers')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round" href="{{route('customer.create')}}">
                        {{__('messages.add_customer')}}
                    </a>
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
                                {{__('messages.customers')}}
                            </h4>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $dataTable->table(['class' => 'display table table-head-bg-primary'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="show-customer-detail" tabindex="-1" role="dialog" aria-hidden="true"> </div>
@endsection
@section('script')
{!! $dataTable->scripts() !!}
<script>
    $('body').on('click', 'a.view-customer', function (e) {
        $('#show-customer-detail').load($(this).attr("data-url"), function (result) {
            $('#show-customer-detail').modal({show: true});
        });
    });
</script>
@endsection