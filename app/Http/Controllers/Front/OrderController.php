<?php

namespace App\Http\Controllers\Front;

use DB;
use Auth;
use Cart;
use Hash;
use SEOMeta;
use Session;
use App\User;
use App\Email;
use App\Order;
use App\State;
use Exception;
use App\Coupon;
use App\Country;
use App\Product;
use App\OrderItem;
use Carbon\Carbon;
use App\ProductSku;
use App\CartStorage;
use App\UserAddress;
use Omnipay\Omnipay;
use App\PaymentSetting;
use App\ShippingSetting;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Front\FrontController;

class OrderController extends FrontController
{

    use RegistersUsers;

    public function index()
    {
        $orders = Order::with(['orderItems' => function ($query) {
            $query->with(['product' => function ($query) {
                $query->select('id', 'name', 'brand_id', 'slug')->with(['brand', 'medias' => function ($query) {
                    $query->whereJsonContains('custom_properties->default_image', true);
                }]);
            }, 'productSku.medias', 'orderStatus', 'orderStatus.orderItemStatusHistory' => function ($query) {
                $query->select('order_status_histories.order_item_id', 'order_status_histories.order_status_id', 'order_status_histories.created_at as date');
            }])->orderBy('id', 'DESC');
        }])->where('user_id', Auth::guard('web')->user()->id)->orderBy('id', 'DESC')->active()->get();
        return view('front.account.myaccount', compact('orders'));
    }

