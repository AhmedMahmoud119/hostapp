<?php

namespace App\Http\Helper;

use App\Models\AddToHostBill;
use App\Models\HostJob;
use App\Models\Tld;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;

class HelperTLD
{

    public static function availableTLD($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/order";
        $params = [];
        $response_data = HelperGeneral::curl($url,'GET',$userJawaly,$params);
        $responseArr = json_decode($response_data, true);

        foreach ($responseArr['tlds'] as $tld) {
            Tld::updateOrCreate([
                'tld'=>$tld['tld']
            ], [
                'tld'=>$tld['tld'],
                'tld_id'=>$tld['id'],
            ]);
        }

        return $responseArr;
    }

    public static function tldForm($userJawaly)
    {
        $url = env('API_URL') . '/api/domain/order/'.request()->data['tld_id'].'/form';
        $params = [];
        $response_data = HelperGeneral::curl($url,'GET',$userJawaly,$params);
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function getTLDId($tld)
    {
        $TldModel = Tld::where('tld',$tld)->first();

        return $TldModel->tld_id;
    }

}
