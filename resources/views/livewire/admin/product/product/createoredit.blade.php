<div wire:ignore.self class="modal fade" id="createoreditModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="createoreditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form wire:submit.prevent="store" enctype="multipart/form-data">
                <div class="modal-header text-white theme_bg_color px-3 py-2">
                    <h5 class="modal-title" id="createoreditModalLabel">
                        @if (isset($this->model_id))
                            {{ __('UPDATE') }}
                        @else
                            {{ __('CREATE') }}
                        @endif
                        {{ __('PRODUCT') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <div class="row g-3">
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.name',
                            'labelname' => __('PRODUCT NAME'),
                            'labelidname' => 'nameid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.sku',
                            'labelname' => __('SKU'),
                            'labelidname' => 'skuid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'select',
                            'fieldname' => 'form.productcategory_id',
                            'labelname' => __('PRODUCT CATEGORY'),
                            'labelidname' => 'productcategory_id',
                            'option' => $this->productcategory,
                            'default_option' => 'Select a Product category',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'number',
                            'fieldname' => 'form.purchaseprice',
                            'labelname' => __('PURCHASE PRICE'),
                            'labelidname' => 'purchasepriceid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'number',
                            'fieldname' => 'form.sellingprice',
                            'labelname' => __('SELLING PRICE'),
                            'labelidname' => 'sellingpriceid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'select',
                            'fieldname' => 'form.uom_id',
                            'labelname' => __('UOM'),
                            'labelidname' => 'uom_id',
                            'option' => $this->uom,
                            'default_option' => 'Select a UOM',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'file',
                            'fieldname' => 'image',
                            'labelname' => __('IMAGE'),
                            'labelidname' => 'imageid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @if ($image)
                            <div class="col-md-2">
                                <img src="{{ $image->temporaryUrl() }}" style="width: 80px" height="70px">
                            </div>
                        @elseif ($existingimage)
                            <div class="col-md-2">
                                <img src="{{ url('storage/' . $existingimage) }}" class="img-fluid rounded"
                                    style="width: 80px" height="70px">
                            </div>
                        @endif

                        {{-- <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" wire:model="form.is_nonveg" type="radio"
                                    id="veg_id" value='0'>
                                <label class="form-check-label" for="veg_id">
                                    VEG
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="form.is_nonveg" type="radio"
                                    id="nonveg_id" value='1'>
                                <label class="form-check-label" for="nonveg_id">
                                    NON VEG
                                </label>
                            </div>
                        </div> --}}

                        @include('helper.formhelper.form', [
                            'type' => 'formswitch',
                            'fieldname' => 'form.is_nonveg',
                            'labelname' => __('IS NON VEG'),
                            'labelidname' => 'is_nonvegid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])

                        {{-- @include('helper.formhelper.form', [
                            'type' => 'number',
                            'fieldname' => 'form.cgst',
                            'labelname' => __('CGST'),
                            'labelidname' => 'cgstid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ]) --}}
                        @if ($tax_type == 2)
                            <div class="col-md-4">
                                <label for="cgstid" class="form-label">{{ __('CGST') }}</label>
                                <span class="text-danger fw-bold">*</span>
                                <input wire:model.blur="form.cgst" type="number" class="form-control" id="cgstid"
                                    step="any">
                                @error('form.cgst')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- @include('helper.formhelper.form', [
                            'type' => 'number',
                            'fieldname' => 'form.sgst',
                            'labelname' => __('SGST'),
                            'labelidname' => 'sgstid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ]) --}}

                            <div class="col-md-4">
                                <label for="sgstid" class="form-label">{{ __('SGST') }}</label>
                                <span class="text-danger fw-bold">*</span>
                                <input wire:model.blur="form.sgst" type="number" class="form-control" id="sgstid"
                                    step="any">
                                @error('form.sgst')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="igstid" class="form-label">{{ __('IGST') }}</label>
                                <span class="text-danger fw-bold">*</span>
                                <input wire:model.blur="form.igst" type="number" class="form-control" id="igstid"
                                    step="any">
                                @error('form.igst')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="cessid" class="form-label">{{ __('CESS') }}</label>
                                <span class="text-danger fw-bold">*</span>
                                <input wire:model.blur="form.cess" type="number" class="form-control" id="cessid"
                                    step="any">
                                @error('form.cess')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- @include('helper.formhelper.form', [
                                'type' => 'number',
                                'fieldname' => 'form.igst',
                                'labelname' => __('IGST'),
                                'labelidname' => 'igstid',
                                'required' => false,
                                'readonly' => false,
                                'col' => 'col-md-4',
                            ]) --}}
                            {{-- @include('helper.formhelper.form', [
                                'type' => 'number',
                                'fieldname' => 'form.cess',
                                'labelname' => __('CESS'),
                                'labelidname' => 'cessid',
                                'required' => false,
                                'readonly' => false,
                                'col' => 'col-md-4',
                            ]) --}}
                            @include('helper.formhelper.form', [
                                'type' => 'text',
                                'fieldname' => 'form.hsncode',
                                'labelname' => __('HSN CODE'),
                                'labelidname' => 'hsncodeid',
                                'required' => true,
                                'readonly' => false,
                                'col' => 'col-md-4',
                            ])
                        @endif
                        @if ($tax_type == 3)
                            <div class="col-md-4">
                                <label for="vatid" class="form-label">{{ __('VAT') }}</label>
                                <span class="text-danger fw-bold">*</span>
                                <input wire:model.blur="form.vat" type="number" class="form-control" id="vatid"
                                    step="any">
                                @error('form.vat')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        @include('helper.formhelper.form', [
                            'type' => 'formswitch',
                            'fieldname' => 'form.active',
                            'labelname' => __('ACTIVE'),
                            'labelidname' => 'activeid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'textarea',
                            'fieldname' => 'form.note',
                            'labelname' => __('NOTE'),
                            'labelidname' => 'noteid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])

                    </div>
                </div>
                <div class="modal-footer bg-light px-2 py-1">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">
                        @if (isset($this->model_id))
                            {{ __('Update') }}
                        @else
                            {{ __('Create') }}
                        @endif
                        <span wire:loading.delay class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true">
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
