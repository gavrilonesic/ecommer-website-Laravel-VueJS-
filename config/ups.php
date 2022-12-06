<?php

return [
    /*
    |--------------------------------------------------------------------------
    | UPS Credentials
    |--------------------------------------------------------------------------
    |
    | This option specifies the UPS credentials for your account.
    | You can put it here but I strongly recommend to put thoses settings into your
    | .env & .env.example file.
    |
    */
    'access_key' => env('UPS_ACCESS_KEY', '4D7EA123A6CF94F1'),
    'user_id'    => env('UPS_USER_ID', 'generalchem'),
    'password'   => env('UPS_PASSWORD', 'PASSword#123'),
    'wsdl_path'  => app_path('Custom/UpsShipping/wsdl/FreightRate.wsdl'),
    'sandbox'    => false,
    'percentage_increase' => 0.22,
];
