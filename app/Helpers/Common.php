<?php

namespace App\Helpers;

class Common
{
    /**
     * Returns the list of statuses in key:value pair
     *
     * @return array Array of chargeShipping
     */
    public static function getShippingChageBy()
    {
        return [
            1 => "By Weight",
            2 => "By Order Total",
        ];
    }
    public static function getShippingChageBySymbole()
    {
        return [
            1 => setting('weight_in'),
            2 => setting('currency_symbol'),
        ];
    }

    public static function getShippingRateType()
    {
        return [
            1 => __("messages.per_order"),
            2 => __("messages.per_item"),
        ];
    }
}
