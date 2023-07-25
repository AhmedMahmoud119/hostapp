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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $searchDomainData = $data;
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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $listDomainsData = $data;

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $domainDetailsData = $data;

            }

        } else {
            $domainDetailsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainRenew($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $domainNsData = HelperDomain::domainRenew($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$domainNsData,200);
                }

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
            }

        } else {
            $domainNsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainNs($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $domainNsData = $data;

            }

        } else {
            $domainNsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function createDns($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $createDnsData = $data;

            }

        } else {
            $createDnsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDns($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $updateDnsData = $data;

            }

        } else {
            $updateDnsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function deleteDns($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $deleteDnsData = $data;

            }

        } else {
            $deleteDnsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function dnsTypes($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $dnsTypesData = $data;

            }

        } else {
            $dnsTypesData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function dnsRecords($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
                $dnsRecordsData = $data;

            }

        } else {
            $dnsRecordsData = [];
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function registerDomainNs($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDomainNs($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainEpp($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainSynchronize($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainLock($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::domainLock($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDomainLock($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::updateDomainLock($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDomainIdProtection($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::updateDomainIdProtection($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainContact($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::domainContact($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDomainContact($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::updateDomainContact($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainEmforwarding($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::domainEmforwarding($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDomainEmforwarding($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::updateDomainEmforwarding($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDomainForwarding($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::updateDomainForwarding($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainAutorenew($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::domainAutorenew($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function updateDomainAutorenew($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::updateDomainAutorenew($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainFlags($userJawaly){
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::domainFlags($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function domainDnssec($userJawaly){
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::domainDnssec($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function addDomainDnssec($userJawaly){
        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperDomain::addDomainDnssec($userJawaly);
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }
            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);
            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function availableTld($userJawaly){

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

            } catch (Exception $exception) {
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

    public static function tldForm($userJawaly){

        if ($userJawaly instanceof User) {
            try {
                $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {
                    HelperGeneral::useJob($userJobsNotUsed);
                    $data = HelperTLD::tldForm($userJawaly);;
                    Helper::saveHostBillResponse($userJawaly,$data,200);
                }

            } catch (Exception $exception) {
                dd($exception);
                $data = json_decode($exception->getResponse()->getBody()->getContents(),true);
                Helper::saveHostBillResponse($userJawaly,$data,400);

            }

        } else {
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return true;
    }

}
