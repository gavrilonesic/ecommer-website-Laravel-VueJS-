@extends('front.layouts.app')
@section('content')
<section>
    <!-- checkout form design start-->
    <div class="formdesign wow zoomIn">
        <div class="container checkoutpage">
            <div class="text-center">
                <h2>
                    {{__('messages.checkout')}}
                </h2>
            </div>
            @php
                $i = $j = 1;
            @endphp
            {{-- <form> --}}
                <div class="row">
                    <div class="col-md-7 col-lg-8">
                        <!-- accordian-->
                        <div class="panel-group stepsbox" id="accordion">
                            <!--first-step-->
                            @if (!Auth::guard('web')->check())
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>
                                            <span>
                                                {{$i++}}
                                            </span>
                                            {{__('messages.login')}}
                                        </h4>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$j}}" class="{{Auth::guard('web')->check() ? 'disabled' : '' }} accordion-collapse collapse-{{$j}}" data-id="{{$j}}">
                                                <i class="{{Auth::guard('web')->check() ? 'icon-plus' : 'icon-minus' }}"></i>
                                            </a>

                                    </div>
                                    <div id="collapse-{{$j}}" class="panel-collapse collapse {{!Auth::guard('web')->check() ? 'show' : '' }}">
                                        <div class="panel-body">
                                            <div class="row second-step">
                                                <div class="col-md-12 col-lg-6">
                                                    <h5>
                                                        {{__('messages.new_customer')}}
                                                    </h5>
                                                    <div class="radioboxrow">
                                                        <span>
                                                            <input type="radio" value="register" name="login_type" class="login-type" id="raccount"/>
                                                            <label for="raccount">
                                                                {{__('messages.register_account')}}
                                                            </label>
                                                        </span>
                                                        <span>
                                                            <input type="radio" value="guest" name="login_type" class="login-type" id="guest-type"/>
                                                            <label for="guest-type">
                                                                {{__('messages.guest_checkout')}}
                                                            </label>
                                                        </span>
                                                    </div>
                                                    <p id="register">
                                                        Create an account with us and you'll be able to:
                                                        <span>- Check out faster
                                                        - Save multiple shipping addresses
                                                        - Access your order history
                                                        - Track new orders
                                                        - Save items to your wish list</span>
                                                    </p>
                                                    <p id="guest">
                                                        <strong>No Account? No Problem</strong>
                                                        Press Next to continue without any account.
                                                    </p>
                                                    <div class="formfooter text-right">
                                                        <input type="button" value="Next" class="btn btn-primary" id="without-login" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    {!! Form::open(['route' => ['user.login'], 'id' => 'login-form']) !!}
                                                        {!! Form::hidden("login_from_checkout", 1) !!}
                                                        <h5>
                                                            {{__('messages.returning_customer')}}
                                                        </h5>
                                                        <input type="text" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="E-mail *" value="{{ old('email') }}" />
                                                        @if ($errors->has('email'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                        <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password *"/>
                                                         @if ($errors->has('password'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                        @endif
                                                        <a href="{{ route('password.request') }}">
                                                            {{__('messages.forgot_password')}}
                                                        </a>
                                                        <div class="formfooter text-right">
                                                            <input type="submit" value="Login" class="btn btn-primary"/>
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!--frist step end-->
                            <!--second-step-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>
                                        <span>
                                            {{$i++}}
                                        </span>
                                        {{__('messages.shipping_details')}}
                                    </h4>
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{++$j}}" class="{{!Auth::guard('web')->check() ? 'disabled' : '' }} accordion-collapse collapse-{{$j}}" data-id="{{$j}}">
                                        <i class="{{!Auth::guard('web')->check() ? 'icon-plus' : 'icon-minus' }}"></i>
                                    </a>
                                </div>
                                <div id="collapse-{{$j}}" class="panel-collapse collapse {{Auth::guard('web')->check() ? 'show' : '' }}">
                                    <div class="panel-body">
                                        {!! Form::open(['route' => ['user.shipping_address'], 'id' => 'user-register-form']) !!}
                                        <div class="row second-step">
                                            <div class="col-md-12">
                                                @if (Auth::guard('web')->check())
                                                    <div class="radioboxrow">
                                                        <span>
                                                            <input type="radio" value="0" name="address_option" class="address-option" id="raccount" checked="" />
                                                            <label for="raccount">
                                                                {{__('messages.existing_shippiing_address')}}
                                                            </label>
                                                        </span>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-lg-6 col-md-12">
                                                      {!! Form::select('address', $shippingAddresses, null, ['placeholder' => __('messages.select_address').'&nbsp;*', 'id' => "address",'class' => "select2 form-control " . ($errors->has('address') ? 'is-invalid' : '')]) !!}
                                                      </div>
                                                    </div>

                                                @endif
                                                <div class="radioboxrow" {{!Auth::guard('web')->check() ? 'style=display:none;' : ''}}>
                                                    <span>
                                                        <input type="radio" value="1" name="address_option" class="address-option" id="raccount" {{ !Auth::guard('web')->check() ? 'checked' : ''}} />
                                                        <label for="raccount">
                                                            {{__('messages.new_shippiing_address')}}
                                                        </label>
                                                    </span>
                                                </div>
                                                </div>
                                                <div class="col-sm-12 alert alert-danger print-error-msg" id="print-error-msg" style="display:none">
                                                    <ul></ul>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                <div class="address-input">
                                                    <h5>
                                                        {{__('messages.your_personal_details')}}
                                                    </h5>
                                                    @honeypot
                                                    {!! Form::text('first_name', null, ['id' => 'first_name', 'placeholder' => __('messages.enter_first_name').'&nbsp;*', 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}
                                                    {!! Form::text('last_name', null, ['id' => 'last_name', 'placeholder' => __('messages.enter_last_name').'&nbsp;*', 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}
                                                    {!! Form::text('address_name', null, ['placeholder' => __('messages.enter_company_name'), 'class' => "form-control ", 'maxlength' => 30]) !!}
                                                    {!! Form::text('email', null, ['id' => 'email', 'placeholder' => __('messages.enter_email').'&nbsp;*', 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}

                                                    @if (!Auth::guard('web')->check())
                                                        {!! Form::radio('new_customer', 'register', true, ["style" => "display:none"]) !!}
                                                        {!! Form::password('password', ['id' => 'password', 'placeholder' => __('messages.password').'&nbsp;*', 'class' => "form-control " . ($errors->has('password') ? 'is-invalid' : '')]) !!}
                                                        {!! Form::password('confirm_password', ['id' => 'confirm_password', 'placeholder' => __('messages.confirm_password') .'&nbsp;*', 'class' => "form-control " . ($errors->has('confirm_password') ? 'is-invalid' : '')]) !!}
                                                    @endif
                                                     {!! Form::text('mobile_no', null, ['placeholder' => __('messages.enter_mobile_no') .'&nbsp;*', 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}

                                                    {{-- <input type="text"  class="form-control"  placeholder="Fax"/> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <div class="address-input">
                                                    <h5>
                                                        {{__('messages.your_address')}}
                                                    </h5>
                                                    {{-- <input type="text" class="form-control" placeholder="Compnay Name"/> --}}
                                                    {!! Form::text('address_line_1', null, ['placeholder' => __('messages.enter_address_line_1') .'&nbsp;*', 'class' => "customer_address_required form-control " . ($errors->has('address_line_1') ? 'is-invalid' : '')]) !!}

                                                     {!! Form::text('address_line_2', null, ['placeholder' => __('messages.enter_address_line_2').'&nbsp;'.__('messages.optional'), 'class' => "customer_address_required form-control " . ($errors->has('address_line_2') ? 'is-invalid' : '')]) !!}

                                                    {!! Form::select('country_id', $countries, config('constants.DEFAULT_COUNTRY_ID'), ['placeholder' => __('messages.select_country') .'&nbsp;*', 'class' => "country_id customer_address_required select2 form-control " . ($errors->has('country_id') ? 'is-invalid' : '')]) !!}

                                                    {!! Form::select('state_id', $states, null, ['placeholder' => __('messages.select_state').'&nbsp;*', 'class' => "state_id customer_address_required select2 form-control " . ($errors->has('state_id') ? 'is-invalid' : '')]) !!}

                                                    {!! Form::text('state_name', null, ['placeholder' => __('messages.enter_state').'&nbsp;'.__('messages.optional'), 'id' => "state_name", 'disabled' => true,'class' => " customer_address_required form-control state_name" . ($errors->has('state_name') ? 'is-invalid' : ''),"style"=>"display: none;"]) !!}

                                                    {!! Form::text('city_name', null, ['placeholder' => __('messages.enter_city').'&nbsp;*', 'class' => "customer_address_required form-control " . ($errors->has('city_name') ? 'is-invalid' : '')]) !!}

                                                    {!! Form::text('zip_code', null, ['placeholder' => __('messages.enter_zip_code') .'&nbsp;*', 'class' => "customer_address_required form-control " . ($errors->has('zip_code') ? 'is-invalid' : '')]) !!}

                                                </div>
                                            </div>
                                            <div class="col-sm-12 checkboxrow">
                                                <span>
                                                    <input type="checkbox" value="1" class="checkbox-billing-address" name="billing_address" checked="checked" />
                                                    <label for="billing_address">
                                                        {{__('messages.delivery_and_billing_address_same')}}
                                                    </label>
                                                </span>
                                            </div>
                                            <div class="col-sm-12 formfooter text-center">
                                                <button type="submit"  id="submit-address" class="btn btn-primary">
                                                    <span class="spinner-border spinner-border-sm btnSpinner" role="status" aria-hidden="true" style="display: none"></span>
                                                    {{__('messages.continue')}}
                                                </button>
                                            </div>

                                        </div>
                                        {!! Form::close() !!}
                                    </div>

                                    <div class="pb-4 jq-address-suggestions" style="display: none;">
                                        <div class="alert alert-secondary rounded-0 mb-4">

                                            <h1 class="h5">Confirm a valid address.</h1>

                                            <ul class="list-group">

                                            </ul>

                                            <div class="mt-3 text-right w-100">
                                                <button class="btn btn-primary jq-confirm-address">Continue</button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--second step end-->
                            <!--billing address-step-->
                            <div class="panel panel-default billing-address-tab">
                                <div class="panel-heading">
                                    <h4>
                                        <span>
                                            {{$i++}}
                                        </span>
                                        {{__('messages.billing_details')}}
                                    </h4>
                                   <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{++$j}}" class="disabled accordion-collapse collapse-{{$j}}" data-id="{{$j}}">
                                        <i class="icon-plus"></i>
                                    </a>
                                </div>
                                <div id="collapse-{{$j}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        {!! Form::open(['route' => ['user.billing_address'], 'id' => 'user-billing-address-form']) !!}
                                        <div class="row second-step">
                                            <div class="col-md-12 col-lg-6">
                                                @if (Auth::guard('web')->check())
                                                    <div class="radioboxrow">
                                                        <span>
                                                            <input type="radio" value="0" name="billing_address_option" class="billing-address-option" id="raccount" checked="" />
                                                            <label for="raccount">
                                                                {{__('messages.existing_billing_address')}}
                                                            </label>
                                                        </span>
                                                    </div>
                                                    {!! Form::select('billing_address_id', $billingAddresses, null, ['placeholder' => __('messages.select_address').'&nbsp;*', 'id' => "billing_address_id",'class' => "customer_address_required select2 form-control " . ($errors->has('billing_address_id') ? 'is-invalid' : '')]) !!}
                                                @endif
                                                <div class="radioboxrow" {{!Auth::guard('web')->check() ? 'style=display:none;' : ''}}>
                                                    <span>
                                                        <input type="radio" value="1" name="billing_address_option" class="billing-address-option" id="raccount" {{ !Auth::guard('web')->check() ? 'checked' : ''}} />
                                                        <label for="raccount">
                                                            {{__('messages.new_billing_address')}}
                                                        </label>
                                                    </span>
                                                </div>
                                                <div class="col-sm-12 alert alert-danger print-error-msg" id="print-error-msg-billing" style="display:none">
                                                    <ul></ul>
                                                </div>
                                                <div class="billing-address-input">
                                                    <h5>
                                                        {{__('messages.your_personal_details')}}
                                                    </h5>
                                                    {!! Form::text('first_name', null, ['id' => 'first_name', 'placeholder' => __('messages.enter_first_name') .'&nbsp;*', 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}
                                                    {!! Form::text('last_name', null, ['id' => 'last_name', 'placeholder' => __('messages.enter_last_name') .'&nbsp;*', 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}
                                                    {!! Form::text('address_name', null, ['placeholder' => __('messages.enter_company_name').'&nbsp;*', 'class' => "form-control ", 'maxlength' => 30]) !!}
                                                    {!! Form::text('email', null, ['placeholder' => __('messages.enter_email') .'&nbsp;*', 'class' => "form-control " . ($errors->has('email') ? 'is-invalid' : '')]) !!}

                                                     {!! Form::text('mobile_no', null, ['placeholder' => __('messages.enter_mobile_no') .'&nbsp;*', 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}

                                                    {{-- <input type="text"  class="form-control"  placeholder="Fax"/> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <div class="billing-address-input">
                                                    <h5>
                                                        {{__('messages.your_address')}}
                                                    </h5>
                                                    {{-- <input type="text" class="form-control" placeholder="Compnay Name"/> --}}
                                                    {!! Form::text('address_line_1', null, ['placeholder' => __('messages.enter_address_line_1') .'&nbsp;*', 'class' => "customer_address_required form-control " . ($errors->has('address_line_1') ? 'is-invalid' : '')]) !!}

                                                     {!! Form::text('address_line_2', null, ['placeholder' => __('messages.enter_address_line_2').'&nbsp;'.__('messages.optional'), 'class' => "customer_address_required form-control " . ($errors->has('address_line_2') ? 'is-invalid' : '')]) !!}

                                                    {!! Form::select('country_id', $countries, config('constants.DEFAULT_COUNTRY_ID'), ['placeholder' => __('messages.select_country') .'&nbsp;*', 'class' => "country_id customer_address_required select2 form-control " . ($errors->has('country_id') ? 'is-invalid' : '')]) !!}

                                                    {!! Form::select('state_id', $states, null, ['placeholder' => __('messages.select_state') .'&nbsp;*', 'class' => "state_id customer_address_required select2 form-control " . ($errors->has('state_id') ? 'is-invalid' : '')]) !!}

                                                    {!! Form::text('state_name', null, ['placeholder' => __('messages.enter_state').'&nbsp;'.__('messages.optional'), 'id' => "state_name", 'disabled' => true,'class' => " customer_address_required form-control state_name" . ($errors->has('state_name') ? 'is-invalid' : ''),"style"=>"display: none;"]) !!}

                                                    {!! Form::text('city_name', null, ['placeholder' => __('messages.enter_city') .'&nbsp;*', 'class' => "customer_address_required form-control " . ($errors->has('city_name') ? 'is-invalid' : '')]) !!}

                                                    {!! Form::text('zip_code', null, ['placeholder' => __('messages.enter_zip_code') .'&nbsp;*', 'class' => "customer_address_required form-control " . ($errors->has('zip_code') ? 'is-invalid' : '')]) !!}
                                                </div>
                                            </div>
                                            <div class="col-sm-12 formfooter text-center">
                                                <button type="submit"  id="submit-billing-address" class="btn btn-primary">
                                                    <span class="spinner-border spinner-border-sm btnSpinner" role="status" aria-hidden="true" style="display: none"></span>
                                                    {{__('messages.continue')}}
                                                </button>
                                            </div>

                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <!--billing address step end-->
                            <!-- Shipping Fee start-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>
                                        <span>
                                            {{$i++}}
                                        </span>
                                        {{__('messages.shipping_method')}}
                                    </h4>
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{++$j}}" class=" accordion-collapse disabled collapse-{{$j}}" data-id="{{$j}}">
                                        <i class="icon-plus"></i>
                                    </a>
                                </div>
                                <div id="collapse-{{$j}}" class="panel-collapse collapse">
                                    <div class="panel-body shipping-fee">
                                        <div class="alert alert-success rounded-0g">
                                            Please wait...
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Shipping Fee end-->
                            <!--order summary step start-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>
                                        <span>
                                            {{$i++}}
                                        </span>
                                        {{__('messages.order_summery')}}
                                    </h4>
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{++$j}}" class=" accordion-collapse disabled collapse-{{$j}}" data-id="{{$j}}">
                                        <i class="icon-plus"></i>
                                    </a>
                                </div>
                                @php
                                    $grandTotal = $discount = 0;
                                @endphp
                                    <div id="collapse-{{$j}}" class="panel-collapse collapse">

                                    <div class="panel-body">
                                        <div class="forth-step">
                                        @foreach($cart as $value)
                                            @php
                                              $productSkusKey = '';
                                              //Select here product sku key from products object
                                              if (!is_string($value['id']) && $products[$value['attributes']['product_id']]->productSkus->count() > 0) {
                                                $product = $products[$value['attributes']['product_id']];
                                                foreach($product->productSkus as $key => $productSkus) {
                                                  if ($productSkus->id == $value['id']) {
                                                    $productSkusKey = $key;
                                                    break;
                                                  }
                                                }
                                              } else {
                                                $product = $products[$value['attributes']['product_id']];
                                              }
                                              $price = isset($product->productSkus[$productSkusKey]) ? $product->productSkus[$productSkusKey]->price : $product->price;
                                              $grandTotal = $grandTotal + ($price * $value['quantity']);
                                            @endphp

                                        <div class="cart-data">
                                            <div class="row">
                                              <div class="imgbox datacol">
                                              <img src="{{ (($productSkusKey >= 0 && !empty($product->productSkus[$productSkusKey]->medias)) ? $product->productSkus[$productSkusKey]->medias->getUrl() : (!empty($product->medias[0]) ? $product->medias[0]->getUrl() : asset('images/no-image/default-new-arrival-home.png'))) }}" alt="" title=""/>
                                              </div>
                                              <div class="detailbox datacol">
                                                   <h5><a href="{{route('product.detail', ['product' => $product->slug])}}" target="_blank"> {{$product->name}}</a></h5>
                                                    <strong> {{__('messages.brand')}}</strong>     {{$product->brand->name ?? '-'}}
                                                    <br>
                                                    <strong> {{__('messages.options')}}</strong>      @if (!empty($product->productSkus[$productSkusKey]))
                                                                  @foreach ($product->productSkus[$productSkusKey]->productSkuValues as $row)
                                                                    <!-- <strong>
                                                                      {{$row->attribute->name}}:
                                                                    </strong> -->
                                                                    {{$row->attributeOptions->option}}
                                                                  @endforeach
                                                                @endif
                                                    <br>
                                                    <strong>{{__('messages.quantity')}} </strong>   {{$value['quantity']}}
                                              </div>
                                              <div class="add-remove-row datacol">
                                                  <div class="price">
                                                    <i>
                                                        {{__('messages.total')}}:</i>
                                                        {{setting('currency_symbol')}}
                                                        <span id="price-{{$value['id']}}">
                                                            {{ number_format(round($price * $value['quantity'],2),2)}}
                                                        </span>
                                                  </div>
                                              </div>
                                           </div>
                                        </div>

                                        @endforeach
                                            <div class="col-sm-12 formfooter text-right">

                                                <div>
                                                    {!! Form::text('purchase_order', null, ['id' => 'purchase_order', 'placeholder' => __('messages.purchase_order').'&nbsp;*', 'class' => "form-control " . ($errors->has('purchase_order') ? 'is-invalid' : '')]) !!}
                                                </div>

                                                <button type="button" onclick="moveNextTab($(this))" class="btn btn-primary">
                                                    {{__('messages.continue')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--order summary step end-->
                            <!-- Payment Option Start-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>
                                        <span>
                                            {{$i++}}
                                        </span>
                                        {{__('messages.payment_option')}}
                                    </h4>
                                     <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{++$j}}" class="disabled accordion-collapse collapse-{{$j}}" data-id="{{$j}}">
                                        <i class="icon-plus"></i>
                                    </a>
                                </div>
                                <div id="collapse-{{$j}}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="third-step">
                                            <ul class="nav nav-tabs" role="tablist">
                                                @foreach ($paymentOption as $key => $value)
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $key == 0 ? 'active' : '' }} " href="#tab-{{$key}}" role="tab" data-toggle="tab">
                                                            {{$value->title}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" href="#netbanking" role="tab" data-toggle="tab">
                                                        Net Banking
                                                    </a>
                                                </li> --}}
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" href="#cod" role="tab" data-toggle="tab">
                                                        {{__('messages.cash_on_delivery')}}
                                                    </a>
                                                </li> --}}
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                @foreach ($paymentOption as $key => $value)
                                                    <div role="tabpanel" class="tab-pane fade in {{ $key == 0 ? 'active show' : '' }}" id="tab-{{$key}}">
                                                        <div class="alert alert-danger">
                                                          <strong>{{__('messages.error')}}</strong> <span class="payment-error"></span>
                                                        </div>
                                                        {!! Form::open(['route' => ['confirm_order'], 'id' => 'payment-optiob-' . $value->id]) !!}
                                                            {!! Form::hidden("payment_option", $value->id) !!}
                                                            @if ($value->isFree)
                                                                <h5>
                                                                    Cash
                                                                </h5>
                                                                <p>
                                                                    Please keep exact change handy to  help us serve you better
                                                                </p>
                                                            @else
                                                               @include('front.payments.' . $value->view)
                                                            @endif
                                                            <div class="col-sm-12 formfooter text-right">
                                                                <button type="submit" class="btn btn-primary confirm-order">
                                                                    <span class="spinner-border spinner-border-sm btnSpinner" role="status" aria-hidden="true" style="display: none"></span>
                                                                    {{ $value->isFree ? __('messages.confirm_order') : __('messages.make_payment') }}
                                                                </button>
                                                            </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endforeach
                                                {{-- <div role="tabpanel" class="tab-pane fade" id="netbanking">
                                                    <a href="#">
                                                        HDFC
                                                    </a>
                                                    <br/>
                                                    <a href="#">
                                                        SBI
                                                    </a>
                                                    <br/>
                                                    <a href="#">
                                                        ICICI
                                                    </a>
                                                </div> --}}
                                                <div role="tabpanel" class="tab-pane fade" id="cod">
                                                    {!! Form::open(['route' => ['confirm_order'], 'id' => 'cash-on-delivery']) !!}
                                                        {!! Form::hidden("cash_on_delivery", 1) !!}
                                                        <h5>
                                                            Cash
                                                        </h5>
                                                        <p>
                                                            Please keep exact change handy to  help us serve you better
                                                        </p>
                                                        <button type="submit" class="btn btn-primary confirm-order">
                                                            <span class="spinner-border spinner-border-sm btnSpinner" role="status" aria-hidden="true" style="display: none"></span>
                                                            {{__('messages.confirm_order')}}
                                                        </button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Payment Option End-->
                        </div>
                        <!-- accordian end-->
                    </div>

                    <div class="col-md-5 col-lg-4 wow slideInRight">

                        <span id="coupon-remove"></span>
                        <div class="couponbox coupon-apply {{ (!$displayCoupon) ? 'd-none':''}}">
                            <input type="text" placeholder="Enter Your Code" id="coupon_code" />
                            <button type="button" id="apply-coupon" class="btn btn-round">
                                {{__('messages.apply_coupon')}}
                            </button>
                            <br/>
                            <span id="coupon-error"></span>
                        </div>
                        <span id="coupon-success"></span>
                        <div class="couponbox coupon-apply-success">
                            <label id="coupon_code_label"></label>
                            <button type="button" id="remove-apply-coupon" class="btn btn-round">
                                {{__('messages.remove')}}
                            </button>
                            <br/>
                        </div>

                        <div class="" id="discounts-list"></div>

                        <div class="pricedetail text-left">
                            <h5>
                                {{__('messages.price_details')}}
                            </h5>
                            <div class="content">

                                <table>
                                    <tr>
                                        <td>
                                            {{__('messages.price')}} ({{ !empty($cart) ? array_sum(array_column($cart, 'quantity')) : 0}} {{__('messages.items')}})
                                        </td>
                                        <td>
                                            {{setting('currency_symbol')}}<span id="total-price">{{number_format($grandTotal,2)}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{__('messages.shipping_fee')}}
                                        </td>
                                        <td>
                                            <span id="shipping-charge">-</span>
                                        </td>
                                    </tr>
                                    <tr class="jq-is-hazmat" style="display: none;">
                                        <td class="text-nowrap">
                                            {{__('messages.hazmat_shipping_cost')}}
                                        </td>
                                        <td>
                                            <span id="hazmat-shipping-cost">${{ number_format($hazmatCost, 2) }}</span>
                                        </td>
                                    </tr>
                                    <tr class="pickup-from-store">
                                        <th colspan="2" class="text-left">
                                            {{__('messages.pickup_from_store')}} ({{__('messages.store_address')}})
                                        </th>
                                    </tr>
                                    <tr class="pickup-from-store">
                                        <td colspan="2" class="text-left" id="store-address">
                                            -
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-left">
                                            {{__('messages.address')}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-left shipping-address">
                                            -
                                        </td>
                                    </tr>
                                    <tr class="discount {{ (!$displayCoupon) ? 'd-none':''}}">
                                        <td>
                                            {{__('messages.discount')}}
                                        </td>
                                        <td>
                                            {{setting('currency_symbol')}}<span id="discount">{{number_format($discount,2)}}</span>
                                        </td>
                                    </tr>

                                    @php
                                        $grandTotal = \App\CartStorage::isHazmat()
                                            ? $grandTotal + $hazmatCost
                                            : $grandTotal;
                                    @endphp

                                    <tr>
                                        <th>
                                            {{__('messages.total_payable')}}
                                        </th>
                                        <th>
                                            {{setting('currency_symbol')}}<span id="grand-total">{{number_format($grandTotal,2)}}</span>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </form> --}}

        </div>
    </div>
</section>

<style type="text/css">
a.disabled {
  pointer-events: none;
  cursor: default;
}

.jq-remove-coupon:hover {
    cursor: pointer;
    color: red;
}

</style>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\RegistrationRequest', '#user-register-form') !!}
{!! JsValidator::formRequest('App\Http\Requests\BillingAddressRequest', '#user-billing-address-form') !!}
{!! JsValidator::formRequest('App\Http\Requests\AdminLoginRequest', '#login-form') !!}
{!! JsValidator::formRequest('App\Http\Requests\CcRequest', '#payment-optiob-2') !!}
<script type="text/javascript">

    var addresses = []

    try {
        triggerCheckoutEvent(2)
    } catch (e) {
    }

    @if (!Auth::guard('web')->check())
        var tabId = 1;
    @else
        var tabId = 2;
    @endif
    $(".alert-danger, .pickup-from-store").hide();

    var accordionCollapse = true, shippingCost = 0;
    $(".accordion-collapse").click(function(e) {
        if($(this).parents('.panel').children('.panel-collapse').hasClass('show')){
            e.stopPropagation();
            return false;
        }
        if ($(this).data('id') == 3 && tabId==2 && $("input[name='billing_address']").is(":checked")) {
            e.stopPropagation();
            return false;
        }
        $("#collapse-" + tabId).collapse('hide');
        tabId = $(this).data('id');
    });
    $("#password, #confirm_password").hide();
    @if (Auth::guard('web')->check())
        $(".address-input").hide();
        $(".po-box").hide();
        $(".billing-address-input").hide();
    @endif
    $("#without-login").click(function(e) {
        $("#login-form").valid();
        $("#login-form").find("input, select").removeClass("is-invalid");
        if ($("input[name='login_type']:checked").val() == 'guest') {
            $("#password, #confirm_password").hide();
            $("#user-register-form").valid();
            $("#user-register-form").find("input, select").removeClass("is-invalid");
        } else {
            $("#password, #confirm_password").show();
        }
        if ($("input[name='login_type']:checked").val() == "register") {
            $("input[name='new_customer']").prop("checked", true);
        } else {
            $("input[name='new_customer']").prop("checked", false);
        }

        moveNextTab($(this));
    });

    function moveNextTab($this) {
        tabId = parseInt($this.closest('div.panel-default').find('a.accordion-collapse').data('id'));
        //$("collapse-" + tabId).collapse('hide');
        var increment = 1;
        if (tabId == 2 && $("input[name='billing_address']").is(":checked")) {
            increment = 2;
            // if (!$(".collapse-" + (tabId + 1)).hasClass('disabled')) {
            //     $(".collapse-" + (tabId + 1)).addClass('disabled');
            // }
            if ($(".collapse-" + (tabId + 1)).hasClass('disabled')) {
                $(".collapse-" + (tabId + 1)).removeClass('disabled');
            }
        }
        $(".collapse-" + (tabId + increment)).removeClass('disabled');
        $(".collapse-" + (tabId + increment)).trigger('click');
        for (i = tabId + 1; i <= parseInt({{$j}}); i++) {
            if (!$(".collapse-" + i).hasClass('disabled')) {
                $(".collapse-" + i).addClass('disabled');
            }
        }

        try {
            triggerCheckoutEvent(tabId + 1)
        } catch (e) {

        }
    }

    $('body').on('change', '.address-option', function(){
        if ($("input[name='address_option']:checked").val() == 1) {
            $('#address').hide();
            $('.address-input').show();
            $('.po-box').show();
           $("#collapse-" + tabId).find(".state_name").hide();
        } else {
            $('#address').show();
            $('.address-input').hide();
            $('.po-box').hide();
        }
    });
    $('body').on('change', '.billing-address-option', function(){
        if ($("input[name='billing_address_option']:checked").val() == 1) {
            $('#billing_address_id').hide();
            $('.billing-address-input').show();
            $("#collapse-" + tabId).find(".state_name").hide();
        } else {
            $('#billing_address_id').show();
            $('#address').show();
            $('.billing-address-input').hide();
        }
    });
    $(".country_id").change(function() {
        $state = $("#collapse-" + tabId).find(".state_id");
        $stateName = $("#collapse-" + tabId).find(".state_name");
        $state.empty();
        $state.append(new Option("{{__('messages.select_state')}} *", ''));
        $.ajax({
            type: 'POST',
            url: "{{ route('get-state') }}",
            dataType: "json",
            data: {
                country_id: $(this).val(),
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
               var count = Object.keys(response.state).length;
            if (count == 0) {
                $($stateName).show();
                $($stateName).removeAttr('disabled');
                $($state).attr('disabled', true);
                $($state).val('');
                $($state).hide();
            } else {
                $($stateName).hide();
                $($stateName).attr('disabled', true);
                $($state).removeAttr('disabled');
                $($stateName).val('');
                $($state).show();
                $.each(response.state, function(text, key) {
                    $state.append(new Option(key.name, key.id));
                });
            }
            }
        });
    });

    //Save customer address or regester new user or guest user send OTP in email address and verified.
    $("#submit-address").click(function() {
        if ($("#user-register-form").valid()) {
            var form = $("#user-register-form");
            var url = form.attr('action');
            var $this = $(this);
            $(".btn-primary").prop("disabled", true);
            $(".btnSpinner").show();
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize() + '&login_type=' + $("input[name='login_type']:checked").val(),
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    if (response.validAddress !== undefined && response.validAddress !== null) {

                        confirmAddress(response.validAddress, $this)

                    } else {

                        if (response.status == "success") {
                            $("#print-error-msg").css('display','none');

                            if ($("input[name='address_option']:checked").val() == 1) {
                                $(".shipping-address").text(response.address);
                            } else {
                                $(".shipping-address").text($("#address option:selected").text());
                                $(".shipping-address").text();
                            }
                            if ($("#remove-apply-coupon").is(":visible")) {
                                $("#apply-coupon").trigger('click');
                            }
                            moveNextTab($this);
                            // Get Shipping information
                            getShipping();
                            $(".btnSpinner").hide();
                            $(".btn-primary").prop("disabled", false);
                        }
                    }

                },
                error: function (err, msg) {

                    // 105 Erickson Ave Hastings, Florida, 32145, United States
                    if( err.status == 422 ) {

                        $("#print-error-msg").find("ul").html('');
                        $("#print-error-msg").css('display', 'block');

                        var errors = err.responseJSON;

                        $.each( errors.errors, function( key, value ) {
                            $("#collapse-2").find("ul").append('<li>'+value+'</li>');
                        });

                        $('html, body').animate({
                            scrollTop: $(".checkoutpage").offset().top
                        }, 2000);

                    } else {

                        try {

                            if (err.responseJSON !== undefined && err.responseJSON.length > 0) {
                                addresses = err.responseJSON
                                $("#user-register-form").hide()
                                showAddressSuggestions(addresses)
                            } else {
                                if (err.responseJSON !== undefined && err.responseJSON.message !== undefined) {
                                    flashMessage('error', 'Invalid Address validation. Please verify your address.');
                                } else {
                                    flashMessage('error', 'Invalid Address validation. Please verify your address.');
                                }
                            }

                        } catch (e) {
                            flashMessage('error', 'Invalid Address validation. Please verify your address.');
                        }
                    }

                    $(".btnSpinner").hide();
                    $(".btn-primary").prop("disabled", false);
                }
            });
            return false;
        }
    });
    $('.panel-collapse').on('show.bs.collapse', function(e) {
        if (tabId == 3 && $("input[name='billing_address']").is(":checked")) {
            $(".collapse-" + (tabId - 1 )).trigger('click');
            return false;
        }
        if (IsInViewport($("#"+e.target.id))) {
            $('html, body').animate({
                scrollTop: $(".checkoutpage").offset().top
            }, 1000);
        }
        $(this).prev(".panel-heading").find("i").removeClass("icon-plus").addClass("icon-minus");
    }).on('hide.bs.collapse', function(){
            $(this).prev(".panel-heading").find("i").removeClass("icon-minus").addClass("icon-plus");
        });

    // submit billing address
    $("#submit-billing-address").click(function() {
        if ($("#user-billing-address-form").valid()) {
            var form = $("#user-billing-address-form");
            var url = form.attr('action');
            var $this = $(this);
            $(".btn-primary").prop("disabled", true);
            $(".btnSpinner").show();
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success") {
                        $("#print-error-msg-billing").css('display','none');
                        moveNextTab($this);
                    }
                    $(".btnSpinner").hide();
                    $(".btn-primary").prop("disabled", false);
                },
                error: function (err,msg) {
                if( err.status == 422 ) {
                    $("#print-error-msg-billing").find("ul").html('');
                    $("#print-error-msg-billing").css('display','block');
                    var errors = err.responseJSON;
                    $.each( errors.errors, function( key, value ) {
                        $("#collapse-3").find("ul").append('<li>'+value+'</li>');
                    });
                    $('html, body').animate({
                        scrollTop: $(".checkoutpage").offset().top
                    }, 2000);
                }else{
                    flashMessage('error', msg);
                    // $("#print-error-msg-billing").css('display','block');
                    // $(".print-error-msg-billing").find("ul").append('<li>'+msg+'</li>');
                }
                $(".btnSpinner").hide();
                $(".btn-primary").prop("disabled", false);
            }
            });
            return false;
        }
    });
    var isValidCoupon = 0, couponCode = '';
    $(".coupon-apply-success").hide();
    var grandTotal = "{{$grandTotal}}";

    let discounts = []

    $('body').on('click', '#apply-coupon', function(e) {

        couponCode = $("#coupon_code").val().trim()

        if (couponCode == "") {
            $("#coupon-error").text('');
            $("#coupon-error").text("{{__('messages.please_enter_coupon_code')}}");
            setTimeout(function(){
                $("#coupon-error").text('');
            }, 5000);
            return;
        }

        let codes = discounts.map(function(e) {
            return e.code
        })

        if (codes.includes(couponCode)) {
            $("#coupon-error").text('');
            $("#coupon-error").text("Coupon code already applied.");
            setTimeout(function(){
                $("#coupon-error").text('');
            }, 5000);
            return;
        }

        $.ajax({
            type: "POST",
            url: '/apply-coupon',
            dataType: "json",
            data: {
              'coupon_code': couponCode,
              'discounts': discounts,
              'email': $("#email").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success == true) {

                    discounts = response.discounts

                    renderCoupons(discounts)

                    // $('#coupon_code_label').text($("#coupon_code").val());
                    // $(".coupon-apply-success").show();
                    // $(".coupon-apply").hide();

                    isValidCoupon = 1;
                    $("#grand-total").text(response.grandTotal)
                    grandTotal = response.grandTotal;
                    $("#coupon-success").text("{{__('messages.coupon_successfully_applied')}}");
                    $("#coupon-success").css("color", "green");
                    $("#coupon-success").show()
                    var total = (parseFloat(grandTotal)+parseFloat(shippingCost)).toFixed(2)
                    $("#grand-total").text(addCommas(total));

                } else {

                    // if ($("#remove-apply-coupon").is(":visible")) {
                    //     var coupongCode = $("#coupon_code").val();
                    //     $('#remove-apply-coupon').trigger('click');
                    // }

                    $("#coupon-error").text('');

                    try {
                        var errorMessage = response.error;

                        if (errorMessage == 'Server Error') {
                            errorMessage = 'Coupon could not be applied';
                        }

                        $("#coupon-error").text(errorMessage);
                    } catch (e) {
                        $("#coupon-error").text('Coupon could not be applied');
                    }

                    setTimeout(function(){
                        $("#coupon-error").text('');
                    }, 5000);
                }

                $("#coupon_code").val('');
                $("#discount").text(getTotalDiscount(discounts));
                renderCoupons(discounts)
                setTimeout(function() {
                    $("#coupon-success").hide()
                }, 3 * 1000)
            },

            error: function(response) {

                setTimeout(function(){
                    $("#coupon-error").text('');
                }, 5000);

                try {
                    $("#coupon-error").text(response.responseJSON.message);
                } catch (e) {

                }
            }
        });
    });

    $('body').on('click', '.jq-remove-coupon', function(event) {
        event.preventDefault();

        let code = $(this).parents('tr').attr('data-code')
        let discount = 0

        discounts = discounts.filter(function(e) {
            if (e.code == code) {
                discount = e.discount_value
                return false;
            }
            return true
        })

        renderCoupons(discounts)

        let totalDiscount = getTotalDiscount(discounts)

        grandTotal = grandTotal + discount;

        $("#grand-total").text(addCommas(((parseFloat(grandTotal) + parseFloat(shippingCost)).toFixed(2))));
        $("#discount").text(totalDiscount);

    });

    $('body').on('click', '#remove-apply-coupon', function(e) {
        $(".coupon-apply-success").hide();
        $("#coupon-success").text('');
        $("#coupon-remove").text("{{__('messages.coupon_successfully_removed')}}");
        $("#coupon-remove").css("color","green");
        $("#coupon_code").val('');
        $('#coupon_code_label').text('');
        $("#coupon-error").text('');
        $(".coupon-apply").show();
        setTimeout(function(){
            $("#coupon-remove").text('');
        }, 3000);
        isValidCoupon = 0;
        var discount = parseFloat($("#discount").text())
        grandTotal = grandTotal + discount;
        $("#grand-total").text(addCommas(((parseFloat(grandTotal) + parseFloat(shippingCost)).toFixed(2))));
        $("#discount").text(0.00);
    });

    $('body').on('input', '#purchase_order', function(event) {
        event.preventDefault();

        if ($(this).val().length === 0) {
            $(this).parents('.panel-collapse').find('[type="button"]').prop('disabled', false)
            $(this).removeClass('border border-danger')
            return
        }

        if (/^[a-z0-9]+$/i.test($(this).val()) === false || $(this).val().length > 20) {
            $(this).parents('.panel-collapse').find('[type="button"]').prop('disabled', true)
            $(this).addClass('border border-danger')
        } else {
            $(this).parents('.panel-collapse').find('[type="button"]').prop('disabled', false)
            $(this).removeClass('border border-danger')
        }
    });

    $(".confirm-order").click(function() {
        formId = $(this).closest('form').attr('id');
        paymentTab = $(this).closest('div.tab-pane');
        if ($("#" + formId).valid()) {
            $(".confirm-order").prop("disabled", true);
            $(".btnSpinner").show();
            //$("div#loading").addClass('show');
            var form = $("#" + formId);
            var url = form.attr('action');
            var $this = $(this);
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize() + "&is_valid_coupon=" + isValidCoupon + "&coupon_code=" + couponCode + "&" + $("#shipping-fee-form").serialize() + '&purchase_order=' + $('#purchase_order').val() + '&discounts=' + JSON.stringify(discounts),
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.redirect_url) {
                       location.href = response.redirect_url;
                    } else if (response.status == "error") {
                        $(".alert-danger").hide();
                        $(paymentTab).find('span.payment-error').text(response.message);
                        $(paymentTab).find('div.alert-danger').show();
                    }
                    $(".confirm-order").prop("disabled", false);
                    $(".btnSpinner").hide();
                    $("div#loading").removeClass('show');
                },
                error: function(xhr, status, error) {
                    $(".btnSpinner").hide();
                    $(".confirm-order").prop("disabled", false);
                    if (xhr.responseJSON) {
                        flashMessage('error', xhr.responseJSON.message);
                    }
            }
            });
            return false;
        }
    });

    // Get Shipping  information
    function getShipping() {
        $(".confirm-order").prop("disabled", true);
        $(".btnSpinner").show();
        $.ajax({
            type: 'GET',
            url: "{{ route('shipping') }}",
            data: {email: $("#email").val() },
            success: function(html) {
                $(".shipping-fee").html(html);
            },
            error: function(xhr, status, error) {
                    $(".btnSpinner").hide();
                    $(".confirm-order").prop("disabled", false);
                    if (xhr.responseJSON) {
                        flashMessage('error', xhr.responseJSON.message);
                    }
            }
        });
    }
    // Get shipping quotes.
    $('body').on('change', "input[name='shipping_quotes']", function(){
        if ($(this).val() == "own_shipping") {
            $('.own-shipping').show()
        } else {
            $('.own-shipping').hide()
        }
    });
    $('body').on('click', "#submit-shipping", function() {
        if ($("#shipping-fee-form").valid()) {
            var form = $("#shipping-fee-form");
            var url = form.attr('action');
            var $this = $(this);
            $(".confirm-order").prop("disabled", true);
            $(".btnSpinner").show();
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success") {

                        shippingCost = parseFloat(response.shipping.shipping_cost).toFixed(2);

                        if (response.shipping.shipping_option_chosen == 'pickup-from-store') {
                            $('#store-address').html('12336 Emerson Dr.<br />Brighton, MI 48116, USA');
                            $('.pickup-from-store').show();
                        } else {
                            $('.pickup-from-store').hide();
                        }
                        var cartPrice = parseFloat($('#total-price')[0].innerText);
                        var prevTotal = parseFloat(grandTotal);
                        if(response.shipping.shipping_option_chosen == 'own' || response.shipping.shipping_option_chosen == 'pickup-from-store') {
                            $('#hazmat-shipping-cost').text('$0');
                            prevTotal -= {{ $hazmatCost }};
                        } else {
                            $('#hazmat-shipping-cost').text('${{ number_format($hazmatCost, 2) }}');
                        }
                        $("#shipping-charge").text(response.shipping.shipping_text);
                        var total = (prevTotal + parseFloat(shippingCost)).toFixed(2)
                        $("#grand-total").text(addCommas(total));
                        moveNextTab($this);
                        $(".btnSpinner").hide();
                        $(".confirm-order").prop("disabled", false);
                    }
                },
                error: function(xhr, status, error) {
                    $(".confirm-order").prop("disabled", false);
                    $(".btnSpinner").hide();
                    if (xhr.responseJSON) {
                        flashMessage('error', xhr.responseJSON.message);
                    }
                }
            });
            return false;
        }
    });

    $('input[name="login_type"]').change(function(){
        var clickvalue = $(this).val();
        if(clickvalue == 'guest'){
            $('#register').hide();
            $('#guest').show();
        }else{
            $('#register').show();
            $('#guest').hide();
        }
    });

    $(document).ready(function(){
        $('p#guest').hide();
    });












    $(function() {

        $('#guest-type').trigger('click')


        $('body').on('click', '.jq-prev-step', function(event) {
            event.preventDefault();
            $(this).parents('.panel.active').prev().find('.accordion-collapse').trigger('click')
        });

        $('body').on('change', '[name="address_confirmation"]', function(event) {
            event.preventDefault();
            let index = $(this).val()
            if (addresses[index] !== undefined && addresses[index] !== null && typeof(addresses[index]) === 'object') {
                $('.jq-confirm-address').prop('disabled', false);
            } else {
                $('.jq-confirm-address').prop('disabled', true);
            }
        });


        $('body').on('click', '.jq-confirm-address', function(event) {
            event.preventDefault();
            let selected = $('[name="address_confirmation"]:checked')
            var $this = $(this);

            if (selected.length === 0) {
                flashMessage('error', 'Please select a valid address');
                return false;
            }

            let index = parseInt($(selected).val())

            if ( ! (addresses[index] !== undefined && addresses[index] !== null && typeof(addresses[index]) === 'object')) {
                flashMessage('error', 'Please select a valid address');
                return false;
            }

            let address = addresses[index];

            confirmAddress(address, $this)
        });
    })


    function confirmAddress(address, $this)
    {
        $.ajax({
            url: '{{ route('user.address_confirmation') }}',
            type: 'POST',
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: address,
        })
        .done(function(response) {
            if (response.status == "success") {
                $("#print-error-msg").css('display','none');
                if ($("input[name='address_option']:checked").val() == 1) {
                    $(".shipping-address").text(response.address);
                } else {
                    $(".shipping-address").text($("#address option:selected").text());
                    $(".shipping-address").text();
                }
                if ($("#remove-apply-coupon").is(":visible")) {
                    $("#apply-coupon").trigger('click');
                }
                moveNextTab($this);
                // Get Shipping information
                getShipping();
                $(".btnSpinner").hide();
                $(".btn-primary").prop("disabled", false);
            }
        })
        .fail(function(error) {
        })
        .always(function() {
        });
    }


    function showAddressSuggestions(addresses) {

        let parent = $('.jq-address-suggestions').find('.list-group')

        $(parent).empty()

        $.each(addresses, function(index, address) {

            var addressText = address.addressLine;

            if (address.addressLine2 !== null) {
                addressText += ', ' + address.addressLine2;
            }

            if (address.addressLine3 !== null) {
                addressText += ', ' + address.addressLine3;
            }

            if (address.region !== null) {
                addressText += ', ' + address.region;
            }

            if (address.countryCode !== null) {
                addressText += ', ' + address.countryCode;
            }

            $(parent).append('<li class="list-group-item list-group-item-action jq-select-address py-0 rounded-0">\
                <label class="mb-0 d-flex flex-row align-items-center justify-content-between py-2">\
                    '+addressText+'&nbsp;\
                    <input type="radio" name="address_confirmation" value="'+index+'"/>\
                </label>\
            </li>');
        });

        $('.jq-address-suggestions').show()
        $('.jq-confirm-address').prop('disabled', true);
    }

    function renderCoupons(discounts) {

        $('#discounts-list').empty()

        let html = discounts.map(function(e) {
            return '<tr data-discount="'+e.discount_value+'" data-code="'+e.code+'">\
                    <td class="text-nowrap text-left">'+e.code+' ($'+e.discount+')</td>\
                    <td class="text-right"><span class="jq-remove-coupon">Remove</span></td>\
                </tr>';
        }).join('');

        $('#discounts-list').append('<table class="table table-borderless">'+html+'</table>')
    }

    function getTotalDiscount(discounts) {
        let total = 0

        discounts.map(function(e) {
            total = total + e.discount_value
        });

        return parseFloat(parseFloat(total).toFixed(2))
    }

</script>
@endsection
