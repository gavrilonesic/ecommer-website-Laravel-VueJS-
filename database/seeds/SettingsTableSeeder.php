<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
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
            	'name' => 'currency_name',
                'value' => 'Dollar',
                'type' => 'string'
            ],
            [
                'name' => 'currency_code',
                'value' => 'USD',
                'type' => 'string'
            ],
            [
                'name' => 'currency_symbol',
                'value' => '$',
                'type' => 'string'
            ],
            [
                'name' => 'weight_in',
                'value' => 'LBS',
                'type' => 'string'
            ],
            [
            	'name' => 'depth_in',
                'value' => 'Inches',
                'type' => 'string'
            ],
            [
                'name' => 'height_in',
                'value' => 'Inches',
                'type' => 'string'
            ],
            [
                'name' => 'width_in',
                'value' => 'Inches',
                'type' => 'string'
            ],
        ])->each(function ($item, $key) {
            Setting::create($item);
        });
    }
}
