<?php

namespace App\Repository\Admin\Api\Businesslogic\Notification;

use App\Repository\Admin\Api\Interfacelayer\Notification\IAdminnotificationApiRepository;

class AdminnotificationApiRepository implements IAdminnotificationApiRepository
{
    public function adminnotification()
    {
        return [true, 'success', 'adminnotification'];
    }
}
