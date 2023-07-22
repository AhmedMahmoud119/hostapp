<?php

namespace App\Http\Controllers;

use App\Http\Helper\Helper;
use App\Models\HostJob;
use App\Models\User;
use Illuminate\Http\Request;
use SebastianBergmann\Diff\Exception;

class GenerateJobController extends Controller
{

    public function generateJob()
    {

        $userJawaly = Helper::verifyUserjawaly();

        $isUser = false;
        if ($userJawaly instanceof User) {
            $jawaly_account_id = $userJawaly->jawaly_account_id;
            $isUser = true;
        } else {
            $jawaly_account_id = rand(1, 100);
        }

        if ($isUser) {

            try {
                if ( ! $userJawaly->host_bill_id) {
                    $hostBill = Helper::addHostBill($userJawaly);
                } else {
//                    $hostBillDetails = Helper::getHostBillData($userJawaly);
//                    if ($hostBillDetails['client']['email'] != $userJawaly->email) {
//                        $hostBillDetails = Helper::updateHostBillData($userJawaly);
//                    }
                }
            } catch (Exception $e) {}


            $userJobsNotUsed = HostJob::where('user_id', $userJawaly->id)->where('status', 0)->first();

            if ( ! $userJobsNotUsed) {
                $jop_id = Helper::generateJobId($jawaly_account_id);
                HostJob::create([
                    'job_id'  => $jop_id,
                    'user_id' => $userJawaly->id,
                    'status'  => 0,
                ]);
            } else {
                $jop_id = $userJobsNotUsed->job_id;
            }
        } else {
            $jop_id = Helper::generateJobId($jawaly_account_id);
            Helper::sendNotification('generate.job', 'api key & secret error');
        }

        return response()->json([
            'message' => 'تم الارسال بنجاح',
            'jop_id'  => $jop_id,
        ]);
    }

    public function getJob(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
        ], [
            'job_id.required' => 'الجوب الزامي',
        ]);

        $userJawaly = Helper::verifyUserjawaly();

        if ($userJawaly instanceof User) {
            $userJobsNotUsed = HostJob::where([
                'job_id'  => $request->job_id,
                'user_id' => $userJawaly->id,
            ])->first();
            if ( ! $userJobsNotUsed) {
                //                $token = substr(sha1(mt_rand()), 1, 25);
                $json = null;
                Helper::sendNotification('get.job.details', 'قام بادخال جوب خاطئ');
            } else {
                //                $token = $userJawaly->token;
                $json = json_decode($userJobsNotUsed->json, true);
            }

        } else {
            $json = null;
            //            $token = substr(sha1(mt_rand()), 1, 25);
            Helper::sendNotification('error.get.job.details', 'api key & secret error');
        }


        return response()->json([
            'job_id' => $request->job_id,
            'data'   => $json,
            'hash'   => substr(sha1(mt_rand()), 1, 25),
        ]);
    }
}
