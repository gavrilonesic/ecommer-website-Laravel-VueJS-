<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'active' => 1,
            'role_id' => 1
        ]);
    }
}
