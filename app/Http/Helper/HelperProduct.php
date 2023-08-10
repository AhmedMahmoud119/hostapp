<?php

namespace App\Http\Helper;

class HelperProduct
{
    public static function getProductConfigurationDetails($userJawaly,$product_id=null)
    {
        $product_id = $product_id?$product_id:request()->data['product_id'];
        $url = env('API_URL') . "/api/order/".$product_id;
        $client = HelperGeneral::client($userJawaly);

        $response = $client->request('GET', $url, []);

        $response_data = $response->getBody()->getContents();
        $responseArr = json_decode($response_data, true);

        return $responseArr;
    }

}
