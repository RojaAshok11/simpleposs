<?php

namespace App\Repository\Admin\Api\Businesslogic\Faq;

use App\Models\Admin\Settings\Support\Faq;
use App\Repository\Admin\Api\Interfacelayer\Faq\IAdminfaqApiRepository;

class AdminfaqApiRepository implements IAdminfaqApiRepository
{
    public function adminfaq()
    {
        return [true,
            Faq::where('panel', request('panel'))
                ->select('question', 'answer')
                ->get(),
            'Admin Faq'];
    }
}
