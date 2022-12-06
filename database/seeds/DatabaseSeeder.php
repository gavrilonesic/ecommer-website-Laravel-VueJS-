<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(CustomerGroupsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(CmsPagesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(PaymentSettingsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
    }
}
