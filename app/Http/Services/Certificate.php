<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Http\Helper\HelperCertificate;
use App\Http\Helper\HelperGeneral;
use App\Http\Helper\HelperProduct;
use App\Models\HostJob;
use App\Models\User;
use Exception;

class Certificate
{
    public static function listAvailableCertificates($userJawaly){
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $getAvailableCertificates = HelperCertificate::listAvailableCertificates($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$getAvailableCertificates,200);
                }
            } catch (Exception $exception) {
                $getAvailableCertificates = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$getAvailableCertificates,400);
            }
        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }
        return true;
    }

    public static function listCertificates($userJawaly){
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $getAvailableCertificates = HelperCertificate::listCertificates($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$getAvailableCertificates,200);
                }
            } catch (Exception $exception) {
                $getAvailableCertificates = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$getAvailableCertificates,400);
            }
        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }
        return true;
    }

    public static function orderCertificate($userJawaly){
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $orderCertificate = HelperCertificate::orderCertificate($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$orderCertificate,200);
                }
            } catch (Exception $exception) {
                $orderCertificate = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$orderCertificate,400);
            }
        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }
        return true;
    }

    public static function certificateDetails($userJawaly){
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $orderCertificate = HelperCertificate::certificateDetails($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$orderCertificate,200);
                }
            } catch (Exception $exception) {
                $orderCertificate = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$orderCertificate,400);
            }
        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }
        return true;
    }
}