    public function checkout()
    {
        SEOMeta::setTitle(config('constants.PAGE_META_TITLE.checkout'));
        $displayCoupon     = Coupon::displayCouponBox();
        $countries         = Country::orderBy('name', 'asc')->pluck('name', 'id');
        $states         = State::orderBy('name', 'asc')->pluck('name', 'id');
        $shippingAddresses = $billingAddresses = [];
        if (Auth::guard('web')->check()) {
            $addresses = UserAddress::where('user_id', Auth::guard('web')->user()->id)
                ->with(['country', 'state'])->get();

            if ($addresses->count() > 0) {
                foreach ($addresses as $key => $value) {
                    $address = $value->address_line_1 . ", ";
                    if (! empty($value->state_id)) {
                        $stateName = $value->state->name;
                    } else {
                        $stateName = $value->state_name;
                    }
                    $address .= ! empty($value->address_line_2) ? $value->address_line_2 . ", " : '';
                    $address .= $value->city_name . ', ' . $stateName . ', ' . $value->zip_code . ', ' . $value->country->name;
                    if ($value->billing_type == 1) {
                        $shippingAddresses[$value->id] = $address;
                    } else {
                        $billingAddresses[$value->id] = $address;
                    }
                }
            }
        }

        $paymentOption = PaymentSetting::where('status', 1)->get();
        $response      = CartStorage::getCart();
        $hazmatCost = CartStorage::hazmatCost();

        extract($response);
        
        if (count($cart) === 0) {
            return redirect()->route('cart');
        }

        return view('front.order.checkout', compact('countries', 'shippingAddresses', 'billingAddresses', 'cart', 'products', 'paymentOption', 'displayCoupon','states', 'hazmatCost'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|min:6|exists:coupons,code'
        ]);

        try {

            $coupon = Coupon::where('code', $request->coupon_code)->firstOrFail();

            $cart = CartStorage::getCart();
            $preDiscountGrandTotal = CartStorage::grandTotalCalculate();

            $codes = array_column(Arr::wrap($request->input('discounts')), 'code');
            $codes[] = $coupon->code;

            $coupons = Coupon::with('products')->whereIn('code', $codes)->get();

            $productsInCart = collect(array_values($cart['cart']))->pluck('attributes')->pluck('product_id')->toArray();
            $productsCoupons = $coupons->pluck('products')->flatten()->pluck('id')->toArray();
            $productsCouponOrder = array_values(array_diff($productsInCart, $productsCoupons));

            if (! $coupon->is_valid) {
                throw new \Exception(__('messages.invalid_coupon'));
            }

            if (! Coupon::canApplyCoupon($coupon, array_column(Arr::wrap($request->input('discounts')), 'code'))) {
                throw new \Exception('Coupon could not be applied');
            }

            $mappedCoupons = collect();

            $discount = $coupons->map(function($coupon) use ($productsCouponOrder, &$mappedCoupons) {
                
                if (! $coupon->is_valid) {
                    return 0;
                }

                $discount = $coupon->getDiscountValue($productsCouponOrder);

                $mappedCoupons->push([
                    'discount' => number_format($discount, 2),
                    'discount_value' => $discount,
                    'code' => $coupon->code,
                ]);

                return $discount;

            })->sum();

            $grandTotal = $preDiscountGrandTotal['grandTotal'] - $discount;

            $response = [
                'error' => '',
                'success' => true,
                'grandTotal' => $grandTotal,
                'code' => $coupon->code,
                'discount_value' => round($discount, 2),
                'discount' => number_format($discount, 2),
                'discounts' => $mappedCoupons
            ];

            if ($request->input('email') === null && ! Auth::guard('web')->check()) {
                return response()->json($response);
            }

            $user = Auth::guard('web')->check()
                ? Auth::guard('web')->user()
                : User::where('email', $request->email)->get()->first();   

            if ($coupon->isValidForUser($user) !== true) {
                throw new \Exception(__('messages.invalid_coupon'));
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'error'      => __('messages.invalid_coupon'),
                'success'    => false,
                'grandTotal' => 0,
                'discount'   => 0,
            ]);
        }
    }

    public function confirmOrder(Request $request)
    {
        if($request->payment_option == 2) {
            $request->validate([
                'card_number' => 'required',
                'expiry_month' => 'required',
                'expiry_year' => 'required',
            ]);
        }

        $request->validate([
            'purchase_order' => ['nullable', 'alpha_num', 'max:20'],
        ]);

        $cart = CartStorage::getCart();

        $discountsApplied = json_decode($request->input('discounts'), true);

        $couponsAppliedCodes = array_column($discountsApplied, 'code');

        $coupons = Coupon::whereIn('code', $couponsAppliedCodes)->with('products')->get()->reject(function($coupon) use ($couponsAppliedCodes) {
            if (! $coupon->is_valid) {
                return true;
            }

            return ! Coupon::canApplyCoupon($coupon, $couponsAppliedCodes);
        });

        $productsInCart = collect(array_values($cart['cart']))->pluck('attributes')->pluck('product_id')->toArray();
        $productsCoupons = $coupons->pluck('products')->flatten()->pluck('id')->toArray();
        $productsCouponOrder = array_values(array_diff($productsInCart, $productsCoupons));

        $totalDiscount = $coupons->map(function($coupon) use ($productsCouponOrder) {
            if (! $coupon->is_valid) {
                return 0;
            }
            return $coupon->getDiscountValue($productsCouponOrder);
        })->sum();

        try {

            return DB::transaction(function () use ($request, $coupons, $totalDiscount) {

                $cartData = CartStorage::getCart();
                extract($cartData);

                if ($request->is_valid_coupon) {
                    $coupon = Coupon::where('code', $request->coupon_code)->first();
                }

                $grandTotal = 0;

                foreach ($cart as $value) {

                    $productSkusKey = '';

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

                    $productSku = $productSkusKey !== '' && isset($product->productSkus[$productSkusKey]) 
                        ? $product->productSkus[$productSkusKey] 
                        : null;

                    // Product Quantity Count
                    if (! empty($product->inventory_tracking)) {
                        if (! empty($productSku->quantity) && ! empty($product->inventory_tracking_by)) {
                            $id                 = $productSku->id;
                            $productSkuIds[$id] = ! empty($productSkuIds[$id]) ? $productSkuIds[$id] + $value['quantity'] : $value['quantity'];
                            if ($productSkuIds[$id] > $productSku->quantity) {
                                $redirectURL = true;
                            }
                        } else if (! empty($product->quantity)) {
                            $productIds[$product->id] = ! empty($productIds[$product->id]) ? $productIds[$product->id] + $value['quantity'] : $value['quantity'];
                            if ($productIds[$product->id] > $product->quantity) {
                                $redirectURL = true;
                            }
                        }
                        if (isset($redirectURL)) {
                            return response()->json([
                                'redirect_url' => route('cart'),
                                'status'       => "success",
                            ]);
                        }
                    }

                    if (!isset($order)) {
                        $order = ['product_id' => $product->id];
                    }

                    $price = $productSkusKey !== '' && isset($productSku)
                        ? $product->productSkus[$productSkusKey]->price
                        : $product->price;
                    
                    // $price      = isset($productSku) ? $productSku->price : $product->price;
                    $totalPrice = $price * $value['quantity'];
                    $grandTotal = $grandTotal + $totalPrice;

                    $variations = [];

                    if (! empty($productSku)) {
                        foreach ($productSku->productSkuValues as $row) {
                            $variations[$row->attribute->name] = $row->attributeOptions->option;
                        }
                    }

                    $coupon = isset($coupons) && ! $coupons->isEmpty()
                        ? $product->coupons()->whereIn('coupon_id', $coupons->pluck('id')->toArray())->first()
                        : null;

                    $orderItem[]   = [
                        'product_id'      => $product->id,
                        'product_sku_id'  => ! empty($productSku) ? $productSku->id : 0,
                        //'user_id' => $user->id,
                        'quantity'        => $value['quantity'],
                        'price'           => $price,
                        'discount'        => isset($coupon) && $coupon instanceof Coupon && ! $coupon->products->isEmpty()
                            ? $coupon->getDiscountValueForProduct($product)
                            : 0,

                        'variations'      => $variations,
                        'order_status_id' => config('constants.DEFAULT_ORDER_STATUS'),
                    ];
                }

                $discountApplied = array_sum(array_column($orderItem, 'discount'));

                $totalProductsWithoutDiscount = collect($orderItem)->where('discount', 0)->count();

                if ($totalDiscount != $discountApplied && $totalProductsWithoutDiscount > 0) {

                    foreach ($orderItem as &$item) {
                        if ($item['discount'] != 0) {
                            continue;
                        }

                        $discountLeft = abs($totalDiscount - $discountApplied);

                        $item['discount'] = $discountLeft / $totalProductsWithoutDiscount;
                    }
                }

                $shippingCost = $request->session()->get('shipping_cost');
                $shippingOptionChosen = $request->session()->get('shipping_option_chosen');

                $shippingDetails = $request->session()->get('shipping_details');
                $billingDetails  = $request->session()->get('billing_details');

                if (Auth::guard('web')->check()) {
                    $user = Auth::guard('web')->user();
                } else {
                    $user = User::where('email', $shippingDetails['email'])->first();
                }
                
                $guestUser = false;
                
                if (! empty($shippingDetails['login_type']) && $shippingDetails['login_type'] == 'guest') {
                    $guestUser = true;
                }

                if ($shippingDetails['address_option'] == 0) {
                    $address = UserAddress::find($shippingDetails['address']);
                } else {
                    if (! empty($shippingDetails['new_customer'])) {

                        if (! empty($user)) {
                            $user->update($shippingDetails);
                        } else {
                            $shippingDetails['password'] = Hash::make($request->get('password'));
                            event(new Registered($user = User::create($shippingDetails)));
                            try {
                                $placeHolders = [
                                    '[Customer Name]'  => $user->name ?? '',
                                    '[Customer Email]' => $user->email ?? '',
                                ];
                                Email::sendEmail('customer.registration', $placeHolders, $user->email ?? '');
                            } catch (Exception $e) {
                                
                            }
                        }

                    } else if (empty($user)) {
                        $user = User::create([
                            'first_name' => 'Guest' . rand(1, 999999),
                            'email'      => $shippingDetails['email'],
                            'is_guest'   => 1,
                            'otp'        => rand(100000, 999999),
                        ]);
                    }

                    if (! empty($user)) {
                        $shippingAddressWhere = $shippingDetails;
                        unset($shippingAddressWhere['_token']);
                        unset($shippingAddressWhere['address']);
                        unset($shippingAddressWhere['address_option']);
                        unset($shippingAddressWhere['login_type']);
                        unset($shippingAddressWhere['billing_address']);
                        unset($shippingAddressWhere['new_customer']);
                        unset($shippingAddressWhere['password']);
                        unset($shippingAddressWhere['confirm_password']);
                        $shippingAddressWhere['billing_type'] = 1;
                        $address = $user->userAddress()->updateOrCreate($shippingAddressWhere, $shippingDetails);
                    }
                }

                if (empty($shippingDetails['billing_address'])) {
                    if (! empty($billingDetails['billing_address_option'])) {
                        $billingDetails['billing_type'] = 0;
                        $billingAddressWhere            = $billingDetails;
                        unset($billingAddressWhere['_token']);
                        unset($billingAddressWhere['billing_address_id']);
                        unset($billingAddressWhere['billing_address_option']);
                        unset($billingAddressWhere['billing_type']);
                        $billingAddress = $user->userAddress()->updateOrCreate($billingAddressWhere, $billingDetails);
                    } else {
                        $billingAddress = UserAddress::find($billingDetails['billing_address_id']);
                    }
                }

                $shippingSetting = ShippingSetting::shippingCalculation($request, $user);
                
                $shippingTotal   = $shippingCost ?? ($shippingSetting && $shippingSetting['shipping_cost'] ? $shippingSetting['shipping_cost'] : 0);

                if (! is_numeric($shippingTotal)) {
                    $shippingTotal = (int) $shippingTotal;
                }

                if (empty($address->email)) {
                    $address->email = $user->email;
                }
                if (! empty($address->state_id)) {
                    $stateName = $address->state->name;
                } else {
                    $stateName = $address->state_name ?? '';
                }

                if (! empty($billingAddress)) {
                    if (! empty($billingAddress->state_id)) {
                        $billingState = $billingAddress->state->name;
                    } else {
                        $billingState = $billingAddress->state_name ?? '';
                    }
                }

                $orderItem = array_map(function ($row) use ($user, $guestUser) {
                    return $row + ['user_id' => $user->id, 'is_guest' => ! empty($guestUser) ? '1' : '0'];
                }, $orderItem);

                // Hazmat fees should not be applied if using your own shipping or in-store pickup
                $hazmatShippingCost = ($request->shipping_setting_id == 'own_shipping' || $request->shipping_quotes =='pickup-from-store_0') ? 0 : CartStorage::hazmatCost();

                $order += [
                    // "invoice_no"            => rand(100000000, 999999999),
                    'user_id'               => $user->id,
                    'is_guest'              => ! empty($guestUser) ? '1' : '0',
                    'first_name'            => $address->first_name ?? '',
                    'last_name'             => $address->last_name ?? '',
                    'email'                 => $address->email ?? '',
                    'mobile_no'             => $address->mobile_no ?? '',
                    'shipping_address_1'    => $address->address_line_1,
                    'shipping_address_2'    => $address->address_line_2,
                    'shipping_address_name' => ! empty($address->address_name) ? $address->address_name : '',
                    'shipping_city'         => $address->city_name ?? '',
                    'shipping_state'        => $stateName ?? '',
                    'shipping_country'      => $address->country->name ?? '',
                    'shipping_postcode'     => $address->zip_code ?? '',
                    'purchase_order'        => $request->input('purchase_order'),
                    'billing_first_name'    => ! empty($billingAddress) ? $billingAddress->first_name : $address->first_name,
                    'billing_last_name'     => ! empty($billingAddress) ? $billingAddress->last_name : $address->last_name,
                    'billing_email'         => ! empty($billingAddress) ? $billingAddress->email : $address->email,
                    'billing_mobile_no'     => ! empty($billingAddress) ? $billingAddress->mobile_no : $address->mobile_no,
                    'billing_address_1'     => ! empty($billingAddress) ? $billingAddress->address_line_1 : $address->address_line_1,
                    'billing_address_2'     => ! empty($billingAddress) ? $billingAddress->address_line_2 : $address->address_line_2,
                    'billing_address_name'  => ! empty($billingAddress->address_name) ? $billingAddress->address_name : $address->address_name,
                    'billing_city'          => ! empty($billingAddress) ? $billingAddress->city_name : $address->city_name,
                    'billing_state'         => ! empty($billingAddress) ? $billingState : $stateName,
                    'billing_country'       => ! empty($billingAddress) ? $billingAddress->country->name : $address->country->name,
                    'billing_postcode'      => ! empty($billingAddress) ? $billingAddress->zip_code : $address->zip_code,
                    // 'payment_setting_id'    => $payment->id,
                    'order_status_id'       => config('constants.DEFAULT_ORDER_STATUS'),
                    'currency_code'         => setting('currency_code'),
                    'order_total'           => (($grandTotal + $shippingTotal + $hazmatShippingCost) - $totalDiscount) ?? 0,
                    'order_sub_total'       => $grandTotal ?? 0,
                    'order_discount'        => $totalDiscount ?? 0,
                    'shipping_quotes'       => $request->shipping_quotes ?? $request->shipping_setting_id,
                    'hazmat_shipping_cost'  => $hazmatShippingCost
                ];

                if ($request->shipping_setting_id == 'own_shipping') {
                    $ownShipping = [
                        'shipping_service_name'   => $request->shipping_service_name ?? 'UPS',
                        'shipping_account_number' => $request->shipping_account_number ?? null,
                        'shipping_note'           => $request->shipping_note ?? null,
                    ];
                    $order += $ownShipping;
                    $user->update($ownShipping);
                } elseif($request->shipping_quotes =='pickup-from-store_0'){
                    $order += [
                        'shipping_service_name' => $shippingOptionChosen ?? null,
                        'shipping_setting_id'   => intval($request->shipping_setting_id),
                        'shipping_total'        => $shippingCost ?? ($shippingSetting && $shippingSetting['shipping_cost'] ? $shippingSetting['shipping_cost'] : 0),
                        'store_address'         => isset($shippingSetting['pick_from_store']) ? $shippingSetting['store_address'] : 'Pickup at our store at 12336 Emerson Dr. Brighton, MI 48116, USA',
                    ];
                } else {
                    $order += [
                        'shipping_service_name' => $shippingOptionChosen ?? null,
                        'shipping_setting_id'   => intval($request->shipping_setting_id),
                        'shipping_total'        => $shippingCost ?? ($shippingSetting && $shippingSetting['shipping_cost'] ? $shippingSetting['shipping_cost'] : 0),
                        'store_address'         => isset($shippingSetting['pick_from_store']) ? $shippingSetting['store_address'] : '',
                    ];
                }

                $order = Order::create($order);
                $orderItem = $order->orderItems()->createMany($orderItem);

                //update product quamtity
                if (! empty($orderItem)) {
                    foreach ($orderItem as $key => $value) {
                        if (! empty($value->product_sku_id) && ! empty($productSkuIds[$value->product_sku_id])) {
                            ProductSku::where('id', $value->product_sku_id)->decrement('quantity', $productSkuIds[$value->product_sku_id]);
                        } else if (! empty($productIds[$value->product_id])) {
                            Product::where('id', $value->product_id)->decrement('quantity', $productIds[$value->product_id]);
                        }
                    }
                }

                if (isset($request->payment_option)) {
                    $payment       = PaymentSetting::find($request->payment_option);
                    $transactionId = $order->id;

                    if ($payment->isFree == 1) {
                        $paymentSuccess = true;
                    } else {
                        $gateway = Omnipay::create('AuthorizeNetApi_Api');
                        if ($payment->value->mode) {
                            $paymentSetting = $payment->value->live;
                        } else {
                            $paymentSetting = $payment->value->sandbox;
                            $gateway->setTestMode(true);
                        }

                        $gateway->setAuthName($paymentSetting->login_id);
                        $gateway->setTransactionKey($paymentSetting->transaction_key);

                        $creditCard = new \Omnipay\Common\CreditCard([
                            // Swiped tracks can be provided instead, if the card is present.
                            'number'      => str_replace(' ', '', $request->card_number),
                            'expiryMonth' => $request->expiry_month,
                            'expiryYear'  => $request->expiry_year,
                            'cvv'         => $request->input('cvv', '000'),
                            'billingAddress1'=> ! empty($billingAddress) ? $billingAddress->address_line_1 : $address->address_line_1,
                            'billingAddress2'=> ! empty($billingAddress) ? $billingAddress->address_line_2 : $address->address_line_2,
                            'billingCity'=> ! empty($billingAddress) ? $billingAddress->city_name : $address->city_name,
                            'billingPostcode'=> ! empty($billingAddress) ? $billingAddress->zip_code : $address->zip_code,
                            'billingState'=> ! empty($billingAddress) ? $billingState : $stateName,
                            'billingCountry'=> ! empty($billingAddress) ? $billingAddress->country->name : $address->country->name,
                            'billingPhone'=> ! empty($billingAddress) ? $billingAddress->mobile_no : $address->mobile_no,
                            'company'=> substr(trim(! empty($billingAddress->address_name) ? $billingAddress->address_name : $address->address_name), 0, 30),
                            'email'=> ! empty($billingAddress) ? $billingAddress->email : $address->email,
                            'firstName'=> ! empty($billingAddress) ? $billingAddress->first_name : $address->first_name,
                            'lastName'=> ! empty($billingAddress) ? $billingAddress->last_name : $address->last_name,
                            'shippingAddress1'=>$address->address_line_1,
                            'shippingAddress2'=>$address->address_line_2,
                            'shippingCity'=>$address->city_name ?? '',
                            'shippingPostcode'=>$address->zip_code ?? '',
                            'shippingState'=>$stateName ?? '',
                            'shippingCountry'=>$address->country->name ?? '',
                            'shippingPhone'=>$address->mobile_no ?? '',
                            'shippingTitle' => ! empty($address->address_name) ? $address->address_name : '',
                            // Billing and shipping details can be added here.
                        ]);

                        $response = $gateway->purchase([
                            'amount'        => $order->order_total,
                            'currency'      => 'USD',
                            'invoiceNumber' => $transactionId,
                            'card'          => $creditCard,
                            'customerId'    => $user->id,
                            'customerType'  => 'individual',
                        ])->send();

                        if ($response->isSuccessful()) {
                            $paymentSuccess = 1;
                        } else {
                            $paymentError = $response->getMessage();
                        }
                        // $responseData = $response->getData();
                        // if (! empty($responseData['messages']['resultCode']) && trim($responseData['messages']['resultCode']) == 'Ok' && empty($responseData['transactionResponse']['errors'])) {
                        //     $paymentSuccess = 1;
                        // }
                        // if (! empty($responseData['transactionResponse']['errors'])) {
                        //     $paymentError = $responseData['transactionResponse']['errors'][0]['errorText'];
                        // }
                        //  else {

                        // }
                    }

                    if(! empty($response)){
                        if(empty($response->getData())) {
                            $responseData = 'Authorize.net could not accept the order data.';
                        } else {
                            $responseData = $response->getData();
                        }
                    } else {
                        $responseData = [];
                    }

                    //$paymentSuccess= true;
                    $order->payment_setting_id     = $payment->id;
                    $order->payment_status         = ! empty($response) ? $response->isSuccessful() : 0;
                    $order->payment_status_code    = ! empty($response) ? $response->getCode() : 0;
                    $order->payment_message        = ! empty($response) ? $response->getMessage() : '';
                    $order->payment_transaction_id = ! empty($response) ? $response->getTransactionReference() : '';
                    $order->payment_response       = json_encode($responseData);
                    $order->invoice_no             = $order->id;
                    $order->save();
                    if (isset($paymentSuccess)) {
                        // $address = UserAddress::with(['country', 'state'])->find($address->id);
                        if (isset($coupons) && ! $coupons->isEmpty()) {
                            foreach ($coupons as $coupon) {
                                $user->coupons()->attach($coupon->id, [
                                    'order_id' => $order->id,
                                ]);
                            }
                        }

                        $cartSessionId = CartStorage::getSession();
                        Cart::session($cartSessionId)->clear();

                        $request->session()->put('order_id', $order->id);
                        if (! empty($shippingDetails['new_customer'])) {
                            $this->guard()->login($user);
                        }

                        // order confirmation email
                        $order = Order::getOrder($order->id);
                        try {
                            $confirm      = 1;
                            $placeHolders = [
                                "[Customer Name]" => $order->name,
                                "[Order ID]"      => $order->id,
                                "[Product Table]" => view('emails.customer.order_details', compact('order', 'confirm')),
                            ];

                            Email::sendEmail('customer.order_confirm', $placeHolders, $order->email ?? '');
                            // Email to Admin
                            if (! empty(setting('admin_notification_email'))) {
                                Email::sendEmail('admin.order_confirm', $placeHolders, setting('admin_notification_email'));
                            }
                        } catch (\Exception $e) {
                        }
                        
                        return response()->json([
                            'redirect_url' => route('place_order'),
                            'message'      => "successfully",
                            'status'       => "success",
                        ]);
                    }

                    return response()->json([
                        'message' => $paymentError ?? "Payment has failed.",
                        'status'  => "error",
                    ]);
                }
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status'  => "error",
            ]);
        }
    }

    public function placedOrder(Request $request)
    {
        $orderId = $request->session()->get('order_id');
        $request->session()->forget('order_id');
        if (! empty($orderId)) {
            $order = Order::getOrder($orderId);
            return view('front.order.place_order', compact('order'));
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * order cancel.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderCancel(Request $request)
    {
        try {
            if (! empty($request->order_id)) {
                return DB::transaction(function () use ($request) {
                    $orderItem = OrderItem::where('id', $request->order_id)->where('user_id', Auth::guard('web')->user()->id)->firstOrFail();
                    if ($orderItem->order_status_id <= config('constants.ORDER_STATUS.SHIPPED')) {
                        if ($orderItem->update(['order_status_id' => config('constants.ORDER_STATUS.DECLINED_CANCELLED'), 'comment' => $request->comment ?? ''])) {
                            $order        = Order::getOrder($orderItem->order_id, $orderItem->id);
                            $refundAmount = $order->UpdateRefundAmount();
                            $order->update(['refund_total' => $refundAmount, 'order_status_id' => config('constants.ORDER_STATUS.DECLINED_CANCELLED')]);
                            $orderItem = $order->orderItems->first();

                            if (! empty($orderItem->product->inventory_tracking) && ! empty($orderItem->product->inventory_tracking_by) && ! empty($orderItem->product_sku_id)) {
                                $product = $orderItem->productSku()->where('id', $orderItem->product_sku_id)->increment('quantity', $orderItem->quantity);
                            } else if (! empty($orderItem->product->inventory_tracking)) {
                                $product = $orderItem->product()->where('id', $orderItem->product_id)->increment('quantity', $orderItem->quantity);
                            }

                            // Email to User
                            $cancelled    = 1;
                            $placeHolders = [
                                "[Customer Name]" => $order->name,
                                "[Order ID]"      => $order->id,
                                "[Product Table]" => view('emails.customer.order_details', compact('order', 'cancelled')),
                            ];
                            Email::sendEmail('customer.cancel_order_from_user', $placeHolders, $order->email ?? '');

                            // Email to Admin
                            if (! empty(setting('admin_notification_email'))) {
                                $comment                            = $order->orderItems->first();
                                $placeHolders["[Cancelled Reason]"] = $comment->comment ?? '-';
                                Email::sendEmail('admin.cancel_order_from_user', $placeHolders, setting('admin_notification_email'));
                            }

                            Session::flash('success', __('messages.your_order_is_cancelled_successfully'));
                        }
                    } else {
                        Session::flash('error', __('messages.you_should_not_cancel_your_order_after_your_order_is_completed'));
                    }

                    return redirect()->route('my_order');
                });
            }
        } catch (Exception $e) {

            Session::flash('error', __('messages.you_should_not_cancel_your_order_after_your_order_is_completed'));

            return redirect()->route('my_order');
        }

    }

}
