<?php

namespace App\Models\Miscellaneous;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Smshelper extends Model
{

    public static function sms($templeteid, $phonenumber, $message)
    {
        Log::info('-------sms--------PhoneNumber:' . $phonenumber . '----Templete Id:' . $templeteid);

        $URL = 'http://digimate.airtel.in:15181/BULK_API/InstantJsonPush';

        $post_data = '{

            "keyword":"DEMO",

            "timeStamp":"071818163530",

            "dataSet":

            [

            {

            "UNIQUE_ID":"735694wew",

            "MESSAGE": "' . $message . '",

            "OA":"TNGOVT",

            "MSISDN":"' . $phonenumber . '",

            "CHANNEL":"SMS",

            "CAMPAIGN_NAME":"tnega_u",

            "CIRCLE_NAME":"DLT_GOVT",

            "USER_NAME":"tnega_mlcsiht",

            "DLT_TM_ID":"1001096933494158",

            "DLT_CT_ID": "' . $templeteid . '",

            "DLT_PE_ID":"1301157259712022912",

            "LANG_ID":"2"

            }

            ]

            }';

        $crl = curl_init();

        $headr = array();
        $headr[] = 'Content-type: application/json';
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

        $rest = curl_exec($crl);

        if ($rest === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            //print_r('Curl error: ' . curl_error($crl));
            $result_noti = 0;
        } else {

            $result_noti = 1;
        }

    }

}
