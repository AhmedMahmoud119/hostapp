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

        $id = request()->data['product_id'];

        $urlCertificate = env('API_URL') . "/api/certificate/order/$id/software";

        $response = $client->request('GET', $urlCertificate, []);

        $response_data = $response->getBody()->getContents();

        $responseArr = json_decode($response_data, true);

        $software = $responseArr['software'][0]['id']??null;
//        $software = 1000;
        $dn = array(
            "emailAddress" => "wez@example.com"
        );

        $csrSettings = array('private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA, 'encrypt_key' => true);

        // Generate a new private (and public) key pair
        $privkey = openssl_pkey_new($csrSettings);

        // Generate a certificate signing request
        $csr = openssl_csr_new($dn, $privkey, $csrSettings);

        openssl_csr_export($csr, $csrout);


        $response = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                "product_id"     => $id,
                "domain"         => request()->data['domain'],
                "pay_method"     => env('PAY_METHOD'),
                "years"          => request()->data['years'],
                "cert_email"     => request()->data['cert_email'],
                "software"       => $software,
                "csr"            => $csrout,

//                "approver_email" => request()->data['approver_email'],
//                "admin"          => request()->data['admin'],
//                "tech"           => request()->data['tech'],
//                "billing"        => request()->data['billing'],
//                "organization"   => request()->data['organization'],
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
