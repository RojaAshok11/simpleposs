<?php

namespace App\Livewire\Livewirehelper\Miscellaneous;

use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait miscellaneousLivewireTrait
{

    public $showdata;

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);

    }

    protected function toaster($type, $message): void
    {
        $this->dispatch('alert',
            ['type' => $type, 'message' => $message]);
    }

    public function formreset(): void
    {
        $this->resetValidation();
        $this->form = $this->formdata;
        $this->model_id = null;

    }

    protected function exceptionerror($user, $function, $trackmsg): void
    {
        DB::rollback();
        Log::error("SessionID: " . session()->getId() . ' Exception ' . $function . ' ' . $trackmsg);
        Trackmessagehelper::trackmessage($user, $trackmsg, $function, session()->getId(), 'WEB');
        $this->toaster('error', $e->getMessage());
    }
}
