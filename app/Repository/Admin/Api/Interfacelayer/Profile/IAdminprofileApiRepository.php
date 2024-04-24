<?php

namespace App\Repository\Admin\Api\Interfacelayer\Profile;

interface IAdminprofileApiRepository
{
    public function admingetprofile();

    public function adminupdateprofile();

    public function adminchangepassword();

    public function adminchangeavatar();

}
