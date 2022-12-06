<?php

use App\Brand;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            // [
            //     'name' => 'Nokia',
            //     'page_title' => 'Nokia',
            // ],
            // [
            //     'name' => 'Sony',
            //     'page_title' => 'Sony',
            // ],
            // [
            //     'name' => 'Nike',
            //     'page_title' => 'Nike',
            // ],
            // [
            //     'name' => 'Reebok',
            //     'page_title' => 'Reebok',
            // ],
            // [
            //     'name' => 'Zara',
            //     'page_title' => 'Zara',
            // ],
            [
                'name' => 'General Chemical Corp.',
                'page_title' => 'General Chemical Corp.',
            ],
        ])->each(function ($item, $key) {
            $brand = Brand::create($item);
        });
    }
}
