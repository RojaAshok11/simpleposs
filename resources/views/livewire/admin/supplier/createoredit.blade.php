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
                        {{ __('SUPPLIER') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <div class="row g-3">
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.name',
                            'labelname' => __('COMPANY NAME'),
                            'labelidname' => 'nameid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'number',
                            'fieldname' => 'form.phone',
                            'labelname' => __('COMPANY PHONE'),
                            'labelidname' => 'phoneid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.email',
                            'labelname' => __('EMAIL'),
                            'labelidname' => 'emailid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.gst',
                            'labelname' => __('GST'),
                            'labelidname' => 'gstid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.pan',
                            'labelname' => __('PAN'),
                            'labelidname' => 'panid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.cpname',
                            'labelname' => __('CONTACT PERSON NAME'),
                            'labelidname' => 'cpnameid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'number',
                            'fieldname' => 'form.cpphone',
                            'labelname' => __('CONTACT PERSON PHONE'),
                            'labelidname' => 'cpphoneid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.cpmail',
                            'labelname' => __('CONTACT PERSON EMAIL'),
                            'labelidname' => 'cpmailid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
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
                            'fieldname' => 'form.address',
                            'labelname' => __('ADDRESS'),
                            'labelidname' => 'addressid',
                            'required' => true,
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
