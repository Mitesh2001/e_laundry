<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class SMS extends Repository
{
    public function model()
    {
        return User::class;
    }
   /**
     * @inheritDoc
     */


    public function sendSms($mobile, $otp, $isDummy)
    {
        $mobile = substr($mobile, strpos($mobile, '01'));
        $mobile = '88' . $mobile;
        $message = 'Welcome to The Iron Man for Quality Ironing Service Your OTP is:' . $otp;

        $params = [
            "api_token" => env('API_TOKEN'),
            "sid" => env('SID'),
            "msisdn" => $mobile,
            "sms" => $message,
            "csms_id" => time()
        ];
        $params = json_encode($params);
        if($isDummy){
            return $this->callApi($params);
        }
        return 'Sorry, we were unable to send the message';
    }

    private function callApi($params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('SMS_URL'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
