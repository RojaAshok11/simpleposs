<?php

namespace App\Livewire\Admin\Settings\Possettings\Possetting;

use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Sale\Sale;
use App\Models\Admin\Settings\Pos\Possetting;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class Possettinglivewire extends Component
{
    use miscellaneousLivewireTrait;
    use WithFileUploads;

    public $theme, $pos_position, $currency, $timezone, $date_format, $time_type, $is_hold, $is_holdreference;
    public $language, $tax_type, $purchase, $sale;
    public $carticon, $existingcarticon;

    public function mount(): void
    {
        $this->purchase = Purchase::count();
        $this->sale = Sale::count();
        $this->databind();
    }

    protected function rules(): array
    {
        return [
            'theme' => 'bail|required|integer',
            'pos_position' => 'bail|required|integer',
            'currency' => 'bail|nullable|integer',
            'timezone' => 'bail|nullable|integer',
            'date_format' => 'bail|nullable|integer',
            'time_type' => 'bail|nullable|integer',
            'is_hold' => 'nullable|boolean',
            'is_holdreference' => 'nullable|boolean',
            'language' => 'required|string',
            'tax_type' => 'required|integer',
        ];
    }

    public function store()
    {
        $validatedData = $this->validate();

        try {
            $possetting = Possetting::first();
            $possetting->update($validatedData);
            Trackmessagehelper::trackmessage(auth()->user(), $possetting, 'possetting_createoredit', session()->getId(), 'WEB', ' Pos Settings was Updated');
            $this->toaster('success', 'Pos Settings Updated Successfully!!');
            return redirect()->route('adminpossetting');
        } catch (Exception $e) {
            $this->exceptionerror($user, 'admin_pos_settings', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror($user, 'admin_pos_settings', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror($user, 'admin_pos_settings', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind(): void
    {
        $possetting = Possetting::first();
        $this->theme = $possetting->theme;
        $this->pos_position = $possetting->pos_position;
        $this->currency = $possetting->currency;
        $this->timezone = $possetting->timezone;
        $this->date_format = $possetting->date_format;
        $this->time_type = $possetting->time_type;
        $this->is_hold = $possetting->is_hold;
        $this->is_holdreference = $possetting->is_holdreference;
        $this->language = $possetting->language;
        $this->existingcarticon = $possetting->carticon;
        $this->tax_type = $possetting->tax_type;
    }

    protected function formreset(): void
    {
        $this->theme = $this->pos_position = $this->currency = $this->timezone = $this->tax_type = $this->language = $this->date_format = $this->time_type = null;
        $this->is_hold = $this->is_holdreference = false;
        $this->resetValidation();
    }

    public function onclickformreset(): void
    {
        $this->databind();
        $this->resetValidation();
        $this->toaster('warning', 'Oops! Company Settings Discarded Done');
    }

    public function uploadcarticon(): void
    {
        $this->validate([
            'carticon' => 'image|max:1024', // 1MB Max
        ]);

        $newcarticon = Storage::disk('public')->put('image/carticon', $this->carticon);
        Possetting::first()->update(['carticon' => $newcarticon]);

        $this->tax_type ? Storage::delete('public/' . $this->existingcarticon) : null;

        $this->carticon = null;
        $this->existingcarticon = $newcarticon;
        $this->toaster('success', 'Carticon Uploaded Successfully!');
    }

    public function render(): View
    {
        return view('livewire.admin.settings.possettings.possetting.possettinglivewire');
    }
}
