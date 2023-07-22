<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Http\Helper\HelperDomain;
use App\Http\Helper\HelperGeneral;
use App\Http\Helper\HelperTLD;
use App\Models\HostJob;
use App\Models\User;
use Exception;

class SearchDomain
{
    public static function searchDomain($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {

            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $searchDomainData = HelperDomain::searchDomain($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$searchDomainData,200);

                }else{
                    $searchDomainData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $searchDomainData = $data;
//                \DB::rollback();
                \DB::commit();
            }

        } else {
            $searchDomainData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'searchDomainData' => $searchDomainData
        ];
    }

    public static function listDomains($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $listDomainsData = HelperDomain::listDomains($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$listDomainsData,200);
                }else{
                    $listDomainsData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $listDomainsData = $data;
                \DB::commit();
            }

        } else {
            $listDomainsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'searchDomainData' => $listDomainsData
        ];
    }

    public static function domainDetails($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $domainDetailsData = HelperDomain::domainDetails($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$domainDetailsData,200);
                }else{
                    $domainDetailsData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $domainDetailsData = $data;
                \DB::commit();
            }

        } else {
            $domainDetailsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainNs($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $domainNsData = HelperDomain::domainNs($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$domainNsData,200);
                }else{
                    $domainNsData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $domainNsData = $data;
                \DB::commit();
            }

        } else {
            $domainNsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function createDns($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $createDnsData = HelperDomain::createDns($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$createDnsData,200);
                }else{
                    $createDnsData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $createDnsData = $data;
                \DB::commit();
            }

        } else {
            $createDnsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDns($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();
                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $updateDnsData = HelperDomain::updateDns($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$updateDnsData,200);
                }else{
                    $updateDnsData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $updateDnsData = $data;
                \DB::commit();
            }

        } else {
            $updateDnsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function deleteDns($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();
                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $deleteDnsData = HelperDomain::deleteDns($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$deleteDnsData,200);
                }else{
                    $deleteDnsData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $deleteDnsData = $data;
                \DB::commit();
            }

        } else {
            $deleteDnsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function dnsTypes($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $dnsTypesData = HelperDomain::dnsTypes($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$dnsTypesData,200);
                }else{
                    $dnsTypesData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $dnsTypesData = $data;
                \DB::commit();
            }

        } else {
            $dnsTypesData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function dnsRecords($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();
                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $dnsRecordsData = HelperDomain::dnsRecords($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$dnsRecordsData,200);
                }else{
                    $dnsRecordsData = [];
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $dnsRecordsData = $data;
                \DB::commit();
            }

        } else {
            $dnsRecordsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function registerDomainNs($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::registerDomainNs($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                \DB::commit();
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDomainNs($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::updateDomainNs($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                \DB::commit();
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainEpp($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::domainEpp($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                \DB::commit();
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainSynchronize($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::domainSynchronize($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                \DB::commit();
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function availableTld($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperTLD::availableTLD($userJawaly);;
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
                \DB::commit();
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                \DB::commit();
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

}
