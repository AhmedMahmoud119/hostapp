<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Http\Helper\HelperGeneral;
use App\Http\Helper\HelperProduct;
use App\Models\HostJob;
use App\Models\User;
use Exception;

class Product
{


    public static function getProducts($userJawaly,$withDetails = 0){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $getProduct = Helper::getProducts($userJawaly,$withDetails);
                    Helper::saveHostBillResponse($userJawaly,$getProduct,200);
                }

            } catch (Exception $exception) {
                $getProduct = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$getProduct,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }
        return true;
    }

    public static function orderProduct($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $orderProduct = Helper::orderProduct($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$orderProduct,200);
                }

            } catch (Exception $exception) {
                $orderProduct = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$orderProduct,400);
            }
        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function getCategories($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $getCategories = Helper::getCategories($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$getCategories,200);
                }
            } catch (Exception $exception) {
                $getCategories = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$getCategories,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }
        return true;
    }

    public static function getProductConfigurationDetails($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $getProductConfigurationDetails = HelperProduct::getProductConfigurationDetails($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$getProductConfigurationDetails,200);
                }
            } catch (Exception $exception) {
                $getProductConfigurationDetails = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$getProductConfigurationDetails,400);
            }
        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }
        return true;
    }

}
