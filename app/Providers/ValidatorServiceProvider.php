<?php
namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app['validator']->extend('pobox', function ($attribute, $value, $parameters) {
            $address_line_1 = $this->app->request->input($parameters[0]);
            $address_line_2 = $this->app->request->input($parameters[1]);
            $string         = '/(?:P(?:ost(?:al)?)?[\.\-\s]*(?:(?:O(?:ffice)?[\.\-\s]*)?B(?:ox|in|\b|\d)|o(?:ffice|\b)(?:[-\s]*\d)|code)|box[-\s\b]*\d)/i';
            $fullAddress    = $address_line_1 . ' ' . $address_line_2;
            if (preg_match($string, $fullAddress)) {
                return false;
            }
            return true;
        }, 'PO Box address not accepted');
    }

    public function register()
    {
        //
    }
}
