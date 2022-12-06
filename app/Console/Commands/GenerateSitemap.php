<?php

namespace App\Console\Commands;

use App\Category;
use App\CmsPage;
use App\Product;
use File;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

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
        $pages      = CmsPage::get();
        $categories = Category::active()->get();
        $products   = Product::active()->get();
        $fixPages   = array('store', 'sds', 'contact-us');

        $sitemapIndex = SitemapIndex::create();
        if ($pages->count() > 0) {
            $pagesSitemap = Sitemap::create();
            $sitemapName  = 'pages_sitemap.xml';
            foreach ($pages as $page) {

                if ($page->slug == 'home') {
                    $pagesSitemap->add(Url::create('/')->setPriority(0.9));
                } elseif (!in_array($page->slug, $fixPages)) {
                    $pagesSitemap->add(Url::create('pages/' . $page->slug)->setLastModificationDate($page->updated_at));
                } else {
                    $pagesSitemap->add(Url::create($page->slug)->setLastModificationDate($page->updated_at));
                }
            }
            $pagesSitemap->add(Url::create('/login'));
            $pagesSitemap->add(Url::create('/register'));
            $pagesSitemap->writeToFile(public_path($sitemapName));
            $sitemapIndex->add($sitemapName);
        }
        if ($categories->count() > 0) {
            $categoriesSitemap = Sitemap::create();
            $sitemapName       = 'categories_sitemap.xml';
            foreach ($categories as $category) {
                $categoriesSitemap->add(Url::create('category/' . $category->slug)->setLastModificationDate($category->updated_at));
            }
            $categoriesSitemap->writeToFile(public_path($sitemapName));
            $sitemapIndex->add($sitemapName);
        }
        if ($products->count() > 0) {
            $productsSitemap = Sitemap::create();
            $sitemapName     = 'products_sitemap.xml';
            foreach ($products as $product) {
                $productsSitemap->add(Url::create('product/' . $product->slug)->setLastModificationDate($product->updated_at));
            }
            $productsSitemap->writeToFile(public_path($sitemapName));
            $sitemapIndex->add($sitemapName);
        }
        if ($categories->count() > 0) {
            $categoriesSitemap = Sitemap::create();
            $sitemapName       = 'store_sitemap.xml';
            foreach ($categories as $category) {
                if (!empty($category->parent)) {
                    $categoriesSitemap->add(Url::create('store?category=' . $category->slug)->setLastModificationDate($category->updated_at));
                }
            }
            $categoriesSitemap->writeToFile(public_path($sitemapName));
            $sitemapIndex->add($sitemapName);
        }
        if (File::exists(public_path('generalchem.xml'))) {
            $sitemapIndex->add('generalchem.xml');
        }
        $sitemapIndex->writeToFile(public_path('sitemap.xml'));

        // SitemapGenerator::create(config('app.url'))
        //     ->writeToFile(public_path('sitemap.xml'));
    }
}
