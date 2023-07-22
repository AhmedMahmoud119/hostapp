<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Http\Helper\HelperGeneral;
use App\Models\HostJob;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;

class OrderDomain
{

    public static function orderDomain($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $orderDomainData = Helper::orderDomain($userJawaly);
                }else{
                    $orderDomainData = [];
                }
                Helper::saveHostBillResponse($userJawaly,$orderDomainData,200);
                \DB::commit();
            } catch (Exception $exception) {
                $orderDomainData = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$orderDomainData,400);
                \DB::commit();
            }

        } else {
            $orderDomainData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'orderDomainData' => $orderDomainData
        ];
    }

}
