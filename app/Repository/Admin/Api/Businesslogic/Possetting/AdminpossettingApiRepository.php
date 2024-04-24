<?php

namespace App\Repository\Admin\Api\Businesslogic\Possetting;

use App\Models\Admin\Settings\Generalsettings\Companysetting;
use App\Models\Admin\Settings\Generalsettings\Themesetting;
use App\Models\Admin\Settings\Pos\Possetting;
use App\Repository\Admin\Api\Interfacelayer\Possetting\IAdminpossettingApiRepository;

class AdminpossettingApiRepository implements IAdminpossettingApiRepository
{
    public function adminpossetting()
    {
        $company = Companysetting::first();
        $data['companyfullname'] = $company->companyfullname ? $company->companyfullname : '';
        $data['companyshortname'] = $company->companyshortname ? $company->companyshortname : '';
        $data['phone'] = $company->phone ? $company->phone : '';
        $data['email'] = $company->email ? $company->email : '';
        $data['alternate_phone'] = $company->alternate_phone ? $company->alternate_phone : '';
        $data['gstno'] = $company->gstno ? $company->gstno : '';
        $data['panno'] = $company->panno ? $company->panno : '';
        $data['websitename'] = $company->websitename ? $company->websitename : '';
        $data['address'] = $company->address ? $company->address : '';
        $data['address'] = $company->address ? $company->address : '';
        $data['logo'] = $company->logo ? $company->logo : '';
        $data['theme_color'] = Themesetting::where('active', true)->first()->theme_bg_color;

        $possetting = Possetting::first();
        $data['grid_layout'] = $possetting->theme ? config('archive.pos_theme')[$possetting->theme] : '';
        $data['pos_position'] = $possetting->pos_position ? config('archive.pos_bill_position')[$possetting->pos_position] : '';
        $data['date_format'] = $possetting->date_format ? config('archive.date_format')[$possetting->date_format] : '';
        $data['time_type'] = $possetting->time_type ? config('archive.time_type')[$possetting->time_type] : '';
        $data['tax_type'] = $possetting->tax_type ? config('archive.tax_type')[$possetting->tax_type] : '';
        $data['is_hold'] = $possetting->is_hold ? true : false;
        $data['is_holdreference'] = $possetting->is_holdreference ? true : false;
        $data['carticon'] = $possetting->carticon ? $possetting->carticon : '';

        return [true, $data,
            'adminpossetting'];
    }
}
