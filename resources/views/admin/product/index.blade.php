@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">
                        {{__('messages.products')}}
                    </h2>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a class="btn btn-white btn-border btn-round product-import" href="javascript:void(0)" data-url="{{route('file.import', ['importType' => "products"])}}">
                        {{__('messages.import')}}
                    </a>
                    <a class="btn btn-white btn-border btn-round" href="{{route('product.export')}}">
                        {{__('messages.export')}}
                    </a>
                    <a class="btn btn-white btn-border btn-round" href="{{route('product.exportGoogleFeed')}}">
                        Export Google Feed
                    </a>
                    <a class="btn btn-white btn-border btn-round" href="{{route('product.create')}}">
                        {{__('messages.add_product')}}
                    </a>
                    <a class="btn btn-white btn-border btn-round" href="{{route('product.search')}}">
                        {{__('messages.advance_search')}}
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
<script src="{{ asset('js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
    // This will create a single gallery from all elements that have class "gallery-item"
    function imapgePopup(){
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
    }
    $('body').on('click', 'a.product-import', function (e) {
        $('#product-import').load($(this).attr("data-url"), function (result) {
            $('#product-import').modal({show: true});
        });
    });
</script>
@endsection