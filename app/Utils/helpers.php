<?php

if (!function_exists('setting')) {

    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new \App\Setting();
        }

        if (is_array($key)) {
            return \App\Setting::set($key[0], $key[1]);
        }

        $value = \App\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}

if (! function_exists('addressToString')) 
{
    function addressToString (array $address): string 
    {
        $addressString = $address['address_line_1'] . " ";
        $addressString .= trim($address['address_line_2']) !== '' ? ", " : '';

        $country = \App\Country::find($address['country_id']);
        if (!empty($address['state_id'])) {
            $state     = \App\State::find($address['state_id']);
            $stateName = $state->name;
        } else {
            $stateName = $address['state_name'];
        }

        $addressString .= $address['city_name'] . ', ' . $stateName . ', ' . $address['zip_code'] . ', ' . $country->name;

        return $addressString;
    }
}
