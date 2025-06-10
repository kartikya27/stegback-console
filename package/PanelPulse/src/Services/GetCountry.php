<?php

namespace Kartikey\PanelPulse\Services;

use Illuminate\Support\Facades\Http;

class GetCountry
{

    public function getCurrentCountry($ip)
    {
        $json = file_get_contents('https://freegeoip.app/json/' . $ip);  //Get the JSON
        $data = json_decode(trim($json));                               //Decode it into an array
        return [
            'country' => $data->country_name,
            //            'city' => $data->region_code,
            'latitude' => $data->latitude,
            //            'longitude' => $data->longitude,
            //            'timezone'=>$data->time_zone
            //            'currency'=> $data->currency['symbol']
            //                'currencyCode'=>'USD',
            //        ];
        ];
    }

    // public function countryList()
    // {
    //     $json = file_get_contents('https://restcountries.com/v3.1/all?fields=name');
    //     $data = json_decode(trim($json));
    //     $countryName = [];
    //     foreach ($data as $country) {
    //         $countryName[]  = $country->name->common;
    //     }
    //     return $countryName;
    // }

    function getCountryAuthToken()
    {
        $token = '2NTLwWssJglSMLt6VpfSlXPybQsId8d4Bq_10SsfBA4Rhp3IvjUT8ZENHoGgOJBjhGg';

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'api-token' => $token,
            'user-email' => 'kartikya27@gmail.com',
        ])->get('https://www.universal-tutorial.com/api/getaccesstoken');
        return $response;
    }

    public function countryList()
    {
        $token = $this->getCountryAuthToken();
        $country = Http::withHeaders([
            'Authorization' => "Bearer " . $token['auth_token'],
            'Accept' => 'application/json',
        ])->get('https://www.universal-tutorial.com/api/countries/');

        return $country->json();
    }

    public function StateList($country)
    {
        $token = $this->getCountryAuthToken();
        $state = Http::withHeaders([
            'Authorization' => "Bearer " . $token['auth_token'],
            'Accept' => 'application/json',
        ])->get('https://www.universal-tutorial.com/api/states/' . $country);

        return $state->json();
    }
}
