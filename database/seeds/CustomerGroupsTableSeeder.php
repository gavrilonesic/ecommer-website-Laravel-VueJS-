<?php

use App\CustomerGroup;
use Illuminate\Database\Seeder;

class CustomerGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerGroup::create([
            'name' => 'Default'
        ]);
    }
}
