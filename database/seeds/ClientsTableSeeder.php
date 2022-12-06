<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::truncate();

        collect([
            [
                'name' => 'BASF',
                'image_src' => '/images/clients/basf-logo.png',
            ],
            [
                'name' => 'Bonnavilla',
                'image_src' => '/images/clients/bonnavilla-logo.png',
            ],
            [
                'name' => 'Denso',
                'image_src' => '/images/clients/denso-logo.png',
            ],
            [
                'name' => 'Dolphin',
                'image_src' => '/images/clients/dolphin-logo.png',
            ],
            [
                'name' => 'Dssi',
                'image_src' => '/images/clients/dssi-logo.png',
            ],
            [
                'name' => 'Fastenal',
                'image_src' => '/images/clients/fastenal-logo.jpg',
            ],
            [
                'name' => 'John Deere',
                'image_src' => '/images/clients/johndeere-logo.png',
            ],
            [
                'name' => 'Johnson Controls',
                'image_src' => '/images/clients/johnsoncontrols-logo.png',
            ],
            [
                'name' => 'Motion',
                'image_src' => '/images/clients/motion-logo.png',
            ],
            [
                'name' => 'msc',
                'image_src' => '/images/clients/msc-logo.jpg',
            ],
            [
                'name' => 'PPG',
                'image_src' => '/images/clients/ppg-logo.png',
            ],
            [
                'name' => 'Tesla',
                'image_src' => '/images/clients/tesla-logo.png',
            ],
        ])->each(function ($item, $index) {
            $item['order'] = $index + 1;
            $client = Client::create($item);
            $client->addMedia(public_path($client->image_src))->toMediaCollection('clients');
        });
    }
}
