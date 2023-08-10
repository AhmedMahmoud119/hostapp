<?php

namespace App\Http\Helper;


class HelperCertificate
{

    public static function listAvailableCertificates($userJawaly)
    {
        $url = env('API_URL') . "/api/certificate/order";
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, []);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function listCertificates($userJawaly)
    {
        $url = env('API_URL') . "/api/certificate";
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, []);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function orderCertificate($userJawaly)
    {
        $url = env('API_URL') . "/api/certificate/order";
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                "product_id"     => request()->data['product_id'],
                "csr"            => request()->data['csr'],
                "years"          => request()->data['years'],
                "pay_method"     => env('PAY_METHOD'),
                "approver_email" => request()->data['approver_email'],
                "admin"          => request()->data['admin'],
                "tech"           => request()->data['tech'],
                "billing"        => request()->data['billing'],
                "organization"   => request()->data['organization'],
                "software"       => request()->data['software'],
//                "data"           => request()->data['data']??[],
            ],
        ]);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function certificateDetails($userJawaly)
    {
        $url = env('API_URL') . "/api/certificate/".request()->data['id'];
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, []);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

}
