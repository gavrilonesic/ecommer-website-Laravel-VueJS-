<?php

namespace App\Http\Controllers;

use App\Country;
use App\Order;
use App\OrderItem;
use App\Product;
use App\RedirectUrl;
use App\State;
use App\User;
use App\UserAddress;
use Carbon\Carbon;
use Exception;
use Hash;
use Log;
use Str;
use App\PaymentSetting;
use Omnipay\Omnipay;

class ImportLiveController extends Controller
{
    public function users()
    {
        dd();
        $filePath       = storage_path('app/public/import/customers.csv');
        $file           = fopen($filePath, "r");
        $i              = 0;
        $array          = [];
        $userErrorArray = [];
        $userBigId      = [];
        $userFields     = ["customer id" => "big_id", "first name" => "first_name", "last name" => "last_name", "email" => "email", "phone" => "mobile_no", "notes" => "shipping_note", "date joined" => "created_at"];
        while (($data = fgetcsv($file, 1000, ",")) !== false) {
            if (!empty($data) && $i == 0) {
                foreach ($data as $key => $value) {
                    $array[strtolower(trim($value))] = trim($key);
                }
            } else {
                foreach ($userFields as $key => $value) {
                    if (!empty($data[$array[$key]])) {
                        $user[$value] = $data[$array[$key]];
                    } else {
                        $user[$value] = null;
                    }
                    if ($key == 'date joined') {
                        $date         = str_replace('/', '-', $data[$array[$key]]);
                        $user[$value] = Carbon::createFromFormat('m-d-Y', "$date");
                    }
                }
                $user['password'] = Hash::make(Str::random(8));
                // $user['password']   = Str::random(8);
                $user['id']         = $user['big_id'];
                $user['updated_at'] = Carbon::now();
                try {

                    if (!in_array($user['big_id'], $userBigId)) {
                        $userId      = User::insert($user);
                        $userBigId[] = $user['big_id'];
                    }
                } catch (Exception $e) {
                    report($e);
                    Log::notice($i);
                    $userErrorArray[] = $user;
                }
            }
            $i++;
        }
        Log::notice(json_encode($userErrorArray));
    }
    public function userAddresses()
    {
        dd();
        $filePath = storage_path('app/public/import/customers-addresses.csv');

        $file                   = fopen($filePath, "r");
        $i                      = 0;
        $array                  = [];
        $usersAddressErrorArray = [];
        $ciscnameArray          = [];
        $userBigId              = [];
        $addressFields          = ["customer id" => "user_id", "address id" => "big_id", "address name" => "address_name", "address company" => "company_name", "address first name" => "first_name", "address last name" => "last_name", "address line 1" => "address_line_1", "address line 2" => "address_line_2", "country" => "country_id", "state/province" => "state_id", "city/suburb" => "city_name", "zip/postcode" => "zip_code", "building type" => "address_type", "address phone" => "mobile_no"];
        while (($data = fgetcsv($file, 1000, ",")) !== false) {
            if (!empty($data) && $i == 0) {
                foreach ($data as $key => $value) {
                    $array[strtolower(trim($value))] = trim($key);
                }
            } else {
                if (!empty($data[$array['address name']])) {
                    foreach ($addressFields as $key => $value) {
                        if (!empty($data[$array[$key]])) {
                            $usersAddress[$value] = $data[$array[$key]];
                        } else {
                            $usersAddress[$value] = null;
                        }
                        if ($key == 'building type') {
                            if ($data[$array[$key]] == 'residential') {
                                $usersAddress[$value] = 0;
                            }
                        }
                        if ($key == 'country') {
                            $cname                      = $data[$array[$key]];
                            $usersAddress['country_id'] = Country::where('name', $data[$array[$key]])->pluck('id')->first();
                            if (empty($usersAddress['country_id'])) {
                                $ciscnameArray[$i]['country'] = $cname;
                            }
                        }
                        if ($key == 'address company') {
                            if (!empty($usersAddress['company_name'])) {
                                $usersAddress['address_name'] = $data[$array[$key]];
                            }
                        }
                        if ($key == 'state/province') {
                            $sname                    = $data[$array[$key]];
                            $usersAddress['state_id'] = State::where('name', $data[$array[$key]])->where('country_id', $usersAddress['country_id'])->pluck('id')->first();
                            if (empty($usersAddress['state_id'])) {
                                $ciscnameArray[$i]['state']     = $sname;
                                $usersAddress[$i]['state_name'] = $sname;
                                unset($usersAddress[$i]['state_id']);
                            }
                        }
                    }
                    $usersAddress['primary_address'] = 1;
                    $usersAddress['id']              = $usersAddress['big_id'];
                    $usersAddress['created_at']      = Carbon::now();
                    $usersAddress['updated_at']      = Carbon::now();
                    try {
                        if (!empty($usersAddress['address_name'])) {
                            $userAddressId = UserAddress::create($usersAddress);
                        }
                    } catch (Exception $e) {
                        // dd($e);
                        // report($e);
                        Log::notice($i . ':' . $e->getMessage());
                        $usersAddressErrorArray[] = $usersAddress;
                    }
                }
            }
            $i++;
        }
        Log::notice(json_encode($usersAddressErrorArray));
        Log::notice(json_encode($ciscnameArray));
    }
    public function userAddressesCompany()
    {
        dd();
        $filePath = storage_path('app/public/import/customers-addresses_all.csv');

        $file                   = fopen($filePath, "r");
        $i                      = 0;
        $array                  = [];
        $usersAddressErrorArray = [];
        $usersAddressComp       = [];
        $addressFields          = ["customer id" => "user_id", "address id" => "big_id", "address name" => "address_name", "address company" => "company_name"];
        while (($data = fgetcsv($file, 1000, ",")) !== false) {
            if (!empty($data) && $i == 0) {
                foreach ($data as $key => $value) {
                    $array[strtolower(trim($value))] = trim($key);
                }
            } else {
                if (!empty($data[$array['address name']])) {
                    foreach ($addressFields as $key => $value) {
                        if (!empty($data[$array[$key]])) {
                            $usersAddress[$value] = $data[$array[$key]];
                        } else {
                            $usersAddress[$value] = null;
                        }
                        if ($key == 'address company') {
                            if (!empty($usersAddress['company_name'])) {
                                $usersAddressComp['address_name'] = $data[$array[$key]];
                            }
                        }
                    }
                    $big_id  = $usersAddress['big_id'];
                    $user_id = $usersAddress['user_id'];
                    // dd($usersAddressComp);
                    try {
                        if (!empty($usersAddress['address_name'])) {
                            $userAddressId = UserAddress::where(['user_id' => $user_id, 'big_id' => $big_id])->update($usersAddressComp);
                        }
                    } catch (Exception $e) {
                        // dd($e);
                        // report($e);
                        Log::notice($i . ':' . $e->getMessage());
                        // $usersAddressErrorArray[] = $usersAddress;
                    }
                }
            }
            $i++;
        }
    }

