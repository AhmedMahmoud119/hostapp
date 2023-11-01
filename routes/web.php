<?php

use App\Http\Helper\HelperGeneral;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $client = new \GuzzleHttp\Client([
        'base_uri' => 'https://dh-v1.4jawaly.com',
        'auth' => ['ahmedmahmoud119988@gmail.com', '35d2b36fac592c2']
    ]);

    $options = [
        'json' => [
            "name" => "example2.com"
        ]
    ];
$resp = $client->post('/api/domain/lookup', $options);
    dd(json_decode($resp->getBody()->getContents(),true));

});

Route::get('/clear-cache', function() {
    $exitCode = \Artisan::call('config:cache');
    $exitCode = \Artisan::call('config:clear');
     return 'done';
});

Route::get('/pro', function() {
    $url = env('API_URL') . '/admin/api.php';
    $post = [
        'call' => 'getProductDetails',
        'api_id'    => env('API_ID'),
        'api_key'   => env('API_KEY'),
        'id' => 1,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $data = curl_exec($ch);
    curl_close($ch);

    $return = json_decode($data, true);
    dd($return);
});
