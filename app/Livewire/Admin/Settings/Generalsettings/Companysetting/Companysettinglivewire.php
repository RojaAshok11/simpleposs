<?php

namespace App\Livewire\Admin\Settings\Generalsettings\Companysetting;

use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class Companysettinglivewire extends Component
{

    use miscellaneousLivewireTrait;
    use WithFileUploads;

    public $companyfullname, $companyshortname, $phone, $email,
    $alternate_phone, $gstno, $panno, $websitename, $address;

    public $logo, $existinglogo;
    public $favicon, $existingfavicon;

    public function mount(): void
    {
        $this->databind();
    }

    protected function rules(): array
    {
        return [
            'companyfullname' => 'bail|required|max:70',
            'companyshortname' => 'bail|required|max:70',
            'address' => 'bail|required|max:255',
            'phone' => 'bail|required|min:7|max:13',
            'alternate_phone' => 'bail|nullable|min:7|max:13',
            'email' => 'bail|required|email',
            'gstno' => 'bail|nullable',
            'panno' => 'bail|nullable',
            'websitename' => 'bail|nullable',
        ];
    }

    public function store(): void
    {
        $validatedData = $this->validate();

        try {
            $companysetting = Companysetting::first();
            $companysetting->update($validatedData);
            Trackmessagehelper::trackmessage(auth()->user(), $companysetting, 'companysetting_createoredit', session()->getId(), 'WEB', ' Company Settings was Updated');
            $this->toaster('success', 'Company Settings Updated Successfully!!');
            $this->formreset();
        } catch (Exception $e) {
            $this->exceptionerror($user, 'admin_company_settings', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror($user, 'admin_company_settings', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror($user, 'admin_company_settings', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind(): void
    {
        $companysetting = Companysetting::first();
        $this->companyfullname = $companysetting->companyfullname;
        $this->companyshortname = $companysetting->companyshortname;
        $this->phone = $companysetting->phone;
        $this->email = $companysetting->email;
        $this->alternate_phone = $companysetting->alternate_phone;
        $this->gstno = $companysetting->gstno;
        $this->panno = $companysetting->panno;
        $this->websitename = $companysetting->websitename;
        $this->address = $companysetting->address;
        $this->existinglogo = $companysetting->logo;
        $this->existingfavicon = $companysetting->favicon;
    }

    protected function formreset(): void
    {
        $companyfullname = $companyshortname = $phone = $email =
        $alternate_phone = $gstno = $panno = $websitename = $address = null;

        $this->resetValidation();
    }

    public function onclickformreset(): void
    {
        $this->databind();
        $this->resetValidation();
        $this->toaster('warning', 'Oops! Company Settings Discarded Done');
    }

    public function uploadlogo(): void
    {
        $this->validate([
            'logo' => 'image|max:1024', // 1MB Max
        ]);

        $newlogo = Storage::disk('public')->put('image/logo', $this->logo);
        Companysetting::first()->update(['logo' => $newlogo]);

        $this->existinglogo ? Storage::delete('public/' . $this->existinglogo) : null;

        $this->logo = null;
        $this->existinglogo = $newlogo;
        $this->toaster('success', 'Logo Uploaded Successfully!');
    }

    public function uploadfavicon(): void
    {
        $this->validate([
            'favicon' => 'image|max:1024', // 1MB Max
        ]);

        $newfavicon = Storage::disk('public')->put('image/favicon', $this->favicon);
        Companysetting::first()->update(['favicon' => $newfavicon]);

        $this->existingfavicon ? Storage::delete('public/' . $this->existingfavicon) : null;

        $this->favicon = null;
        $this->existingfavicon = $newfavicon;
        $this->toaster('success', 'Favicon Uploaded Successfully!');
    }

    public function render(): View
    {
        return view('livewire.admin.settings.generalsettings.companysetting.companysettinglivewire');
    }
}
