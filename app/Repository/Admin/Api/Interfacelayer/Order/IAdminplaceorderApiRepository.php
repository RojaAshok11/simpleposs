<?php

namespace App\Repository\Admin\Api\Interfacelayer\Order;

interface IAdminplaceorderApiRepository
{
    public function adminplaceorder();
    public function adminholdorderlist();
    public function admingetholdorder();
    public function admindeleteholdorder();
    public function admindeleteholdorderitem();
    public function admindeleteorderitem();
}
