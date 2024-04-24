<?php

namespace App\Repository\Admin\Api\Interfacelayer\Expense;

interface IAdminexpenseApiRepository
{
    public function admincreateoreditexpense();

    public function adminexpenselist();

    public function adminshowexpense();
}