    public function orders()
    {
        dd();
        $order       = [];
        $orederItems = [];
        $user        = [];
        $filePath    = $filePath    = storage_path('app/public/import/customers-orders.csv');
        $file        = fopen($filePath, "r");
        $i           = 0;
        $orderFields = ["order id" => "big_id", "order date" => "date", "order time" => "time", "subtotal (inc tax)" => "order_sub_total_tax", "subtotal (ex tax)" => "order_sub_total", "tax total" => "tax_total", "shipping cost (inc tax)" => "shipping_total_tax", "shipping cost (ex tax)" => "shipping_total", "handling cost (inc tax)" => "handling_fees_total_tax", "handling cost (ex tax)" => "handling_fees_total", "coupon value" => "order_discount", "order total (inc tax)" => "order_total_tax", "order total (ex tax)" => "order_total", "refund amount" => "refund_total", "customer id" => "user_id", "customer name" => "cust_name", "customer email" => "cust_email", "customer phone" => "cust_phone", "customer message" => "shipping_note", "billing first name" => "billing_first_name", "billing last name" => "billing_last_name", "billing company" => "billing_address_name", "billing street 1" => "billing_address_1", "billing street 2" => "billing_address_2", "billing suburb" => "billing_city", "billing state" => "billing_state", "billing zip" => "billing_postcode", "billing country" => "billing_country", "billing phone" => "billing_mobile_no", "billing email" => "billing_email", "shipping first name" => "first_name", "shipping last name" => "last_name", "shipping company" => "shipping_address_name", "shipping street 1" => "shipping_address_1", "shipping street 2" => "shipping_address_2", "shipping suburb" => "shipping_city", "shipping state" => "shipping_state", "shipping zip" => "shipping_postcode", "shipping country" => "shipping_country", "shipping phone" => "mobile_no", "shipping email" => "email", "product id" => "product_id", "transaction id" => "trans_id", "ship method" => "shipping_quotes"];
        // dd($orderFields);
        $orederItemsArray = ["order status" => "order_status_id", "coupon value" => "discount", "product id" => "product_id", "product qty" => "quantity", "product variation details" => "variations", "product unit price" => "price"];
        $statusArray      = ["Completed" => 5, "Shipped" => 4, "Cancelled" => 6, "Refunded" => 7, "Awaiting Fulfillment" => 1, "Awaiting Payment" => 1, "Manual Verification Required" => 1, "Awaiting Shipment" => 2, "Partially Refunded" => 7];
        $shippingArray    = [
            'Flat Rate Per Order'                 => 'flat_rate',
            'Pickup At Warehouse In Brighton, MI' => 'pickup_in_store',
        ];
        while (($data = fgetcsv($file, '', ",")) !== false) {
            if (!empty($data) && $i == 0) {
                foreach ($data as $key => $value) {
                    $array[strtolower(trim($value))] = trim($key);
                }
                // dd($array);
            } else {
                $order       = [];
                $orederItems = [];
                $user        = [];
                foreach ($orderFields as $key => $value) {
                    if (!empty($data[$array[$key]])) {
                        $order[$value] = $data[$array[$key]];
                    }
                }
                foreach ($orederItemsArray as $key => $value) {
                    if (!empty($data[$array[$key]])) {
                        $orederItems[$value] = $data[$array[$key]];
                    }
                }
                $statusId                       = $statusArray[$orederItems['order_status_id']];
                $orederItems['order_status_id'] = $order['order_status_id'] = $statusId;
                $existingOrder                  = Order::where('big_id', $order['big_id'])->first();
                if (!empty($existingOrder)) {
                    $this->__orederItems($orederItems, $existingOrder);
                } else {
                    $date                = str_replace('/', '-', $order['date']);
                    $time                = $order['time'];
                    $order['created_at'] = $order['updated_at'] = Carbon::createFromFormat('m-d-Y H:i:s', "$date $time");
                    // dd($order['created_at']);
                    if (empty($order['order_discount'])) {
                        $order['order_discount'] = 0;
                    }
                    if (empty($order['tax_total'])) {
                        $order['tax_total'] = 0;
                    }
                    unset($order['date']);
                    unset($order['time']);
                    unset($order['order_sub_total_tax']);
                    unset($order['shipping_total_tax']);
                    unset($order['handling_fees_total_tax']);
                    unset($order['order_total_tax']);
                    if (!empty($order['trans_id'])) {
                        $transId = $order['trans_id'];
                    } else {
                        $transId = null;
                    }
                    unset($order['trans_id']);
                    $order['big_data']            = json_encode([]);
                    $order['invoice_no']          = $refId          = rand(100000000, 999999999);
                    $order['shipping_setting_id'] = '';
                    if (!empty($order['shipping_quotes'])) {
                        if (!empty($shippingArray[$order['shipping_quotes']])) {
                            $oldShippingQuotes        = $order['shipping_quotes'];
                            $order['shipping_quotes'] = $shippingArray[$order['shipping_quotes']];

                        } else {
                            $order['shipping_quotes'] = 'truck_freight_shipping';
                        }

                    } else {
                        $order['shipping_quotes'] = 'truck_freight_shipping';
                    }

                    if ($order['shipping_quotes'] == 'pickup_in_store') {
                        $order['shipping_total'] = 0;
                        $order['store_address']  = $oldShippingQuotes;
                    }

                    $order['payment_setting_id'] = 2;
                    $order['currency_code']      = "USD";
                    $order['payment_response']   = '{"transactionResponse":{"responseCode":"1","authCode":"","avsResultCode":"Y","cvvResultCode":"P","cavvResultCode":"2","transId":"' . $transId . '","refTransID":"","transHash":"","testRequest":"0","accountNumber":"","accountType":"","messages":[{"code":"1","description":"This transaction has been approved."}],"transHashSha2":"","SupplementalDataQualificationIndicator":0},"refId":"' . $refId . '","messages":{"resultCode":"Ok","message":[{"code":"I00001","text":"Successful."}]}}';
                    // dd($order);
                    if (!empty($order['cust_email'])) {
                        $email = $order['cust_email'];
                    } else {
                        $email = $order['email'] ?? $order['billing_email'];
                    }
                    unset($order['cust_email']);
                    unset($order['cust_name']);
                    unset($order['cust_phone']);
                    $order['is_guest'] = 0;
                    if (empty($order['user_id'])) {
                        $order['is_guest'] = 1;
                    }
                    if (!empty($order['user_id'])) {
                        $user = User::where('big_id', $order['user_id'])->first();
                        // dd($user);
                    }
                    if (empty($user)) {
                        $user = User::where('email', $email)->first();
                    }
                    if (empty($user)) {
                        $user = User::create([
                            'first_name' => 'Guest' . rand(1, 999999),
                            'email'      => $email,
                            'is_guest'   => 1,
                            'otp'        => rand(100000, 999999),
                        ]);
                    }

                    if (!empty($order['product_id'])) {
                        $product = Product::where('big_id', $order['product_id'])->withTrashed()->first();
                    }
                    if (!empty($product)) {
                        $order['id']         = $order['big_id'];
                        $order['user_id']    = $user->id;
                        $order['product_id'] = $product->id;
                        $existingOrder       = Order::create($order);
                        // unset($existingOrder['big_data']);
                        // dd($order);
                        $this->__orederItems($orederItems, $existingOrder);
                    } else {
                        Log::info($order);
                    }
                }
            }
            $i++;
        }

    }
    public function __orederItems($orederItems, $existingOrder)
    {
        // $orderStatus = OrderStatus::where('name', 'like', $orederItems['order_status_id'])->first();
        if (!empty($orederItems['variations'])) {
            $varientArray = explode(':', $orederItems['variations']);
            if (count($varientArray) == 2) {
                $varient[$varientArray[0]] = $varientArray[1];
                $orederItems['variations'] = $varient;
            } else {
                $orederItems['variations'] = [];
            }

        } else {
            $orederItems['variations'] = [];
        }
        if (!empty($orederItems['product_id'])) {
            $product = Product::where('big_id', $orederItems['product_id'])->withTrashed()->first();
        }
        if (!empty($product)) {
            $orederItems['product_id'] = $product->id;
            $orederItems['user_id']    = $existingOrder->user_id;
            $orederItems['order_id']   = $existingOrder->id;
            $orederItems['is_guest']   = $existingOrder->is_guest;
            OrderItem::create($orederItems);
        }
    }

