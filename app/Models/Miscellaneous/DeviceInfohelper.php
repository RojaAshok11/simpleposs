<?php

namespace App\Models\Miscellaneous;

use App\Models\Admin\Settings\Tracking\Logininfo;
use App\Models\Miscellaneous\DeviceInfohelper;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class DeviceInfohelper extends Model
{

    public static function deviceInfo($user, $sessionid, $type)
    {
        $agent = new Agent();
        $user->logininfoable()
            ->save(new Logininfo([
                'device' => $agent->device(),
                'robot' => $agent->robot(),
                'browser' => $agent->browser(),
                'browser_v' => $agent->version($agent->browser()),
                'platform' => $agent->platform(),
                'platform_v' => $agent->version($agent->platform()),
                'languages' => json_encode($agent->languages()),
                'serverIp' => request()->ip(),
                'clientIp' => DeviceInfohelper::getIp(),
                'user_name' => $user->name,
                'user_uniqid' => $user->uniqid,
                'login_status' => true,
                'email' => $user->email,
                'sessionid' => $sessionid,
                'type' => $type,
            ]));
    }

    public static function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

}
