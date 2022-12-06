<?php

namespace App\Http\Controllers\Front;

use Session;
use App\State;
use App\Country;
use App\UserAddress;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\BillingAddressRequest;
use App\Http\Controllers\Front\FrontController;

class AddressController extends FrontController
{
    public function billingAddress(BillingAddressRequest $request)
    {
        $request->session()->put('billing_details', $this->requestWithoutHoneyPotInput($request));
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function shippingAddress(RegistrationRequest $request)
    {
        if (auth()->guard('web')->check() && (int) $request->input('address') > 0) {

            $userAddress = UserAddress::findOrFail(
                $request->input('address')
            );

            $request->merge([
                'state_id' => $userAddress->state_id,
                'zip_code' => $userAddress->zip_code,
                'address_line_1' => $userAddress->address_line_1,
                'address_line_2' => $userAddress->address_line_2,
                'city_name' => $userAddress->city_name,
                'email' => $userAddress->email ?? $request->user()->email,
            ]);
        }

        session(['email' => $request->input('email', '')]);

        $address = $this->requestWithoutHoneyPotInput($request);
        $request->session()->put('shipping_details', $address);

        if ((int)$request->country_id === Country::firstWhere('iso2', 'US')->id) {
            try {
                $response = app('UpsHandler')->initUpsRepository($request)->validate();
            } catch (\Exception $e) {
                throw new \Exception("Invalid Address, please check your address");
            }

            if ($response === false) {
                throw new \Exception("Invalid address");
            }

            if ($response->noCandidates()) {
                throw new \Exception("Invalid address");
            }

            if ($response->isAmbiguous()) {
                $candidateAddresses = $response->getCandidateAddressList();
                return response()->json($candidateAddresses, 500);
            }

            if (! $response->isValid()) {
                throw new \Exception("Invalid address");
            }

            $validatedAddress = $response->getValidatedAddress();

            $address['address_line_1'] = $validatedAddress->addressLine;
            $address['zip_code'] = $validatedAddress->postcodePrimaryLow;

            if ($validatedAddress->postcodeExtendedLow !== null && trim($validatedAddress->postcodeExtendedLow) !== '') {
                $address['zip_code'] .= '-' . $validatedAddress->postcodeExtendedLow;
            }
        } else {
            $country = Country::findOrFail($address['country_id']);

            if (isset($address['state_name'])) {
                $state = State::firstOrCreate([
                    'name' => $address['state_name'],
                    'country_id' => $country->id,
                    'country_code' => $country->iso2,
                ], [
                    'state_code' => $address['state_name'],
                ]);
            } elseif (isset($address['state_id'])) {
                $state = State::findOrFail($address['state_id'])->state_code;
            }

            $region = collect([
                $address['city_name'] ?? null,
                $state,
                $address['zip_code'] ?? null,
            ])->reject(fn($q) => empty($q))->implode(' ');

            $validatedAddress = [
                'addressClassification' => [
                    'code'        => ['0' => '1'],
                    'description' => ['0' => 'Commercial']
                ],
                "consigneeName" => "",
                "buildingName" => "",
                "addressLine" => $address['address_line_1'],
                "addressLine2" => empty($address['address_line_2']) ? null : $address['address_line_2'],
                "addressLine3" => null,
                "region" => $region,
                "politicalDivision2" => $address['city_name'] ?? '',
                "politicalDivision1" => $state,
                "postcodePrimaryLow" => $address['zip_code'] ?? '',
                "postcodeExtendedLow" => "",
                "urbanization" => "",
                "countryCode" => empty($country) ? 'US' : $country->iso2,
            ];
        }

        $request->session()->put('shipping_details', $address);

        return response()->json([
            'address' => addressToString($address),
            'validAddress' => $validatedAddress,
            'status'  => "success"
        ]);
    }

    /**
     * @return jsonResponse
     */
    public function addressConfirmation(Request $request)
    {
        $request->validate([
            'addressLine' => 'required',
            'region' => 'required',
            'politicalDivision1' => 'required',
            'politicalDivision2' => 'required',
            'postcodePrimaryLow' => 'required',
            'countryCode' => 'required',
        ]);

        $country = Country::where('iso2', $request->countryCode)->firstOrFail();

        $state = State::where('state_code', $request->politicalDivision1)
            ->where('country_code', $request->countryCode)
            ->firstOrFail();

        $zipcode = $request->postcodePrimaryLow;

        if (trim($request->input('postcodeExtendedLow')) !== '') {
            $zipcode .= '-' . $request->input('postcodeExtendedLow');
        }

        $address = [
            'address_line_1' => $request->input('addressLine'),
            'address_line_2' => trim($request->input('addressLine2') . ' ' . $request->input('addressLine3')),
            'country_id' => $country->id,
            'state_id' => $state->id,
            'state_name' => $state->name,
            'city_name' => $request->politicalDivision2,
            'zip_code' => $zipcode,
        ];

        $address = array_merge(session('shipping_details', []), $address);

        $request->session()->put('shipping_details', $address);

        return response()->json([
            'address' => addressToString($address),
            'status'  => "success",
        ]);
    }

    /**
     * return specific country state
     *
     * @return \Illuminate\Http\Response
     */
    public function getState(Request $request)
    {
        return response()->json([
            'state'  => State::where('country_id', $request->country_id)->select('name', 'id')->orderBy('name', 'asc')->get(),
            'status' => 'success',
        ]);
    }

    /**
     * Returns the request input without fields used to combat spam
     * through the usage of spatie/laravel-honeypot on the form
     *
     * @param  Request $request
     * @return array
     */
    private function requestWithoutHoneyPotInput(Request $request): array
    {
        return array_filter($request->except('valid_from'), function($key) {
            return !Str::startsWith($key, 'spam_field');
        }, ARRAY_FILTER_USE_KEY);
    }
}