    public function orderStatus()
    {
        dd();
        $order       = [];
        $orederItems = [];
        $user        = [];
        $filePath    = $filePath    = storage_path('app/public/import/customers-orders-status.csv');
        $file        = fopen($filePath, "r");
        $i           = 0;
        // dd($orderFields);
        $orederItemsArray = ["order id" => "big_id", "order status" => "order_status_id", "product id" => "product_id"];
        $statusArray      = ["Completed" => 5, "Shipped" => 4, "Cancelled" => 6, "Refunded" => 7, "Awaiting Fulfillment" => 1, "Awaiting Payment" => 1, "Manual Verification Required" => 1, "Awaiting Shipment" => 2, "Partially Refunded" => 7];

        while (($data = fgetcsv($file, '', ",")) !== false) {
            if (!empty($data) && $i == 0) {
                foreach ($data as $key => $value) {
                    $array[strtolower(trim($value))] = trim($key);
                }
                // dd($array);
            } else {
                $orderStatus = [];
                foreach ($orederItemsArray as $key => $value) {
                    if (!empty($data[$array[$key]])) {
                        $orderStatus[$value] = $data[$array[$key]];
                    }
                }
                $statusId                       = $statusArray[$orderStatus['order_status_id']];
                $orderStatus['order_status_id'] = $statusId;
                $existingOrder                  = Order::where('big_id', $orderStatus['big_id'])->first();
                if (!empty($existingOrder)) {
                    if (!empty($orderStatus['product_id'])) {
                        $product = Product::where('big_id', $orderStatus['product_id'])->withTrashed()->first();
                        if (!empty($product)) {
                            $existingOrder->order_status_id = $statusId;
                            $existingOrder->save();
                            $orderItems = OrderItem::where('order_id', $existingOrder->id)->where('product_id', $product->id)->first();
                            if ($orderItems->order_status_id !== $statusId) {
                                $orderItems->order_status_id = $statusId;
                                $orderItems->save();
                            }

                        }
                    }
                }
            }
            $i++;
        }

    }
    public function orderUpdateTransaction()
    {
        // $order = Order::find(7546);
        // // dd($order);
        // $payment       = PaymentSetting::find(2);
        // $gateway = Omnipay::create('AuthorizeNetApi_Api');
        // if ($payment->value->mode) {
        //     $paymentSetting = $payment->value->live;
        // } else {
        //     $paymentSetting = $payment->value->sandbox;
        //     $gateway->setTestMode(true);
        // }
        // $gateway->setAuthName($paymentSetting->login_id);
        // $gateway->setTransactionKey($paymentSetting->transaction_key);
        // $response = $gateway->capture([
        //     'amount' => $order->order_total,
        //     'currency' => 'USD',
        //     'transactionReference' => $order->payment_transaction_id,
        // ])->send();
        // var_dump($response->isSuccessful());
        // echo '<br/>';
        // // bool(true)

        // var_dump($response->getCode());
        // echo '<br/>';
        // // string(1) "1"

        // var_dump($response->getMessage());
        // echo '<br/>';
        // // string(35) "This transaction has been approved."

        // var_dump($response->getTransactionReference());
        // echo '<br/>';
        // dd($response);
        dd();
        $orders = Order::withTrashed()->get();
        foreach ($orders as $order) {
            $response = $order->payment_response;
            // dd($response);
            if (!empty($response)) {
                $order->payment_status         = isset($response->transactionResponse->messages[0]) ? 1 : 0;
                $order->payment_status_code    = $response->transactionResponse->responseCode;
                $order->payment_message        = isset($response->transactionResponse->messages[0]) ? $response->transactionResponse->messages[0]->description : $response->transactionResponse->errors[0]->errorText;
                $order->payment_transaction_id = $response->transactionResponse->transId;
                $order->save();
            }
        }

    }
    public function orderGuest()
    {
        dd();
        $order       = [];
        $orederItems = [];
        $user        = [];
        $filePath    = $filePath    = storage_path('app/public/import/customers-orders-status.csv');
        $file        = fopen($filePath, "r");
        $i           = 0;
        // dd($orderFields);
        $orederItemsArray = ["order id" => "big_id", "customer id" => "user_id"];

        while (($data = fgetcsv($file, '', ",")) !== false) {
            if (!empty($data) && $i == 0) {
                foreach ($data as $key => $value) {
                    $array[strtolower(trim($value))] = trim($key);
                }
            } else {
                $orderStatus = [];
                foreach ($orederItemsArray as $key => $value) {
                    if (!empty($data[$array[$key]])) {
                        $orderStatus[$value] = $data[$array[$key]];
                    }
                }
                $existingOrder = Order::where('big_id', $orderStatus['big_id'])->first();
                if (!empty($existingOrder)) {
                    if (empty($orderStatus['user_id'])) {
                        // dd($orderStatus);
                        $existingOrder->is_guest = 1;
                        $existingOrder->save();
                        $existingOrderItems = $existingOrder->orderItems()->update(['is_guest' => '1']);
                    }
                }
            }
            $i++;
        }

    }
    public function ordersProducts()
    {
        dd();
        $filePath = storage_path('app/public/import/customers-orders.csv');
        $file     = fopen($filePath, "r");
        $i        = 0;
        $ids      = [];
        // $statues  = [];
        // while (($data = fgetcsv($file, '', ",")) !== false) {
        //     if (isset($data[1])) {
        //         $status = $data[1];
        //         if ($i !== 0 && !in_array($status, $statues)) {
        //             $statues[$status] = $status;
        //         }
        //         $i++;
        //     }
        // }
        // echo '<pre>';
        // print_r($statues);
        // dd();

        //  $varients  = [];
        // while (($data = fgetcsv($file, '', ",")) !== false) {
        //     // dd($data);
        //     if (isset($data[68])) {
        //         $varient = $data[68];
        //         if ($i !== 0 && !in_array($varient, $varients)) {
        //             $varient = explode(':',$varient);
        //             if(count($varient)==2)
        //             {
        //                $varients["$varient[0]"]["$varient[1]"] = $varient[1];
        //             }
        //         }
        //         $i++;
        //     }
        // }
        // echo '<pre>';
        // print_r($varients);
        // dd();

        while (($data = fgetcsv($file, 1000, ",")) !== false) {
            if (isset($data[64])) {
                $id   = $data[64];
                $sku  = $data[66];
                $name = $data[67];
                $type = '';
                if ($i !== 0 && !in_array($id, $ids)) {
                    $product     = null;
                    $liveProduct = ['live_id' => null, 'live_id' => null, 'live_name' => null];
                    $devProduct  = ['dev_id' => null, 'dev_sku' => null, 'dev_name' => null];
                    $product     = Product::where('big_id', $id)->withTrashed()->first();
                    $type        = 'id';

                    if (empty($product)) {
                        $type = null;
                    }
                    $ids[]                    = $id;
                    $liveProduct['live_id']   = $id;
                    $liveProduct['live_sku']  = $sku;
                    $liveProduct['live_name'] = $name;
                    $liveProduct['type']      = $type;
                    $liveProduct['order']     = 1;
                    if (!empty($product)) {
                        $devProduct['dev_id']   = $product->id;
                        $devProduct['dev_sku']  = $product->sku;
                        $devProduct['dev_name'] = $product->name;
                    }
                    $results[$id] = array_merge($liveProduct, $devProduct);
                } else {
                    if (in_array($id, $ids)) {
                        $count                 = $results[$id]['order'] + 1;
                        $results[$id]['order'] = $count;
                    }
                }
                $i++;
            }
        }
        $html = '<table border="1"><tr><th>Type</th> <th>order</th> <th>Live Id</th> <th>Dev Id</th> <th>Live Sku</th> <th>Dev Sku</th> <th>Live Name</th>  <th>Dev Name</th></tr>';
        foreach ($results as $result) {
            if (empty($result['dev_id'])) {
                $html .= '<tr  bgcolor="#FF0000">';
            } else {
                $html .= '<tr>';
            }
            $html .= '<th>' . $result['type'] . '</th>';
            $html .= '<th>' . $result['order'] . '</th>';
            $html .= '<th>' . $result['live_id'] . '</th>';
            $html .= '<th>' . $result['dev_id'] . '</th>';
            $html .= '<th>' . $result['live_sku'] . '</th>';
            $html .= '<th>' . $result['dev_sku'] . '</th>';
            $html .= '<th>' . $result['live_name'] . '</th>';
            $html .= '<th>' . $result['dev_name'] . '</th>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        echo $html;
        die();

    }
    public function updateBigId()
    {
        dd();
        $filePath = storage_path('app/public/import/product_big_id.csv');
        $file     = fopen($filePath, "r");
        $i        = 0;
        $ids      = [];
        while (($data = fgetcsv($file, 1000, ",")) !== false) {
            if (isset($data[1])) {
                $id       = $data[0];
                $itemType = $data[1];
                $sku      = $data[3];
                $name     = $data[2];
                $type     = '';
                if ($i !== 0 && $itemType == 'Product') {
                    $product     = null;
                    $liveProduct = ['live_id' => null, 'live_id' => null, 'live_name' => null];
                    $devProduct  = ['dev_id' => null, 'dev_sku' => null, 'dev_name' => null];
                    if (!empty($sku)) {
                        $product = Product::where('sku', $sku)->withTrashed()->first();
                        $type    = 'sku';
                    }
                    if (empty($product)) {
                        $product = Product::where('name', "$name")->withTrashed()->first();
                        $type    = 'name';
                    }
                    if (empty($product)) {
                        $type = null;
                    }
                    $ids[]                    = $id;
                    $liveProduct['live_id']   = $id;
                    $liveProduct['live_sku']  = $sku;
                    $liveProduct['live_name'] = $name;
                    $liveProduct['type']      = $type;
                    if (!empty($product)) {
                        $devProduct['dev_id']   = $product->id;
                        $devProduct['dev_sku']  = $product->sku;
                        $devProduct['dev_name'] = $product->name;
                        $product->big_id        = $id;
                        $product->save();
                    }
                    $results[$id] = array_merge($liveProduct, $devProduct);
                }
                $i++;
            }
        }

        $html = '<table border="1"><tr><th>Type</th> <th>Live Id</th> <th>Dev Id</th> <th>Live Sku</th> <th>Dev Sku</th> <th>Live Name</th>  <th>Dev Name</th></tr>';
        foreach ($results as $result) {
            if (empty($result['dev_id'])) {
                $html .= '<tr  bgcolor="#FF0000">';
            } else {
                $html .= '<tr>';
            }
            $html .= '<th>' . $result['type'] . '</th>';
            $html .= '<th>' . $result['live_id'] . '</th>';
            $html .= '<th>' . $result['dev_id'] . '</th>';
            $html .= '<th>' . $result['live_sku'] . '</th>';
            $html .= '<th>' . $result['dev_sku'] . '</th>';
            $html .= '<th>' . $result['live_name'] . '</th>';
            $html .= '<th>' . $result['dev_name'] . '</th>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        echo $html;
        die();

    }

    public function importRedirectUrl()
    {
        dd();
        $domainList         = ["generalchem.com", "cmichem.com", "auto-chemicals.com", "carpetcleanchemicals.com", "deckchemicals.com", "vanishingoil.com", "foundrychem.com", "solderingfluxes.com", "metallubricant.com", "removepaints.com", "paintboothchemicals.com", "strippablecoating.com", "containercleaningchemicals.com", "paintstripper-chemical.com", "tankcleaningchemicals.com", "vanishinglubricant.com", "paintstripperproducts.com", "paintbooth-coating.com", "paintboothproducts.com", "paintstripper.us", "peelablecoating.com", "generalchemicalcorp.mybigcommerce.com"];
        $domainDefaultArray = [
            "auto-chemicals.com"                    => "category/car-care",
            "carpetcleanchemicals.com"              => "category/carpet-cleaning",
            "deckchemicals.com"                     => "category/deck-paver",
            "vanishingoil.com"                      => "category/vanishing-oil",
            "foundrychem.com"                       => "category/foundry",
            "solderingfluxes.com"                   => "category/soldering-fluxes",
            "metallubricant.com"                    => "category/lubricants",
            "removepaints.com"                      => "category/paint-strippers",
            "paintboothchemicals.com"               => "category/paint-booth-maintenance",
            "strippablecoating.com"                 => "category/paint-booth-maintenance",
            "containercleaningchemicals.com"        => "category/container-cleaning",
            "paintstripper-chemical.com"            => "category/paint-strippers",
            "tankcleaningchemicals.com"             => "category/container-cleaning",
            "vanishinglubricant.com"                => "category/vanishing-oil",
            "paintstripperproducts.com"             => "category/paint-strippers",
            "paintbooth-coating.com"                => "category/paint-booth-maintenance",
            "paintboothproducts.com"                => "category/paint-booth-maintenance",
            "paintstripper.us"                      => "category/paint-strippers",
            "peelablecoating.com"                   => "category/strippable-coatings",
            "generalchemicalcorp.mybigcommerce.com" => "store",
        ];
        // foreach ($domainList as $domain) {
        //     $default                     = $this->findOldUrl('http://' . $domain);
        //     $domainDefaultArray[$domain] = $default->new_url ?? '';
        // }
        // dd($domainDefaultArray);
        $filePath = storage_path('app/public/import/big_url_map.csv');
        $file     = fopen($filePath, "r");
        $i        = 0;
        // $urlArry = [];
        $redirectUrlArry = [];
        while (($data = fgetcsv($file, '', ",")) !== false) {
            $oldUrl = rtrim($data[0], "/");
            $newUrl = rtrim($data[1], "/");
            if ($i !== 0) {
                $domain = $this->urlToDomain($oldUrl);
                if (empty($domain)) {
                    $key = 'generalchem.com';
                } elseif (in_array($domain, $domainList)) {
                    if ($domain == 'generalchem.com') {
                        if (strpos($oldUrl, 'http://generalchem.com/') !== false) {
                            $oldUrl = str_replace("http://generalchem.com/", "", $oldUrl);
                        }
                    }
                    $key = $domain;
                } else {
                    $key = 'none';
                }

                $newUrl = str_replace("https://generalchem.com/", "", $newUrl);
                $newUrl = str_replace("https://generalchem.com", "", $newUrl);
                if (empty($newUrl) && (in_array($domain, $domainList))) {
                    $newUrl = $domainDefaultArray[$domain] ?? '';
                    // $newUrl  = str_replace("https://generalchem.com/", "", $newUrl);
                    // $newUrl  = str_replace("https://generalchem.com", "", $newUrl);
                }
                $redirectUrlArry[$key][] = ['old_url' => $oldUrl, 'new_url' => $newUrl, 'domain' => $key];
                // dd($url);
                // if(!in_array($url,$urlArry)){
                //     $urlArry[] = $url;
                // }

            }
            $i++;
        }

        foreach ($redirectUrlArry as $domain => $urlData) {

            foreach ($urlData as $url) {
                // dd($url);
                if ($domain !== 'none') {
                    if (!$this->findOldUrl($url['old_url'], $url['old_url'])) {
                        RedirectUrl::create($url);
                    }

                } else {
                    Log::notice($url['old_url']);
                }
            }

        }
        // echo '<pre>';
        // print_r($redirectUrlArry);
        // die();
        // dd($redirectUrlArry);
    }
    private function findOldUrl($slug, $fullUrl)
    {
        $slug      = urldecode(rtrim($slug, "/"));
        $slug1     = $slug . '/';
        $fullMatch = RedirectUrl::where('old_url', $fullUrl)->first();
        if (!empty($fullMatch)) {
            return $fullMatch;
        } else {
            return RedirectUrl::where('old_url', $slug)->orWhere('old_url', $slug1)->first();
        }
    }
    private function urlToDomain($url)
    {
        $host = @parse_url($url, PHP_URL_HOST);
        if (substr($host, 0, 4) == "www.") {
            $host = substr($host, 4);
        }

        // You might also want to limit the length if screen space is limited
        if (strlen($host) > 50) {
            $host = substr($host, 0, 47) . '...';
        }

        return $host;
    }

    public function mapBigUrl()
    {
        dd();
        $filePath = storage_path('app/public/import/big-redirect.csv');
        $file     = fopen($filePath, "r");
        $i        = 0;
        $urlArry  = [];
        while (($data = fgetcsv($file, '', ",")) !== false) {
            $oldUrl = rtrim($data[0], "/");
            if ($i !== 0) {
                $domain                = $this->urlToDomain($oldUrl);
                $urlData               = $this->findOldUrl($oldUrl, $oldUrl);
                $urlArry[$i]['old']    = $oldUrl;
                $urlArry[$i]['new']    = $urlData->new_url ?? '';
                $urlArry[$i]['id']     = $urlData->id ?? 0;
                $urlArry[$i]['domain'] = $urlData->domain ?? '';
                $ids[]                 = $urlData->id ?? 0;
            }
            $i++;
        }
        $finalIds   = array_unique($ids);
        $remainUrls = RedirectUrl::where('domain', 'generalchemicalcorp.mybigcommerce.com')->whereNotIn('id', $finalIds)->get();
        foreach ($remainUrls as $remainUrl) {
            $urlArry[$i]['old']    = $remainUrl->old_url;
            $urlArry[$i]['new']    = $remainUrl->new_url;
            $urlArry[$i]['id']     = $remainUrl->id;
            $urlArry[$i]['domain'] = $remainUrl->domain;
            $i++;
        }

        $output = fopen("php://output", 'w') or die("Can't open php://output");
        header("Content-Type:application/csv");
        header("Content-Disposition:attachment;filename=big_url_map.csv");
        fputcsv($output, array('old_url', 'new_url', 'id', 'domain'));
        foreach ($urlArry as $url) {
            fputcsv($output, $url);
        }
        fclose($output) or die("Can't close php://output");
        // dd($url);

    }

    private function array2csv($data, $delimiter = ',', $enclosure = '"', $escape_char = "\\")
    {
        $f = fopen('php://memory', 'r+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }
}
