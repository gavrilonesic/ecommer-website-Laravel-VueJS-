<?php

namespace App\Http\Controllers\Front;

use App\Country;
use App\Http\Controllers\Front\FrontController;
use App\ProductSku;
use App\ShippingSetting;
use App\State;
use Log;

class TestController extends FrontController
{
    public function AddShipping()
    {
        // $shippingSettings = ShippingSetting::get();
        // foreach ($shippingSettings as $shippingSetting) {
        //     if (!empty($shippingSetting->state_id)) {
        //         $state = State::where('id', $shippingSetting->state_id)->where('country_id', $shippingSetting->country_id)->first();
        //         if (empty($state)) {
        //             echo 'Shipping Name: ' . $shippingSetting->title;
        //             echo '<br/>';
        //             echo 'State Name: Empty';
        //             echo '<br/>';
        //             echo '+++++++++++++++++++';
        //             echo '<br/>';
        //         } else {
        //             echo 'Shipping Name: ' . $shippingSetting->title;
        //             echo '<br/>';
        //             echo 'State Name: ' . $state->name;
        //             echo '<br/>';
        //             echo '+++++++++++++++++++';
        //             echo '<br/>';
        //         }
        //     } else if (empty($shippingSetting->state_id) && !empty($shippingSetting->country_id)) {
        //         $country = Country::where('id', $shippingSetting->country_id)->first();
        //         if (empty($country)) {
        //             echo 'Shipping Name: ' . $shippingSetting->title;
        //             echo '<br/>';
        //             echo 'Country Name: Empty';
        //             echo '<br/>';
        //             echo '+++++++++++++++++++';
        //             echo '<br/>';
        //         } else {
        //             echo 'Shipping Name: ' . $shippingSetting->title;
        //             echo '<br/>';
        //             echo 'Country Name: ' . $country->name;
        //             echo '<br/>';
        //             echo '+++++++++++++++++++';
        //             echo '<br/>';
        //         }
        //     } else {
        //         echo 'Shipping Name: Empty';
        //         echo '<br/>';
        //         echo 'Country Name: Empty';
        //         echo '<br/>';
        //         echo '+++++++++++++++++++';
        //         echo '<br/>';
        //     }
        // }
        // die();
        $states = State::where('country_id', 233)->get();
        foreach ($states as $state) {
            $shippingSetting = ShippingSetting::where('state_id', $state->id)->first();
            if (empty($shippingSetting)) {
                echo $state->name;
                echo '<br/>';

            }
        }
        die();
        // $zone1 = ['Arizona','Arkansas', 'Colorado', 'Connecticut', 'Delaware', 'District of Columbia', 'Florida', 'Georgia', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Nebraska', 'New Hampshire', 'New Jersey', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Vermont', 'Virginia', 'West Virginia', 'Wisconsin'];
        // $zone2 = ['Alaska','California', 'Idaho', 'Montana', 'Nevada', 'New Mexico', 'Oregon', 'Texas', 'Utah', 'Wyoming', 'Washington'];
        // $zone3 = ['Alaska', 'American Samoa', 'Micronesia', 'Guam', 'Hawaii', 'Marshall Islands', 'Northern Mariana Islands', 'Palau', 'Puerto Rico', 'Virgin Islands (US)'];

        // $ShippingResult = ShippingSetting::on('mysql2')->find(54); // static method
        // $ShippingResultCon = ShippingSetting::on('mysql2')->find(3); // static method
        // dd($ShippingResultCon);

        // foreach ($zone1 as $zone) {
        //     $state = State::where('name', 'like', "%$zone%")->where('country_id', 231)->first();
        //     if (empty($state)) {
        //         echo 'Name1: ' . $zone;
        //         echo '<br/>';
        //         echo 'Country ID1: Empty';
        //         echo '<br/>';
        //         echo 'State Id1: Empty';
        //         echo '<br/>';
        //         echo '+++++++++++++++++++';
        //         echo '<br/>';
        //     } else {

        //         // $new = $ShippingResult->replicate();
        //         // $new->setConnection('mysql2');
        //         // $new->state_id = $state->id;
        //         // $new->title = $state->name;
        //         // $new->save();
        //         echo 'Name1: ' . $state->name;
        //         echo '<br/>';
        //         echo 'Country ID1: ' . $state->country_id;
        //         echo '<br/>';
        //         echo 'State Id1: ' . $state->id;
        //         echo '<br/>';
        //         echo '+++++++++++++++++++';
        //         echo '<br/>';
        //     }
        // }
        // foreach ($zone2 as $zone) {
        //     $state = State::where('name', $zone)->where('country_id', 231)->first();
        //     if (empty($state)) {
        //         echo 'Name2: ' . $zone;
        //         echo '<br/>';
        //         echo 'Country ID2: Empty';
        //         echo '<br/>';
        //         echo 'State Id2: Empty';
        //         echo '<br/>';
        //         echo '+++++++++++++++++++';
        //         echo '<br/>';
        //     } else {
        //         // $new = $ShippingResult->replicate();
        //         // $new->setConnection('mysql2');
        //         // $new->state_id = $state->id;
        //         // $new->title = $state->name;
        //         // $new->save();
        //         echo 'Name2: ' . $state->name;
        //         echo '<br/>';
        //         echo 'Country ID2: ' . $state->country_id;
        //         echo '<br/>';
        //         echo 'State Id2: ' . $state->id;
        //         echo '<br/>';
        //         echo '+++++++++++++++++++';
        //         echo '<br/>';
        //     }
        // }
        foreach ($zone3 as $zone) {
            $state = State::where('name', 'like', "%$zone%")->where('country_id', 231)->first();
            if (empty($state)) {
                $country = Country::where('name', $zone)->first();
                if (empty($country)) {
                    echo 'Name3: ' . $zone;
                    echo '<br/>';
                    echo 'Country ID3: Empty';
                    echo '<br/>';
                    echo 'State Id3: Empty';
                    echo '<br/>';
                    echo '+++++++++++++++++++';
                    echo '<br/>';
                } else {
                    // $new = $ShippingResult->replicate();
                    // $new->setConnection('mysql2');
                    // $new->country_id = $country->id;
                    // $new->title = $country->name;
                    // $new->state_id = Null;
                    // $new->state_name = Null;
                    // $new->shipping_zone = 0;
                    // $new->save();
                    echo 'Name3: ' . $country->name;
                    echo '<br/>';
                    echo 'Country ID3: ' . $country->id;
                    echo '<br/>';
                    echo 'State Id3: Empty';
                    echo '<br/>';
                    echo '+++++++++++++++++++';
                    echo '<br/>';
                }
            } else {
                // $new = $ShippingResult->replicate();
                // $new->setConnection('mysql2');
                // $new->state_id = $state->id;
                // $new->title = $state->name;
                // $new->save();
                echo 'Name3: ' . $state->name;
                echo '<br/>';
                echo 'Country ID3: ' . $state->country_id;
                echo '<br/>';
                echo 'State Id3: ' . $state->id;
                echo '<br/>';
                echo '+++++++++++++++++++';
                echo '<br/>';
            }
        }
        die();
    }

