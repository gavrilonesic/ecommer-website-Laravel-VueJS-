<div class="form-button-action">
    <a class="btn btn-link btn-primary btn-lg view-customer" data-original-title="{{__('messages.edit_customer')}}" data-toggle="modal" data-url="{{route('customer.show', ['customer' => $customer->id])}}" href="#">
        <i class="icon-eye">
        </i>
    </a>
    <a class="btn btn-link btn-primary btn-lg view-customer" data-original-title="{{__('messages.send_reset_password_link_to_user')}}" data-toggle="tooltip" href="{{route('customer.reset_password_link', ['customer' => $customer->id])}}">
        <i class="icon-cursor">
        </i>
    </a>
    <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_customer')}}" data-toggle="tooltip" href="{{route('customer.edit', ['customer' => $customer->id])}}">
        <i class="icon-note">
        </i>
    </a>
</div>
<div class="form-button-action">
    <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.login_as_a_customer')}}" data-toggle="tooltip" href="{{route('customer.loginasuser', ['customer' => $customer->id])}}" target="_blank">
        <i class="icon-login">
        </i>
    </a>
    {{ Form::open(['method' => 'DELETE', 'route' => ['customer.delete', 'customer' => $customer->id]]) }}
    <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_customer')}}" data-toggle="tooltip" href="{{route('customer.delete', ['customer' => $customer->id])}}">
        <i class="icon-close">
        </i>
    </button>
    {{ Form::close() }}
{{-- </div> --}}