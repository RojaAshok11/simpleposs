<div wire:ignore.self class="modal fade" id="createoreditModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="createoreditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form wire:submit.prevent="store" enctype="multipart/form-data">
                <div class="modal-header text-white theme_bg_color px-3 py-2">
                    <h5 class="modal-title" id="createoreditModalLabel">
                        {{-- @dd($this->model_id) --}}
                        {{ isset($this->model_id) ? __('UPDATE') : __('CREATE') }}
                        {{ __('USER') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <div class="row g-3">
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.name',
                            'labelname' => __('NAME'),
                            'labelidname' => 'nameid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])

                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'form.email',
                            'labelname' => __('EMAIL'),
                            'labelidname' => 'emailid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        @include('helper.formhelper.form', [
                            'type' => 'number',
                            'fieldname' => 'form.phone',
                            'labelname' => __('PHONE'),
                            'labelidname' => 'phoneid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])
                        {{-- @include('helper.formhelper.form', [
                            'type' => 'select',
                            'fieldname' => 'form.role_id',
                            'labelname' => __('USER ROLE'),
                            'labelidname' => 'role_idid',
                            'default_option' => 'Select an role',
                            'option' => $roles_data,
                            'required' => true,
                             'readonly' => false,
                            'col' => 'col-md-4',
                        ]) --}}
                        @include('helper.formhelper.form', [
                            'type' => 'file',
                            'fieldname' => 'avatar',
                            'labelname' => __('AVATAR'),
                            'labelidname' => 'avatarid',
                            'required' => false,
                            'readonly' => false,
                            'col' => 'col-md-4',
                        ])

                        @if ($avatar)
                            <div class="col-md-2">
                                <img src="{{ $avatar->temporaryUrl() }}" style="width: 80px" height="70px">
                            </div>
                        @elseif ($existingavatar)
                            <div class="col-md-2">
                                <img src="{{ asset('storage/' . $existingavatar) }}" class="img-fluid rounded"
                                    style="width: 80px" height="70px">
                            </div>
                        @endif

                        @if (!$this->model_id)
                            @include('helper.formhelper.form', [
                                'type' => 'password',
                                'fieldname' => 'password',
                                'labelname' => __('PASSWORD'),
                                'labelidname' => 'passwordid',
                                'required' => true,
                                'readonly' => false,
                                'col' => 'col-md-4',
                            ])
                            @include('helper.formhelper.form', [
                                'type' => 'password',
                                'fieldname' => 'password_confirmation',
                                'labelname' => __('CONFIRM PASSWORD'),
                                'labelidname' => 'confirmpasswordid',
                                'required' => true,
                                'readonly' => false,
                                'col' => 'col-md-4',
                            ])
                        @endif
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
                    <button type="submit"
                        class="btn btn-primary">{{ isset($this->model_id) ? __('Update') : __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
