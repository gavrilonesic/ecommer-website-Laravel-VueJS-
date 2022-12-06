<?php

namespace App\Http\Middleware;

use App\RedirectUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectOnOldUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     * @throws \Illuminate\Routing\Exceptions\UrlGenerationException
     */
    public function handle(Request $request, \Closure $next)
    {
        $domainDefaultArray = [
            "cmichem.com"                           => \Config::get('app.url'),
            "auto-chemicals.com"                    => \Config::get('app.url') . "/category/car-care",
            "carpetcleanchemicals.com"              => \Config::get('app.url') . "/category/carpet-cleaning",
            "deckchemicals.com"                     => \Config::get('app.url') . "/category/deck-paver",
            "vanishingoil.com"                      => \Config::get('app.url') . "/category/vanishing-oil",
            "foundrychem.com"                       => \Config::get('app.url') . "/category/foundry",
            "solderingfluxes.com"                   => \Config::get('app.url') . "/category/soldering-fluxes",
            "metallubricant.com"                    => \Config::get('app.url') . "/category/lubricants",
            "removepaints.com"                      => \Config::get('app.url') . "/category/paint-strippers",
            "paintboothchemicals.com"               => \Config::get('app.url') . "/category/paint-booth-maintenance",
            "strippablecoating.com"                 => \Config::get('app.url') . "/category/strippable-coatings",
            "containercleaningchemicals.com"        => \Config::get('app.url') . "/category/container-cleaning",
            "paintstripper-chemical.com"            => \Config::get('app.url') . "/category/paint-strippers",
            "tankcleaningchemicals.com"             => \Config::get('app.url') . "/category/container-cleaning",
            "vanishinglubricant.com"                => \Config::get('app.url') . "/category/vanishing-oil",
            "paintstripperproducts.com"             => \Config::get('app.url') . "/category/paint-strippers",
            "paintbooth-coating.com"                => \Config::get('app.url') . "/category/paint-booth-maintenance",
            "paintboothproducts.com"                => \Config::get('app.url') . "/category/paint-booth-maintenance",
            "paintstripper.us"                      => \Config::get('app.url') . "/category/paint-strippers",
            "peelablecoating.com"                   => \Config::get('app.url') . "/category/strippable-coatings",
            "generalchemicalcorp.mybigcommerce.com" => \Config::get('app.url') . "/store",
            "aluminum-wheel-stripper.com"           => \Config::get('app.url') . "/category/aluminum-paint-stripper",
            "aluminumpaintstripper.com"             => \Config::get('app.url') . "/category/aluminum-paint-stripper",
            "aluminum-wheel-stripping.com"          => \Config::get('app.url') . "/category/aluminum-paint-stripper",
            "aluminumwheelstrip.com"                => \Config::get('app.url') . "/category/aluminum-paint-stripper",
            "aluminumwheelsrepair.com"              => \Config::get('app.url') . "/category/aluminum-paint-stripper",
            "aluminumwheelstrippers.com"            => \Config::get('app.url') . "/category/aluminum-paint-stripper",
            "stripaluminumwheels.com"               => \Config::get('app.url') . "/category/aluminum-paint-stripper",
            "powdercoatremover.com"                 => \Config::get('app.url') . "/category/powder-coating-strippers",
            "powdercoat-remover.com"                => \Config::get('app.url') . "/category/powder-coating-strippers",
            "powdercoatremovers.com"                => \Config::get('app.url') . "/category/powder-coating-strippers",
            "powdercoatstrippers.com"               => \Config::get('app.url') . "/category/powder-coating-strippers",
            "powdercoatingstrippers.com"            => \Config::get('app.url') . "/category/powder-coating-strippers",
            "powdercoatingremovers.com"             => \Config::get('app.url') . "/category/powder-coating-strippers",
        ];
        $domain  = $request->getHttpHost();
        $path    = $request->getRequestUri();
        $url     = $request->url();
        $fullUrl = $request->fullUrl();
        if ($domain == $this->urlToDomain(\Config::get('app.url'))) {
            $slug       = ltrim($path, "/");
            $diffDomain = false;
        } else {
            $slug       = $url;
            $diffDomain = true;
        }
        if ($oldSlug = $this->findOldUrl($slug, $fullUrl)) {
            // if ($diffDomain) {
            $oldSlug->new_url = \Config::get('app.url') . '/' . $oldSlug->new_url;
            // }
            $finalUrl = $this->redirectUrl($oldSlug->new_url);
            return new RedirectResponse($finalUrl, 301);
        } elseif ($diffDomain) {
            if (!empty($domainDefaultArray[$domain])) {
                $finalUrl = $domainDefaultArray[$domain];
            } else {
                $finalUrl = $this->redirectUrl(\Config::get('app.url'));
            }
            return new RedirectResponse($finalUrl, 301);
        }

        return $next($request);
    }

    private function findOldUrl($slug, $fullUrl)
    {
        $slug      = urldecode(rtrim($slug, "/"));
        $slug1     = $slug . '/';
        $fullMatch = RedirectUrl::where('old_url', $fullUrl)->first();
        if (!empty($fullMatch)) {
            return $fullMatch;
        } else {
            return RedirectUrl::where('old_url', $slug)->orWhere('old_url', $slug1)->first();
        }
    }
    private function urlToDomain($url)
    {
        $host = @parse_url($url, PHP_URL_HOST);
        // If the URL can't be parsed, use the original URL
        // Change to "return false" if you don't want that
        if (!$host) {
            $host = $url;
        }

        // The "www." prefix isn't really needed if you're just using
        // this to display the domain to the user
        if (substr($host, 0, 4) == "www.") {
            $host = substr($host, 4);
        }

        // You might also want to limit the length if screen space is limited
        if (strlen($host) > 50) {
            $host = substr($host, 0, 47) . '...';
        }

        return $host;
    }
    private function redirectUrl($url)
    {
        if ($this->urlToDomain($url) == $url) {
            return url($url);
        } else {
            return $url;
        }

    }
}
