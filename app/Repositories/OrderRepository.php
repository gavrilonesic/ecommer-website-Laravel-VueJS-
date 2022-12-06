<?php

namespace App\Repositories;

use App\Email;
use App\Order;
use App\OrderItem;
use App\OrderStatusHistory;

class OrderRepository
{
    public function changeStatus(Order $order, int $status, array $items, array $data, $dispatchable = false)
    {
        $shippingText = '';
        $orderItemData['order_status_id'] = $status;

        if (isset($data['comment']) && !empty($data['comment'])) {
            $orderItemData['comment'] = $data['comment'];
        }
        if (isset($data['tracking_url']) && !empty($data['tracking_url'])) {
            $orderItemData['tracking_url'] = $data['tracking_url'];
        }
        if (isset($data['tracking_provider_id']) && !empty($data['tracking_provider_id'])) {
            $orderItemData['tracking_provider_id'] = $data['tracking_provider_id'];
        }else{
            $data['tracking_provider_id'] = '';
        }
        if (isset($data['carrier_name']) && !empty($data['carrier_name']) and $data['tracking_provider_id'] == config('constants.CUSTOM_SHIPPING_PROVIDER_ID')) {
            $orderItemData['carrier_name'] = $data['carrier_name'];
        }
        if (isset($data['tracking_number']) && !empty($data['tracking_number'])) {
            $orderItemData['tracking_number'] = $data['tracking_number'];
            $shippingText = '<p style="font-size: 13px; color:#666666; font-weight:500; font-family: Montserrat, sans-serif; line-height: 16px;">Your order has been shipped via <strong>[Tracking Provider]</strong> and the tracking number is <strong>[Tracking Number].</strong> </p>';
        }

        if (count($items)) {
            $orderItems = OrderItem::whereIn('id', $items)->update($orderItemData);
        }

        //updating order status history table
        foreach ($items as $val) {
            $data['order_item_id'] = $val;
            $data['order_status_id'] = $status;
            OrderStatusHistory::create($data);
        }

        $emailTemplate = config('constants.CUSTOMER_EMAIL_TEMPLATE');

        if (isset($emailTemplate[$status]) && !empty($emailTemplate[$status])) {
            $order->update(['refund_total' => $order->UpdateRefundAmount(), 'order_status_id' => $status]);
            $cancelled = $status == 6 ? 1 : 0;

            if (isset($data['order_send_email']) && $data['order_send_email'] == "1") {
                $order = Order::getOrder($order->id, $items);

                $tracking_provider_name = $data['tracking_provider_id'] == config('constants.CUSTOM_SHIPPING_PROVIDER_ID')
                    ? $data['carrier_name'] : ($data['tracking_provider_id'] ?  : '');

                $placeHolders = [
                    "[Customer Name]"     => $order->name,
                    "[Order ID]"          => $order->id,
                    "[Product Table]"     => view('emails.customer.order_details', compact('order', 'cancelled')),
                    "[Tracking Text]"     => $shippingText ?? '',
                    "[Tracking Provider]" => $tracking_provider_name,
                    "[Tracking Number]"   => $data['tracking_number'] ?? '',
                ];
           
                Email::sendEmail($emailTemplate[$status], $placeHolders, $order->email ?? '', $dispatchable);
            }
        }
    }
}
