@extends('admin.layouts.app')
    
@section('content')
<div class="content">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$shippingSetting->title}}</h4>
                        <br/>
                        <h5 class="pb-2 fw-bold">
                            {{__('messages.shipping_quotes')}}
                        </h5>
                    </div>
                    @csrf
                    <div class="card-body">
                        @foreach($shippingQuotes as $key => $shippingQuote)
                            <div class="row">
                                <div class="col-md-9 col-lg-9">
                                    <div class="form-group">
                                        {{__('messages.' . $shippingQuote['view'])}}
                                    </div>
                                </div>
                                <div class="col-md-1 col-lg-1">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            {!! Form::checkbox("shipping_settings[$key]", $key, (isset($shippingSetting->value->$key) && $shippingSetting->value->$key->is_enabled == 1) ? true : false, ['class' => 'custom-control-input', 'id' => 'shipping-settings-' . $key, 'data-value' => $shippingQuote['is_free'] ?? 0]) !!}
                                            <label class="custom-control-label" for="{{'shipping-settings-' . $key}}">
                                                
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    @if (isset($shippingSetting->value->$key) && $shippingSetting->value->$key->is_enabled == 1 &&  (!isset($shippingQuote['is_free']) || $shippingQuote['is_free'] != 1))
                                        <a class="btn btn-link btn-primary btn-lg" onclick="editShippingSetting('{{$key}}')" href="javascript:void(0)">
                                            {{__('messages.edit')}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-action">
                        <a class="btn btn-success" href="{{ route('shipping_settings') }}">
                            {{__('messages.done')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="shipping-zone" tabindex="-1" role="dialog" aria-hidden="true"> </div>
@endsection

@section('script')
<script type="text/javascript">
    var shippingQuote = {};
    $(".custom-control-input").change(function () {
        shippingQuote.id = $(this).val();
        if ($(this).is(":checked") == true) {
            if ($(this).data('value') == 1){
                shippingQuote.shipping_charge = {'is_enabled' : 1};
                updateShippingSetting(shippingQuote);
            } else {
                editShippingSetting($(this).val())
            }
        } else {
            shippingQuote.shipping_charge  = {'is_enabled' : 0};
            updateShippingSetting(shippingQuote);
        }
    });

    function editShippingSetting(id)
    {
        var url = "{{ route('shipping_settings.edit_shipping_setting', ['shippingSetting' => $shippingSetting->id]) }}/?id=" +id;
        $('#shipping-zone').load(url, function (result) {
            $('#shipping-zone').modal({show: true});
        });
    }

    function updateShippingSetting(data)
    {
        $.ajax({
            type: 'POST',
            url: "{{ route('shipping_settings.update', ['shippingSetting' => $shippingSetting->id]) }}",
            data: data,
            dtatType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                location.reload();
            }
        });
    }
    $("body").on('click', '.submit-shipping', function(e) {
        formId = $(this).closest('form').attr('id');
        //console.log(formId);
        if ($("#" + formId).valid()) {
            var form = $("#" + formId);
            updateShippingSetting(form.serialize());
            return false;
        }
    });
    /*
    function submitShipping($this) {
        formId = $this.closest('form').attr('id');
        console.log(formId);
        console.log($("#" + formId).valid());
        //console.log(formId);
        if ($("#" + formId).valid()) {
            var form = $("#" + formId);
            updateShippingSetting(form.serialize());
            return false;
        }
    }*/
    $('#shipping-zone').on('hidden.bs.modal', function () {
        if (shippingQuote.id) {
            $("input[name='shipping_settings[" + shippingQuote.id + "]']").prop('checked', false);
            shippingQuote = {};
        }
    });
</script>
@endsection
            