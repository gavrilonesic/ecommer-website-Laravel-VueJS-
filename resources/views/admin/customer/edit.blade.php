@extends('admin.layouts.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            {!! Breadcrumbs::render('EditCustomer') !!}
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($customer, ['name' => 'edit-customer-form', 'method' => 'PUT', 'id' => 'edit-customer-form', 'files' => true]) !!}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.customer_details')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="first_name">
                                        {{__('messages.first_name')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('first_name', null, ['id' => 'first_name', 'placeholder' => __('messages.enter_first_name'), 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'first_name'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="last_name">
                                        {{__('messages.last_name')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('last_name', null, ['id' => 'last_name', 'placeholder' => __('messages.enter_last_name'), 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}

                                        @include('admin.error.validation_error', ['field' => 'last_name'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="email">
                                        {{__('messages.email')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email'), 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'email'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="mobile_no">
                                        {{__('messages.mobile_no')}}
                                    </label>
                                    <span class="required-label">
                                        *
                                    </span>
                                    {!! Form::text('mobile_no', null, ['id' => 'mobile_no', 'placeholder' => __('messages.enter_mobile_no'), 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'mobile_no'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="customer_group_id">
                                        {{__('messages.customer_group')}}
                                    </label>
                                    {!! Form::select('customer_group_id', $customerGroups, null, ['id' => 'customer_group_id', 'class' => 'select2 form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('messages.customer_password')}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="password">
                                        {{__('messages.password')}}
                                    </label>
                                    {!! Form::password('password', ['id' => 'password', 'placeholder' => __('messages.password'), 'class' => "form-control " . ($errors->has('password') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'password'])
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="confirm_password">
                                        {{__('messages.confirm_password')}}
                                    </label>
                                    {!! Form::password('confirm_password', ['id' => 'confirm_password', 'placeholder' => __('messages.confirm_password'), 'class' => "form-control " . ($errors->has('confirm_password') ? 'is-invalid' : '')]) !!}
                                    @include('admin.error.validation_error', ['field' => 'confirm_password'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                {{__('messages.customer_address')}}
                            </h4>
                            <button class="btn btn-primary btn-round ml-auto add-address" type="button" data-toggle="modal" data-target="#add_address_modal">
                                <i class="icon-plus">
                                </i>
                                {{__('messages.add_address')}}
                            </button>
                        </div>
                    </div>
                    <div class="card-body customer-address">

                      <table class="table table-striped">
                        <thead>
                         <tr>
                            <th>{{__('messages.first_name')}}</th>
                            <th>{{__('messages.last_name')}}</th>
                            <th>{{__('messages.customer_address')}}</th>
                            <th>{{__('messages.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>

                             @foreach($customer->userAddress as $customerAdress)
                             <tr>
                             <td>{{$customerAdress->first_name}}</td>
                             <td>{{$customerAdress->last_name}}</td>
                             <td>{!! nl2br($customerAdress->getUserAddress()) !!}</td>
                             <td>
                                <div class="form-button-action">
                                     <a class="btn btn-link btn-primary btn-lg edit_address" data-original-title="{{__('messages.edit_address')}}" data-toggle="tooltip" data-url="{{route('user.address.edit',['address'=>$customerAdress->id])}}">
                                        <i class="icon-note">
                                        </i>
                                    </a>
                                    {{ Form::open(['method' => 'DELETE', 'route' => ['address.delete', 'address' => $customerAdress->id]]) }}
                                        <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_address')}}" data-toggle="tooltip" href="{{route('address.delete', ['address' => $customerAdress->id])}}">
                                        <i aria-hidden="true" class="icon-close">
                                        </i>
                                        </button>
                                    {{ Form::close() }}
                                  </div>
                             </td>
                             </tr>
                             @endforeach

                        </tbody>
                      </table>
                    </div>
                    <div class="card-action">
                        <a class="btn btn-danger" href="{{route('customer.index')}}">
                            {{__('messages.cancel')}}
                        </a>
                        <button class="btn btn-success user-submit">
                            {{__('messages.submit')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_address_modal" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{__('messages.add_address')}}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            @include('admin.customer.add_address')
        </div>
    </div>
</div>
 <div class="modal fade" id="edit_address_modal" tabindex="-1" role="dialog" aria-hidden="true">

</div>

@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\CustomerEditRequest', "#edit-customer-form") !!}
{!! JsValidator::formRequest('App\Http\Requests\AddressRequest', "#add-customer-addressess") !!}
<script type="text/javascript">
    $(".user-submit").click(function() {
        $("#edit-customer-form").submit();
    });
    $(document).ready(function () {
    $('body').on('click', '.edit_address', function (e) {
        $('#edit_address_modal').load($(this).attr("data-url"), function (result) {
            $('#edit_address_modal').modal({show: true});
        });
    });
    $('#state_name').hide();
        $("#country_id").change(function() {
            $state = $("#state_id");

            $state.empty();

            $state.append(new Option("{{__('messages.select_state')}}", ''));
            $.ajax({
                type: 'POST',
                url: "{{ route('get-state') }}",
                dtatType: "json",
                data: {
                    country_id: $("#country_id").val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                   var count = Object.keys(response.state).length;
                    if (count == 0) {
                        $(".state-asterisk").hide();
                        $($state).parent('div').find('input[type="text"]').show();
                        ($state).parent('div').find('input[type="text"]').removeAttr('disabled');
                        $($state).attr('disabled', true);
                        $($state).val('');
                        $($state).parent('div').find('span.select2').hide();
                    } else {
                        $(".state-asterisk").show();
                        $($state).parent('div').find('input[type="text"]').hide();
                         $($state).parent('div').find('input[type="text"]').hide();
                        $($state).parent('div').find('input[type="text"]').attr('disabled', true);
                        $($state).removeAttr('disabled');
                        //$($state).addClass('customer_address_required')
                        //$($state).parent('div').find('input[type="text"]').removeClass('customer_address_required')
                        $('#state_name-error').remove()
                        $($state).parent('div').find('span.select2').show();
                        $.each(response.state, function(text, key) {
                            $state.append(new Option(key.name, key.id));
                        });
                    }
                }
            });
        });
         $('.select2').select2({
            theme: "bootstrap"
        });

        $("body").on("click", ".custom-radio", function() {
            $(".prim_add").val('0');
            $(this).find(".prim_add").val('1');
        });


    });
</script>
@endsection