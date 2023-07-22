<?php

namespace App\Http\Helper;

use GuzzleHttp\Client;

class HelperGeneral
{
    public static function useJob($userJobsNotUsed)
    {
        $userJobsNotUsed
            ->update([
                'event_name' => request()->event,
                'status'     => 1,
            ]);
    }

    public static function client($userJawaly)
    {
        $app_hash = base64_encode($userJawaly->email . ':' . $userJawaly->host_password);
        return new Client([
            'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . $app_hash,
            ],
        ]);
    }

    public static function curl($url,$method,$userJawaly,$params){
        $app_hash = base64_encode($userJawaly->email . ':' . $userJawaly->host_password);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json',
                'Authorization: Basic '.$app_hash
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public static function curlPost($url,$userJawaly,$params){
        $app_hash = base64_encode($userJawaly->email . ':' . $userJawaly->host_password);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic '.$app_hash
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
