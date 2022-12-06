<?php

namespace App\Console\Commands;

use App\RedirectUrl;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

class GenerateAllSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:allsites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate All Website Sitemap.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allUrl = RedirectUrl::whereNotNull('domain')->get();
        foreach ($allUrl as $url) {
            $domains[$url->domain][] = $url->old_url;
        }
        foreach ($domains as $domain => $urls) {
            $sitemap = Sitemap::create();
            $path    = $domain . '.xml';
            $path    = str_replace('.com', '', $path);
            $path    = str_replace('.us', '', $path);
            foreach ($urls as $url) {
                $sitemap->add($url);
            }
            $sitemap->writeToFile(public_path($path));
        }
    }
}