    public function index()
    {
        $productSkus = ProductSku::with(['medias', 'product', 'productSkuValues'])->get();
        $delProducts = array();
        $pmediaId    = array();
        $skuId       = array();
        $skuValueId  = array();
        $mediaId     = array();
        foreach ($productSkus as $productSku) {
            if (empty($productSku->product)) {
                if (!in_array($productSku->product_id, $delProducts)) {
                    $delProducts[] = $productSku->product_id;
                    $skuId[]       = $productSku->id;
                    $skuValueId[]  = $productSku->productSkuValues->pluck('id')->toArray();
                    $medias        = $productSku->getMedia('product');
                    foreach ($medias as $media) {
                        $mediaId[] = $media->id;
                        $media->delete();
                    }
                    $pMedias = \App\Media::where('model_id', $productSku->product_id)->where('model_type', "App\Product");
                    foreach ($pMedias as $media) {
                        $pmediaId[] = $media->id;
                        $media->delete();
                    }
                    $productSku->productSkuValues()->delete();
                    $productSku->delete();
                }
            }
        }
        Log::info(json_encode($delProducts));
        Log::info(json_encode($pmediaId));
        Log::info(json_encode($skuId));
        Log::info(json_encode($mediaId));
        Log::info(json_encode($skuValueId));
        echo 'success';
    }
}
