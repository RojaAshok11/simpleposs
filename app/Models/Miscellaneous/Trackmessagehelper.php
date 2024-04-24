<?php

namespace App\Models\Miscellaneous;

use Illuminate\Database\Eloquent\Model;

class Trackmessagehelper extends Model
{

    public static function trackmessage($user, $functionable, $function, $sessionid, $type, $trackmsg)
    {
        $user->trackable()
            ->make([
                'name' => $user->name,
                'uniqid' => $user->uniqid,
                'function' => $function,
                'trackmsg' => $trackmsg,
                'sessionid' => $sessionid,
                'type' => $type,
            ])->functionable()
            ->associate($functionable)
            ->save();
    }

}
