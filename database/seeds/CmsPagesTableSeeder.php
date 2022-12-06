<?php

use App\CmsPage;
use Illuminate\Database\Seeder;

class CmsPagesTableSeeder extends Seeder
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
                'title' => 'About Us',
                'page_title' => 'About Us',
            ],
            [
                'title' => 'Contact Us',
                'page_title' => 'Contact Us',
            ],
            [
                'title' => 'Terms & Conditions',
                'page_title' => 'Terms & Conditions',
            ],
            [
                'title' => 'Privacy Policy',
                'page_title' => 'Privacy Policy',
            ],
            [
                'title' => 'SDS',
                'page_title' => 'SDS',
            ],
            [
                'title' => 'Ethics',
                'page_title' => 'ethics',
            ],
        ])->each(function ($item, $key) {
            CmsPage::create($item);
        });
    }
}
