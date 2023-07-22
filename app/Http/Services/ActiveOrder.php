<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Http\Helper\HelperGeneral;
use App\Models\HostJob;
use App\Models\User;
use Exception;

class ActiveOrder
{

    public static function activeOrder($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();


                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    if (isset(request()->data['invoice_id'])) {
                        $invoiceID = request()->data['invoice_id'];
                        Helper::invoicePaid($invoiceID);
                        $getOrderId = Helper::getOrderId($invoiceID);
                        if (isset($getOrderId['invoice']['order_id'])) {
                            $orderId = $getOrderId['invoice']['order_id'];
                            $setOrderActive = Helper::setOrderActive($orderId);
                        }

                    }

                    Helper::saveHostBillResponse($userJawaly,$setOrderActive,200);

                }else{
                    $setOrderActive = [];
                }

                \DB::commit();
            } catch (Exception $exception) {
                $setOrderActive = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$setOrderActive,400);
                \DB::commit();
            }

        } else {
            $setOrderActive = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'activeOrderData' => $setOrderActive
        ];
    }

}
