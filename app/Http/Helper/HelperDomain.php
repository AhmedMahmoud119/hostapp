<?php

namespace App\Http\Helper;

use App\Models\AddToHostBill;
use App\Models\HostJob;
use App\Models\Tld;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;

class HelperDomain
{

    public static function searchDomain($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/lookup";
        $params = ['name' => request()->data['name']];

        $response_data = HelperGeneral::curlPost($url, $userJawaly, $params);
        $responseArr = json_decode($response_data, true);
        $responseTldArray = [];
        try {
            $host = parse_url(request()->data['name']);
            $host = str_ireplace('www.', '', $host['host'] ?? ($host['path'] ?? ''));
            $tld = strstr($host, '.');

            $domainWithoutTld = explode('.', $host);
            $domainWithoutTld = $domainWithoutTld[0];

            foreach (Tld::where('tld', '!=', $tld)->get() as $tls) {
                $response = HelperGeneral::curlPost($url, $userJawaly, [
                    'name' => $domainWithoutTld . $tls->tld,
                ]);
                $responseTldArray[] = json_decode($response, true);
            }
        } catch (Exception $exception) {}

        $responseArr['another_domains'] = $responseTldArray;

        return $responseArr;
    }

    public static function listDomains($userJawaly)
    {
        $url = env('API_URL') . "/api/domain";
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('Get', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainDetails($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'];
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('Get', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function createDns($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/dns';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                "name"     => request()->data['name'],
                "type"     => request()->data['type'],
                "priority" => request()->data['priority'],
                "content"  => request()->data['content'],
            ],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateDns($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/dns/' . request()->data['record_id'];
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                "name"     => request()->data['name'],
                "type"     => request()->data['type'],
                "priority" => request()->data['priority'],
                "content"  => request()->data['content'],
            ],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function deleteDns($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/dns/' . request()->data['record_id'];
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('DELETE', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function dnsTypes($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/dns/types';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function dnsRecords($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/dns';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainRenew($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/renew';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                'years'      => request()->data['years'],
                'pay_method' => env('PAY_METHOD'),
            ],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainNs($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/ns';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('Get', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function registerDomainNs($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/reg';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('POST', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateDomainNs($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/ns';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [
                "nameservers" => request()->data['nameservers'],
            ],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainEpp($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/epp';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainSynchronize($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/sync';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainLock($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/reglock';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateDomainLock($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/reglock';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateDomainIdProtection($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/idprotection';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainContact($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/contact';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateDomainContact($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/contact';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainEmforwarding($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/emforwarding';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateDomainEmforwarding($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/emforwarding';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateDomainForwarding($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/forwarding';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainAutorenew($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/autorenew';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function updateDomainAutorenew($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/autorenew';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainFlags($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/dnssec/flags';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function domainDnssec($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/dnssec';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

    public static function addDomainDnssec($userJawaly)
    {
        $url = env('API_URL') . "/api/domain/" . request()->data['id'] . '/dnssec';
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('PUT', $url, [
            \GuzzleHttp\RequestOptions::JSON => [],
        ]);
        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

}
