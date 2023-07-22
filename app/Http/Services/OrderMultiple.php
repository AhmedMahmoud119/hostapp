<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Http\Helper\HelperGeneral;
use App\Http\Helper\HelperOrderMultiple;
use App\Models\HostJob;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;

class OrderMultiple
{

    public static function orderMultiple($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {

                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $orderMultipleData = HelperOrderMultiple::orderMultiple($userJawaly);
                }else{
                    $orderMultipleData = [];
                }

                Helper::saveHostBillResponse($userJawaly,$orderMultipleData,200);

                \DB::commit();
            } catch (Exception $exception) {
                $orderMultipleData = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$orderMultipleData,400);
                \DB::commit();
            }

        } else {
            $orderMultipleData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'orderMultipleData' => $orderMultipleData
        ];
    }

}
