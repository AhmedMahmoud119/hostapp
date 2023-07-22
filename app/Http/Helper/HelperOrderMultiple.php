<?php

namespace App\Http\Helper;

use App\Models\AddToHostBill;
use App\Models\HostJob;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;

class HelperOrderMultiple
{

    public static function orderMultiple($userJawaly)
    {
        $url = env('API_URL') . "/api/order";
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('POST', $url, [

            \GuzzleHttp\RequestOptions::JSON => [
                'pay_method' => env('PAY_METHOD'),
                'items'      => request()->data
            ],

        ]);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);


        return $responseArr;
    }
}
