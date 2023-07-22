<?php

namespace App\Http\Services;

use App\Http\Helper\Helper;
use App\Models\AddToHostBill;
use App\Models\HostJob;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;

class ClientLogin
{

    public static function clientLogin($userJawaly){
        \DB::beginTransaction();
        if ($userJawaly instanceof User) {
            try {

                $userJobsNotUsed = HostJob::
                where('user_id', $userJawaly->id)
                    ->where('status', 0)
                    ->where('job_id', request()->job_id)->first();

                if ($userJobsNotUsed) {

                    $user = User::find($userJawaly->id);

                    \DB::table('personal_access_tokens')->where([
                        'tokenable_type' => 'App\Models\User',
                        'tokenable_id'   => $user->id,
                        'name'           => 'Token',
                    ])->delete();

                    $token = $user->createToken("Token", ['*'], Carbon::now()->addHour())->plainTextToken;

                    $data = [
                        'token' => $token,
                    ];
                    $user->update($data);

                    $userJobsNotUsed->update([
                        'event_name' => 'client.login',
                        'status'     => 1,
                        'message' => 'تم الارسال بنجاح',
                        'json' => json_encode($data,true),
                        'error_code' => 200,
                    ]);

                } else {
                    $token = substr(sha1(mt_rand()), 1, 25);
                    Helper::sendNotification(request()->event, 'لا يوجد جوب');
                }
                \DB::commit();

            } catch (Exception $exception) {
                \DB::rollback();
                $token = substr(sha1(mt_rand()), 1, 25);
                Helper::sendNotification(request()->event, '');
            }

        } else {
            $token = substr(sha1(mt_rand()), 1, 25);
            Helper::sendNotification(request()->event, 'api key & secret error');
        }

        return [
            'token' => $token
        ];
    }

}
