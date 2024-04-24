<?php

namespace App\Livewire\Admin\Settings\Mastersettings\Productcategory;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Mastersettings\Productcategory;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Productcategorylivewire extends Component
{
    use WithFileUploads;

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $image, $existingimage;

    public $formdata = [
        'name' => '',
        'image' => '',
        'note' => '',
        'active' => false,
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|min:2|max:70|unique:productcategories,name,' . $this->model_id,
            'image' => 'nullable|image|max:1024',
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.name.required' => 'The Product Categroy name cannot be empty.',
        'form.name.min' => 'The Product Categroy name field must be at least 2 characters.',
        'form.name.max' => 'The Product Categroy name field must not be greater than 70 characters.',
        'form.note.min' => 'The note field must be at least 5 characters.',
        'form.note.max' => 'The note field must not be greater than 255 characters.',
    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function createorupdate($data): void
    {
        if ($this->model_id) {
            // if ($data['image'] && array_key_exists('image', $data)) {
            //     $data['image'] = Storage::disk('public')->put('productcategory', $this->image);
            // }
            // if ($this->existingimage != '' && $this->existingimage == $this->formdata['image']) {
            //     Storage::disk('public')->delete($this->existingimage);
            // }
            if ($this->image) {
                $data['image'] = $this->image->store('image', 'public');
                if ($this->existingimage) {
                    Storage::delete('public/' . $this->existingimage);
                }
                $this->image = null;
            } elseif (empty($this->image) && $this->existingimage) {
                $data['image'] = $this->existingimage;
            } else {
                $data['image'] = null;
            }
            $productcategory = Productcategory::find($this->model_id);
            $productcategory->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $productcategory, 'productcategory_createoredit', session()->getId(), 'WEB', 'Product Category was Updated');
            $this->toaster('success', 'Product Category was Updated Successfully!!');
        } else {
            // if (array_key_exists('image', $data)) {
            //     $data['image'] = Storage::disk('public')->put('productcategory', $this->image);
            // }
            if ($this->image) {
                $data['image'] = $this->image->store('image', 'public');
            }
            $productcategory = Productcategory::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $productcategory, 'productcategory_createoredit', session()->getId(), 'WEB', 'Product Category Created');
            $this->toaster('success', 'Product Category Created Successfully!!');
        }
    }

    public function store(): void
    {
        $validatedData = $this->validate();
        try {

            DB::beginTransaction();
            $this->createorupdate($this->form);
            DB::commit();

            $this->formreset();
            $this->dispatch('closemodal');
            $this->submitbutton = true;

        } catch (Exception $e) {
            $this->exceptionerror(auth()->user(), 'admin_productcategory_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_productcategory_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_productcategory_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($productcategoryid, $type): void
    {

        $productcategory = Productcategory::find($productcategoryid);

        if ($type == 'edit') {
            $this->form = $productcategory->only('name', 'image', 'note', 'active');
            $this->existingimage = $this->form['image'];
            $this->model_id = $productcategoryid;
        } else {
            $this->showdata = $productcategory;
        }
    }

    public function formreset(): void
    {
        $this->resetValidation();
        $this->form = $this->formdata;
        $this->model_id = null;
        $this->existingimage = null;

    }

    #[Computed]
    public function productcategory()
    {
        return Productcategory::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.mastersettings.productcategory.productcategorylivewire');
    }
}
