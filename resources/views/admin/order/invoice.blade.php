<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office" moznomarginboxes mozdisallowselectionprint>

<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
    <!--[if mso]>
        <style>
            * {
                font-family: sans-serif !important;
            }
        </style>
    <![endif]-->

    <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap" rel="stylesheet">
    <!--<![endif]-->
    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset -->
    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */


        /*  @media print {*/

        html {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f5f9 !important;
            -webkit-print-color-adjust: exact;
        }

        body {
            max-width: 800px;
            margin: 0 auto !important;
            /*padding: 20px !important;*/
            /*height: 100% !important;*/
            width: 100% !important;
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f5f9 !important;
            -webkit-print-color-adjust: exact;
        }

        table {
            width: 100%;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table th {
            padding: 15px 20px;
        }

        table td {
            padding: 9px 20px;
        }

        #Header,
        #Footer {
            display: none !important;
        }

        .whitebg {
            background-color: #fff !important;
            -webkit-print-color-adjust: exact;
        }
        .page-break {page-break-after: always;}


        /*}*/
    </style>
    @if($type == 'print')
        <style type="text/css" media="print">
            .invoice-div
            {
                padding: 20px;
            }
            @page
            {
                size: auto;   /* auto is the initial value */
            }
            body
            {
                background-color:#FFFFFF !important;
            }
        </style>
    @endif
</head>

