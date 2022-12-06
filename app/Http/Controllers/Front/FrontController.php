<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\CmsPage;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use OpenGraph;

class FrontController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->common();
    }

    /**
     * .
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function common()
    {
        config(['seotools.meta.defaults.title' => setting('default_meta_title')]);
        config(['seotools.meta.defaults.description' => setting('default_meta_description')]);
        config(['seotools.meta.defaults.keywords' => [setting('default_meta_keywords')]]);
        config(['seotools.meta.webmaster_tags.google' => setting('webmaster_tags_google')]);
        config(['seotools.meta.webmaster_tags.bing' => setting('webmaster_tags_bing')]);
        config(['seotools.meta.webmaster_tags.alexa' => setting('webmaster_tags_alexa')]);

        if (empty(setting('index_website_on_search_engine')) && setting('index_website_on_search_engine') == 0) {
            SEOMeta::setRobots('noindex, nofollow');
        } else {
            SEOMeta::setRobots('index, follow');
        }

        SEOTools::jsonLd()->setType('Corporation');
        SEOTools::jsonLd()->addValue('logo', url('images/gcc-logo.png'));
        // SEOTools::jsonLd()->addValue('hasMap', url('https://maps.google.com/maps?cid=1551440762048831606'));
        JsonLd::addValue('contactPoint', [
            "@type"       => "ContactPoint",
            "contactType" => "Sales",
            "telephone"   => setting('mobile_no'),
            "email"       => setting('email'),
        ]);
        JsonLd::addValue('LocalBusiness', [
            "@type"           => "LocalBusiness",
        ]);
        JsonLd::addValue('contactPoint', [
            "@type"       => "ContactPoint",
            "contactType" => "customer service",
            "telephone"   => setting('mobile_no'),
        ]);
        JsonLd::addValue('address', [
            "@type"           => "PostalAddress",
            "streetAddress"   => setting('address_line1') . ', ' . setting('address_line2'),
            "addressLocality" => setting('city'),
            "addressRegion"   => setting('state'),
            "postalCode"      => setting('zipcode'),
            "addressCountry"  => setting('country'),
        ]);
        JsonLd::addValue('potentialAction', [
            "@type"  => "SearchAction",
            "target" => route('store', ['search_query' => "{query}"]),
            "query"  => 'required',
            "target" => urldecode(route('store', ['search_query' => "{search_term_string}"])),
            "query-input"  => 'required name=search_term_string',
        ]);
        JsonLd::addValue('sameAs', [
            setting('dribbble_link'),
            setting('twitter_link'),
            setting('facebook_link'),
            setting('youtube_link'),
        ]);

        $categories = Category::with(['childs' => function ($query) {
            $query->orderBy('name', 'asc');
            $query->active()->with(['childs' => function ($query) {
                $query->active();
                $query->orderBy('name', 'asc');
            }]);
        }, 'medias' => function ($query) {
            $query->where('collection_name', 'category');
        }])->where('parent_id', 0)->orderBy('name', 'asc')->active()->get();
        $slug = Request::segment(count(Request::segments()));
        if (empty($slug)) {
            $slug = 'home';
        }
        $pageData = CmsPage::with('medias')->where('slug', $slug)->first();
        if (!empty($pageData)) {
            SEOMeta::setTitle($pageData->page_title);
            SEOMeta::setDescription($pageData->meta_tag_description);
            SEOMeta::addKeyword($pageData->meta_tag_keywords);
            if (!empty($pageData->medias) && $pageData->medias->count() > 0) {
                OpenGraph::addImage($pageData->medias->getFullUrl());
            }
        }else{
            if(config('constants.PAGE_META_TITLE.'.$slug))
            {
                SEOMeta::setTitle(config('constants.PAGE_META_TITLE.'.$slug));
            }
        }
        View::share('pageData', $pageData);
        View::share('categories', $categories);
    }
}
