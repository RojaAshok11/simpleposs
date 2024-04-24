<?php

namespace App\Livewire\Admin\Settings\User\User;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Auth\User;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class Userlivewire extends Component
{
    use WithFileUploads;

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $avatar, $existingavatar, $password, $password_confirmation;

    public $formdata = [
        'name' => '',
        'phone' => '',
        'email' => '',
        'avatar' => '',
        'note' => '',
        'role_id' => 1,
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|min:3',
            'form.email' => 'required|email|unique:users,email,' . $this->model_id,
            'form.phone' => 'required|digits:10|numeric|unique:users,phone,' . $this->model_id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'form.role_id' => 'required',
            'form.note' => 'nullable|max:255',
        ];
    }

    protected $messages = [
        'form.name.required' => 'Enter admin name',
        'form.name.min' => 'Atleast 3 characters required',
        'form.email.required' => 'Email address required',
        'form.email.email' => 'Enter a valid email address',
        'form.email.unique' => 'Email address already taken',
        'form.phone.required' => 'Enter Phone Number',
        'form.phone.numeric' => 'Phone number must be a number',
        'form.phone.digits' => 'Phone number must be 10 digit number',
        'form.phone.unique' => 'Phone already taken',
        'form.note.min' => 'Atleast 5 characters required',
        'form.note.max' => 'Should be less than 255 characters',
        'form.userrole.required' => 'Select user role',
    ];

    protected function customvalidation()
    {
        $validatedData = $this->validate();

        if (!$this->model_id) {
            $this->validate(['password' => 'required|string|min:8|confirmed']);

        }
        return $validatedData;
    }

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function createorupdate($data): void
    {
        if ($this->avatar) {
            $data['avatar'] = Storage::disk('public')->put('user', $this->avatar);
        }
        if ($this->existingavatar != '' && $this->existingavatar == $this->form['avatar']) {
            Storage::disk('public')->delete($this->existingavatar);
        }

        if ($this->model_id) {
            unset($data['password']);
            $user = User::find($this->model_id);
            $user->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $user, 'user_createoredit', session()->getId(), 'WEB', 'User Updated');
            $this->toaster('success', 'User Updated Successfully!!');
        } else {
            $user = User::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $user, 'user_createoredit', session()->getId(), 'WEB', 'User Created');
            $this->toaster('success', 'User Created Successfully!!');
        }
    }

    public function store(): void
    {
        $validatedData = $this->customvalidation();
        $validatedData['form']['password'] = $this->password;
        try {
            DB::beginTransaction();
            $this->createorupdate($validatedData['form']);
            DB::commit();
            $this->formreset();
            $this->dispatch('closemodal');
            $this->submitbutton = true;

        } catch (Exception $e) {
            $this->exceptionerror(auth()->user(), 'admin_user_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_user_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_user_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($userid, $type): void
    {
        $user = User::find($userid);

        if ($type == 'edit') {
            $this->form = $user->only('name', 'phone', 'email', 'avatar',
                'password', 'password_confirmation', 'note', 'role_id');
            $this->model_id = $userid;
            $this->existingavatar = $user->avatar;
        } else {
            $this->showdata = $user;
        }
    }

    #[Computed]
    public function user()
    {
        return User::query()
            ->where(fn($q) =>
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('uniqid', 'like', '%' . $this->searchTerm . '%'),
            )
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.user.user.userlivewire');
    }
}