<body>
    @foreach($orders as $order)
    <div class="invoice-div">
        <table cellspacing="0" cellpadding="0" border="0" align="center">
            <tr>
                <td align="left" valign="top" style="border-bottom: 2px solid #666;"><img
                        src="{{ asset('/images/mail-logo.png') }}"></td>
                <td align="left" valign="top" style="font-size: 12px; border-bottom: 2px solid #666;">
                    <div style="display: block;font-family: 'Montserrat', sans-serif; color:#2d3a4b;"><strong>Head
                            Office:</strong> {{ setting('address_line1') ? setting('address_line1') : '' }} {{ setting('address_line2') ? setting('address_line2') : '' }} , {{ setting('city') ? setting('city').', ' : '' }} {{ setting('state') ? setting('state') : '' }} {{ setting('zipcode') ? setting('zipcode').', ' : '' }} {{ setting('country') ? setting('country') : '' }}</div>
                    <div style="display: block;font-family: 'Montserrat', sans-serif; color:#2d3a4b;">
                        <strong>Phone/Fax:</strong> {{setting('mobile_no')}} / {{setting('fax')}}</div>
                    <div style="display: block;font-family: 'Montserrat', sans-serif; color:#2d3a4b;">
                        <strong>Email:</strong> {{setting('email')}}</div>
                </td>
            </tr>
        </table>
        <table cellspacing="0" cellpadding="0" border="0" align="center" style="background-color: #fff;" class="whitebg">
            <tr>
                <td align="left" valign="top" style="border-bottom:3px solid #f0f5f9">
                    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                        <tr>
                            <td
                                style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666666;">
                                <strong style="text-transform: uppercase">
                                    Invoice to
                                </strong><br>
                                {!! nl2br($order->getBillingAdress()) !!}<br>
                                Phone: {{$order->billing_mobile_no}} <br>
                                Email: {{$order->billing_email}} <br>
                            </td>
                            <td
                                style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666666;">
                                <strong style="text-transform: uppercase">
                                    Delivered to
                                </strong><br>
                                {!! nl2br($order->getShippingAdress()) !!}<br>
                                Phone: {{$order->mobile_no}} <br>
                                Email: {{$order->email}} <br>
                            </td>
                            <td
                                style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666666;">
                                <strong style="text-transform: uppercase">
                                    Order Date
                                </strong><br>
                                {{ date('F j, Y', strtotime($order->created_at)) }}<br><br>
                               <strong style="text-transform: uppercase">
                                    Order No:
                                </strong><br>
                                {{$order->id}}<br>

                                @if (trim($order->purchase_order) !== '')
                                    <br>
                                    <strong style="text-transform: uppercase">
                                        PO
                                    </strong><br>
                                    {{ $order->purchase_order }}<br>
                                @endif

                            </td>
                        </tr>
                        @php
                        $data = $order->payment_response;
                        @endphp
                        @if($order->payment_response != null && !empty($data->transactionResponse) && !empty($data) )
                        <tr>
                            <td
                                style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666666;">
                                <strong style="text-transform: uppercase">
                                    Transaction Id:
                                </strong><br>

                                {{ $data->transactionResponse->transId }}
                            </td>
                            <td
                                style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666666;">
                                <strong style="text-transform: uppercase">
                                    Transaction Status:
                                </strong><br>
                                @if(empty($data->transactionResponse->errors))
                                {{ $data->messages->message[0]->text }}
                                @else
                                Failed
                                @endif
                            </td>
                            <td
                                style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666666;">
                                <br><strong style="text-transform: uppercase">
                                    Transaction Message:
                                </strong><br>
                                @if(empty($data->transactionResponse->errors))
                                    {{ $data->transactionResponse->messages[0]->description  }}
                                @else
                                  {{ $data->transactionResponse->errors[0]->errorText }}
                                @endif
                            </td>
                        </tr>
                        @endif

                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top" style="border-bottom:3px solid #f0f5f9">
                    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                        <tr>
                            <th style="font-size: 15px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666666;"
                                align="left">
                                DESCRIPTION

                            </th>
                            <th style="font-size: 15px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666666;"
                                align="left">
                                PRICE
                            </th>
                            <th style="font-size: 15px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666666;"
                                align="left">
                                QTY
                            </th>
                            <th style="font-size: 15px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666666;"
                                align="left">
                                TOTAL
                            </th>
                        </tr>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#000;"
                                align="left">
                                <strong style="color:#000">{{$item->product->name ?? '-'}}</strong>
                                <br>
                                @if (!empty($item->variations))
                                  @foreach ($item->variations as $key => $row)
                                      {{$key}}:
                                    {{$row}}
                                    <br/>
                                  @endforeach
                                @endif
                            </td>
                            <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#000;"
                                align="left">
                                {{setting('currency_symbol')}}{{$item->price}}
                            </td>
                            <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#000;"
                                align="left">
                                {{$item->quantity}}
                            </td>
                            <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#000;"
                                align="left">
                                {{setting('currency_symbol')}}{{number_format($item->price * $item->quantity,2)}}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" valign="top" style="border-bottom:3px solid #f0f5f9">
                    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                        <tr>
                            <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666666;"
                                width="250" valign="top">
                                <strong style="text-transform: uppercase">
                                    SHIPPING METHOD
                                </strong><br>
                                @if ($order->shipping_service_name == "pickup-from-store")
                                    {{__('messages.pickup_from_store')}}:<br />
                                    {{ setting('address_line1') ? setting('address_line1') : '12336 Emerson Dr.' }} {{ setting('address_line2') ? setting('address_line2') : '' }}<br />{{ setting('city') ? setting('city').', ' : 'Brighton, ' }} {{ setting('state') ? setting('state') : 'MI' }} {{ setting('zipcode') ? setting('zipcode').', ' : '48116' }} {{ setting('country') ? setting('country') : 'USA' }}
                                @else
                                    {{__('messages.' . $order->shipping_quotes)}}<br/>
                                    @if ($order->shipping_quotes ==  'own_shipping')
                                        {{__('messages.service_name')}}: {{$order->shipping_service_name}}<br/>
                                        {{__('messages.account_number')}}: {{$order->shipping_account_number}} <br/>
                                        {{__('messages.note')}}: {{$order->shipping_note}}</p>
                                    @endif
                                @endif
                            </td>
                            <td align="right" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666;"
                                            align="left">
                                            <strong>{{__('messages.item_subtotal')}}</strong>
                                        </td>
                                        <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666;"
                                            align="left">
                                            {{setting('currency_symbol')}}{{$order->order_sub_total}}
                                        </td>
                                    </tr>
                                    @if($order->order_discount > 0)
                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            <strong>{{__('messages.discount')}}</strong>
                                        </td>
                                        <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            {{setting('currency_symbol')}}{{$order->order_discount}}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            <strong>{{__('messages.shipping')}}</strong>
                                        </td>
                                        <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            @if($order->shipping_total)
                                            {{setting('currency_symbol')}}{{$order->shipping_total}}
                                            @else {{setting('currency_symbol')}}0.00
                                            @endif
                                        </td>
                                    </tr>
                                    @if($order->handling_fees_total > 0)
                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            <strong>{{__('messages.handling_fees')}}</strong>
                                        </td>
                                        <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            @if($order->handling_fees_total)
                                            {{setting('currency_symbol')}}{{$order->handling_fees_total}}
                                            @else {{setting('currency_symbol')}}0.00
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($order->hazmat_shipping_cost > 0)
                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            <strong>{{__('messages.hazmat_shipping_cost')}}</strong>
                                        </td>
                                        <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            @if($order->hazmat_shipping_cost)
                                            {{setting('currency_symbol')}}{{$order->hazmat_shipping_cost}}
                                            @else {{setting('currency_symbol')}}0.00
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if($order->tax_total > 0)
                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            <strong>{{__('messages.tax')}}</strong>
                                        </td>
                                        <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9"
                                            align="left">
                                            @if($order->tax_total)
                                            {{setting('currency_symbol')}}{{$order->tax_total}}
                                            @else {{setting('currency_symbol')}}0.00
                                            @endif
                                        </td>
                                    </tr>
                                    @endif

                                    @if (! $order->coupons->isEmpty())
                                        <tr>
                                            <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9">
                                                Coupons: 
                                            </td>
                                            <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#666; border-top:2px solid #f0f5f9" align="left">
                                                @foreach ($order->coupons as $coupon)
                                                    <kbd>{{ $coupon->code }}</kbd>
                                                    @if (! $loop->last)
                                                        , 
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#393950; border-top:2px solid #393950"
                                            align="left">
                                            <strong>{{__('messages.total')}}</strong>
                                        </td>
                                        <td style="font-size: 13px; line-height: 22px;  font-family: 'Montserrat', sans-serif; color:#393950; border-top:2px solid #393950"
                                            align="left">
                                            <strong>{{setting('currency_symbol')}}{{$order->order_total}}</strong>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" style="font-size: 16px; line-height: 22px; font-family: 'Montserrat', sans-serif; color:#393950; padding: 20px;">
                        Thank You Again For Your Order!
                </td>
            </tr>
        </table>
        <table cellspacing="0" cellpadding="0" border="0" align="center">
                <tr>
                    <td align="left" valign="middle" style="font-size: 13px; line-height:13px; font-family: 'Montserrat', sans-serif; color:#393950; padding: 20px;">
                            This is computer generated invoice no signature required.

                        </td>
                    <td align="right" valign="middle" style="font-size: 13px; line-height:13px; font-family: 'Montserrat', sans-serif; color:#393950; padding: 20px;">
                            © General Chemical Corp. All Rights Reserved
                    </td>
                </tr>
        </table>
    </div>
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
    @endforeach
</body>

</html>