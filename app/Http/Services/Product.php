<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Http\Helper\HelperGeneral;
use App\Models\HostJob;
use App\Models\User;
use Exception;

class Product
{


    public static function getProducts($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $getProduct = Helper::getProducts($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$getProduct,200);
                }else{
                    $getProduct = [];
                }

                \DB::commit();
            } catch (Exception $exception) {
                $getProduct = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$getProduct,400);
                \DB::commit();
            }

        } else {
            $getProduct = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'getProductsData' => $getProduct
        ];
    }

    public static function orderProduct($userJawaly){
        \DB::beginTransaction();
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
                }else{
                    $orderProduct = [];
                }

                \DB::commit();
            } catch (Exception $exception) {
                $orderProduct = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$orderProduct,400);
                \DB::commit();
            }

        } else {
            $orderProduct = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'orderProductData' => $orderProduct
        ];
    }

    public static function getCategories($userJawaly){
        \DB::beginTransaction();
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
                }else{
                    $getCategories = [];
                }

                \DB::commit();
            } catch (Exception $exception) {
                $getCategories = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$getCategories,400);
                \DB::commit();
            }

        } else {
            $getCategories = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'getCategoriesData' => $getCategories
        ];
    }

}
