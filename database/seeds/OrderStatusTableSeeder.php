<?php

use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //parent 0
        collect([
            ['name' => 'Awaiting Fulfillment'],
            ['name' => 'Awaiting Shipment'],
            ['name' => 'Awaiting Pickup'],
            ['name' => 'Shipped'],
            ['name' => 'Completed'],
            ['name' => 'Declined/Cancelled'],
            ['name' => 'Refund'],
            ['name' => 'Return Request Initiated'],
            ['name' => 'Return Accepted'],
            ['name' => 'Return Pickup Initiated'],
            ['name' => 'Return Received']
        ])->each(function ($item, $key) {
            $item['name'] = ucwords(strtolower($item['name']));
            $item['status']  = 1;
            OrderStatus::create($item);
        });
    }
}
