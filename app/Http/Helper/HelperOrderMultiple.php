<?php

namespace App\Http\Helper;

use App\Models\AddToHostBill;
use App\Models\HostJob;
use App\Models\Tld;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;

class HelperOrderMultiple
{

    public static function orderMultiple($userJawaly)
    {
        $url = env('API_URL') . "/api/order";
        $client = HelperGeneral::client($userJawaly);
        $arrData = [];
        foreach(request()->data as $data) {
            if ($data['type'] == 'domain') {
                $host = parse_url($data['name']);
                $host = str_ireplace('www.', '', $host['host']??($host['path']??''));
                $tld = strstr($host, '.');
                $TldModel = Tld::where('tld',$tld)->first();
                $data['tld_id'] = $TldModel->tld_id??'';
            }
            $arrData[] = $data;
        }


        $response = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                'pay_method' => env('PAY_METHOD'),
                'items'      => [$arrData]
            ],
        ]);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);


        return $responseArr;
    }
}
