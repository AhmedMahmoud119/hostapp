<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Http\Helper\HelperGeneral;
use App\Models\HostJob;
use App\Models\User;
use Exception;

class Contact
{

    public static function addContact($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $addContact = Helper::addContact($userJawaly);
                }else{
                    $addContact = [];
                }
                Helper::saveHostBillResponse($userJawaly,$addContact,200);

                \DB::commit();
            } catch (Exception $exception) {
                $addContact = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$addContact,400);
                \DB::commit();
            }

        } else {
            $addContact = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'addContactData' => $addContact
        ];
    }

    public static function getContacts($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $getContact = Helper::getContacts($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$getContact,200);
                }else{
                    $getContact = [];
                }

                \DB::commit();
            } catch (Exception $exception) {
                $getContact = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$getContact,400);
                \DB::commit();
            }

        } else {
            $getContact = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'getContactData' => $getContact
        ];
    }

}
