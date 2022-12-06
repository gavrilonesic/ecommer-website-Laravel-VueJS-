<?php

use App\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'title'  => 'Cash On Delivery',
                'isFree' => 1,
            ],
            [
                'title' => 'Authorize.net',
                'view'  => 'authorizenet',
                'value' => [
                    'live'    => [
                        'login_id'        => '',
                        'transaction_key' => '',
                    ],
                    'mode'    => 0,
                    'sandbox' => [
                        'login_id'        => '',
                        'transaction_key' => '',
                    ],

                ],
            ],
        ])->each(function ($item, $key) {
            $brand = PaymentSetting::create($item);
        });
    }
}
