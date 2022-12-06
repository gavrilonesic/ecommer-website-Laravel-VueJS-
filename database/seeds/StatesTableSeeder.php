<?php
use App\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
/**
 * Run the database seeds.
 *
 * @return void
 */
    public function run()
    {
        DB::table('states')->delete();
        $json   = File::get("database/data/states.json");
        $states = json_decode($json, true);
        State::insert($states);
    }
}
