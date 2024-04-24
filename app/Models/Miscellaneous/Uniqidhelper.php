<?php

namespace App\Models\Miscellaneous;

use App\Models\Miscellaneous\Uniqidhelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Uniqidhelper extends Model
{
    public static function getNextSequenceId($digit, $name, $model)
    {
        $object = $model::withTrashed()
            ->orderBy('sequence_id', 'desc')
            ->first();

        $lastId = (!$object) ? 0 : $object->sequence_id;

        return $insertDataTwo = array(
            'uniqid' => $name . '-' . sprintf('%0' . $digit . 'd', intval($lastId) + 1),
            'sequence_id' => $lastId + 1,
            'sys_id' => md5(uniqid(rand(), true)),
        );
    }

    public static function autogenerateid($digit, $sufix, $model)
    {
        if ($digit) {
            $model->uuid = (string) Str::uuid();
            $model->user_id = auth()->user() ? auth()->id() : 1;
            $uniqueId = Uniqidhelper::getNextSequenceId($digit, $sufix, $model);
            $model->sys_id = $uniqueId['sys_id'];
            $model->uniqid = $uniqueId['uniqid'];
            $model->sequence_id = $uniqueId['sequence_id'];
        } else {
            $model->updated_id = auth()->user() ? auth()->id() : 1;
        }
    }

}
