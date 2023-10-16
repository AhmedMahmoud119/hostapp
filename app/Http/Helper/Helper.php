<?php

namespace App\Http\Helper;

use App\Models\AddToHostBill;
use App\Models\HostJob;
use App\Models\Tld;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;

class Helper
{

    public static function verifyUserjawaly()
    {
        try {
            $curl = curl_init();
            $app_hash = base64_encode(request()->api_key . ':' . request()->api_secret);

            $url = env('link_auth','https://api-sms.4jawaly.com/api/v1/account/area/me');

            curl_setopt_array($curl, [
                    CURLOPT_URL => "$url",
//                CURLOPT_URL            => 'https://api-sms-dev.4jawaly.com/api/v1/account/area/me',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'GET',
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Basic ' . $app_hash,
                ],
            ]);

            $jawaly_data = curl_exec($curl);

            curl_close($curl);

            $jawaly = json_decode($jawaly_data, true);

            if (isset($jawaly['code']) && $jawaly['code'] != 200) {
                return $jawaly;
            }

            $user = User::firstOrCreate([
                'jawaly_account_id' => $jawaly['items']['account_id'],
                'jawaly_id'         => $jawaly['items']['id'],
            ], [
                'name'              => $jawaly['items']['name'],
                'email'             => $jawaly['items']['email'],
                'jawaly_data'       => $jawaly_data,
                'jawaly_account_id' => $jawaly['items']['account_id'],
                'jawaly_id'         => $jawaly['items']['id'],
                'jawaly_mobile'     => $jawaly['items']['mobile'],
            ]);

            return $user;
        } catch (Exception $e) {
            return $e->getMessage();
            //            return $e->getResponse()->getBody()->getContents();
        }

    }

    public static function generateJobId($jawaly_account_id)
    {
        $randomFirstChar = chr(rand(97, 122));
        $randomSecondChar = chr(rand(97, 122));

        $firstPart = $randomFirstChar . $randomSecondChar . substr(sha1(mt_rand()), 1, 7) . '-' . rand(0, 9);

        $secondPart = $jawaly_account_id . $randomFirstChar . substr(sha1(mt_rand()), 1,
                11) . '-' . substr(sha1(mt_rand()), 1, 13) . $randomSecondChar . $jawaly_account_id;


        $jop_id = $firstPart . $secondPart;

        return $jop_id;
    }

    public static function addHostBill($userJawaly)
    {
        //        try {
        $url = env('API_URL') . "/admin/api.php";

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
        ]);

        $password = substr(sha1(mt_rand()), 1, 15);

        $response = $client->request('GET', $url, [
            'query' => [
                'call'      => 'addClient',
                'api_id'    => env('API_ID'),
                'api_key'   => env('API_KEY'),
                'firstname' => 'MR',
                'lastname'  => $userJawaly['name'],
                'email'     => $userJawaly['email'],
                //                    'email'     => 'a2@a.a',
                'password'  => $password,
                'password2' => $password,
            ],
        ]);


        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        if (isset($responseArr['client_id']) && $responseArr['success'] == true) {

            $userJawaly->update([
                'host_bill_id'  => $responseArr['client_id'],
                'host_password' => $password,
            ]);

            AddToHostBill::create([
                'user_id'      => $userJawaly->id,
                'host_bill_id' => $responseArr['client_id'],
                'error_code'   => 200,
                'message'      => $responseArr['info'][0],
                'data'         => $response_data,
            ]);

            return 1;

        } else if (isset($responseArr['error'])) {

            AddToHostBill::updateOrCreate([
                'user_id'    => $userJawaly->id,
                'error_code' => 401,
            ], [
                'user_id'      => $userJawaly->id,
                'host_bill_id' => $userJawaly->host_bill_id,
                'error_code'   => 401,
                'message'      => $responseArr['error'][0],
                'data'         => $response_data,
            ]);

            return 0;
        }


        return true;
    }

    public static function sendNotification($event, $data)
    {
        try {
            $url = "https://hook.us1.make.com/oqgq8y6g448mpccb0bsu17ssdngvvbji";

            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                ],
            ]);

            $response = $client->request('GET', $url, [
                \GuzzleHttp\RequestOptions::JSON => [
                        'event'    => $event,
                        'response' => $data,
                        'ip'       => request()->ip(),
                    ] + request()->all(),
            ]);
        } catch (Exception $exception) {}

        return true;
    }

    public static function getHostBillData($userJawaly)
    {
        //        try {
        $url = env('API_URL') . "/api/details";
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, []);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateHostBillData($userJawaly)
    {
        //        try {
        $url = env('API_URL') . "/api/details";
        $client = HelperGeneral::client($userJawaly);
        $response = $client->request('PUT', $url, [
            'json' => [
                "email" => $userJawaly->email,
            ],
        ]);

        //        $response_data = $response->getBody()->getContents();
        //        $responseArr = json_decode($response_data, true);

        return true;
    }

    public static function orderDomain($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/order";
        $client = HelperGeneral::client($userJawaly);
        $host = parse_url(request()->data['name']);
        $host = str_ireplace('www.', '', $host['host'] ?? ($host['path'] ?? ''));
        $tld = strstr($host, '.');
        $TldModel = Tld::where('tld', $tld)->first();

        $data = [
            'name'       => request()->data['name'],
            'years'      => request()->data['years'],
            'action'     => request()->data['action'],// register | transfer
            'tld_id'     => $TldModel->tld_id,
            'pay_method' => env('PAY_METHOD'),
        ];
        if (request()->data['action'] == 'transfer') {
            $data += ['epp' => request()->data['epp']];
        }
        $response = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => $data,
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function invoicePaid($invoiceID)
    {
        //        try {
        $url = env('API_URL') . "/admin/api.php";

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
        ]);

        $response = $client->request('GET', $url, [
            'query' => [
                'call'    => 'setInvoiceStatus',
                'api_id'  => env('API_ID'),
                'api_key' => env('API_KEY'),
                'id'      => $invoiceID,
                'status'  => 'Paid',
            ],
        ]);


        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);


        return true;
    }

    public static function setOrderActive($orderId)
    {
        //        try {
        $url = env('API_URL') . "/admin/api.php";

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
        ]);

        $response = $client->request('GET', $url, [
            'query' => [
                'call'    => 'setOrderActive',
                'api_id'  => env('API_ID'),
                'api_key' => env('API_KEY'),
                'id'      => $orderId,
            ],
        ]);


        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function getOrderId($invoiceID)
    {
        //        try {
        $url = env('API_URL') . "/admin/api.php";

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
        ]);

        $response = $client->request('GET', $url, [
            'query' => [
                'call'    => 'getInvoiceDetails',
                'api_id'  => env('API_ID'),
                'api_key' => env('API_KEY'),
                'id'      => $invoiceID,
            ],
        ]);


        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);


        return $responseArr;
    }

    public static function addContact($userJawaly)
    {
        $url = env('API_URL') . "/admin/api.php";

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
        ]);

        $response = $client->request('GET', $url, [
            'query' => [
                'call'        => 'addClientContact',
                'api_id'      => env('API_ID'),
                'api_key'     => env('API_KEY'),
                'id'          => $userJawaly->host_bill_id,
                'firstname'   => request()->data['firstname'],
                'lastname'    => request()->data['lastname'],
                'email'       => request()->data['email'],
                'password'    => $userJawaly->host_password,
                'password2'   => $userJawaly->host_password,
                "address1"    => isset(request()->data['address1']) ? request()->data['address1'] : '',
                "city"        => isset(request()->data['city']) ? request()->data['city'] : '',
                "state"       => isset(request()->data['state']) ? request()->data['state'] : '',
                "postcode"    => isset(request()->data['postcode']) ? request()->data['postcode'] : '',
                "country"     => isset(request()->data['country']) ? request()->data['country'] : '',
                "phonenumber" => isset(request()->data['phonenumber']) ? request()->data['phonenumber'] : '',
            ],
        ]);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function getContacts($userJawaly)
    {
        $url = env('API_URL') . "/admin/api.php";

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ],
        ]);

        $response = $client->request('GET', $url, [
            'query' => [
                'call'    => 'getClientContacts',
                'api_id'  => env('API_ID'),
                'api_key' => env('API_KEY'),
                'id'      => $userJawaly->host_bill_id,
            ],
        ]);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function getProducts($userJawaly, $withDetails = 0)
    {
        $url = env('API_URL') . "/api/category/" . request()->data['category_id'] . "/product";
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        foreach ($responseArr['products'] as $key => $response) {
            $del = ['<br>', '<br/>', '<ul>', '<li>', '</ul>', '</li>'];
            $arr = explode($del[0], str_replace($del, $del[0], $response['description']));
            $description = array_values(array_filter($arr));
            $responseArr['products'][$key]['description'] = $description;

            if ($withDetails) {
                $getProductConfigurationDetails = HelperProduct::getProductConfigurationDetails($userJawaly,
                    $response['id']);

                $responseArr['products'][$key]['configuration_details'] = $getProductConfigurationDetails;
            }

        }


        return $responseArr;
    }

    public static function orderProduct($userJawaly)
    {
        $url = env('API_URL') . "/api/order/" . request()->data['product_id'];
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                'domain'     => request()->data['domain'],
                'cycle'      => request()->data['cycle'],
                'custom'     => isset(request()->data['custom']) ? request()->data['custom'] : [],
                'pay_method' => env('PAY_METHOD'),
            ],
        ]);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function getCategories($userJawaly)
    {
        $url = env('API_URL') . "/api/category";
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function saveHostBillResponse($userJawaly, $data, $error_code)
    {
        HostJob::where('user_id', $userJawaly->id)->where('job_id', request()->job_id)->update([
            'error_code' => $error_code,
            'message'    => null,
            'json'       => json_encode($data, true),
        ]);

        Helper::sendNotification(request()->event, json_encode($data, true));
    }
}
