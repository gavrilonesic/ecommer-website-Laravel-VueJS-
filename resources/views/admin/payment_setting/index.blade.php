@extends('admin.layouts.app')
@section('content')
<div class="content content-full">
    @include('admin.payment_setting.tab')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <section class="card mt-4">
                    <div class="list-group list-group-messages list-group-flush">
                    	@foreach($paymentSettings as $pSetting)
                        <div class="list-group-item read">
                            <div class="list-group-item-body pl-3 pl-md-4">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <h4 class="list-group-item-title">
                                            {{$pSetting->title}}
                                        </h4>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 text-md-right">
                                        <p class="list-group-item-text">
                                            {!! Form::checkbox('status', $pSetting->id, ($pSetting->status !== 0) ? 'checkbox' : '', ['data-toggle' => 'toggle','data-onstyle'=>'success', 'class' => 'data-toggle','data-on'=>__('messages.enabled'),'data-off'=>__('messages.disabled')]) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  $(function() {
    $('.data-toggle').change(function() {
    	var id =$(this).attr('value');
    	var status = ($(this).prop('checked')) ? 1 : 0;
     	$.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'PUT',
            data: {'status': status},
            url: 'payment-settings/'+id,
            success: function (resp) {
                window.location.reload();
            },
            error: function (jqXHR, exception) {
                window.location.reload();
            }
        });
    })
  })
</script>
@endsection
