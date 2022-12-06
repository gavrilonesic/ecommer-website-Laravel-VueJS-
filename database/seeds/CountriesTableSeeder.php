<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
/**
 * Run the database seeds.
 *
 * @return void
 */
    public function run()
    {
        DB::table('countries')->delete();
        $json      = File::get("database/data/countries.json");
        $countries = json_decode($json, true);
        Country::insert($countries);
    }
}
