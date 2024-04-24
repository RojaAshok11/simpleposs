<div class="row justify-content-center ">
    <div class="col-md-5">
        <form wire:submit.prevent="store" class="card shadow-sm bg-white" autocomplete="off">
            <div class="card-body">
                <div class="card-title fs-5 fw-bold">{{ __('POS Information') }} :</div>
                <div class="row"></div>
                <div class="form-floating mb-3">
                    <select wire:model.blur="theme" class="form-select" id="floatingtheme">
                        @foreach (Config::get('archive.pos_theme') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <label for="floatingtheme" class="form-label">{{ __('Theme') }}</label>
                    @error('theme')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select wire:model.blur="pos_position" class="form-select" id="floatingbillposition">
                        @foreach (Config::get('archive.pos_bill_position') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <label for="floatingbillposition" class="form-label">{{ __('Pos Position') }}</label>
                    @error('pos_position')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select wire:model.blur="date_format" class="form-select" id="floatingdateformat">
                        @foreach (Config::get('archive.date_format') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <label for="floatingdateformat" class="form-label">{{ __('Date Format') }}</label>
                    @error('date_format')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select wire:model.blur="time_type" class="form-select" id="floatingtimetype">
                        @foreach (Config::get('archive.time_type') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <label for="floatingtimetype" class="form-label">{{ __('Time Type') }}</label>
                    @error('time_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row g-2 justify-content-center my-2">
                    <div class="col-md-6">
                        <label for="is_hold" class="form-label">{{ __('IS HOLD NEEDED') }} ?</label>
                        <div class="form-check form-switch">
                            <input wire:model.live="is_hold" class="form-check-input border-primary" type="checkbox"
                                id="is_hold">
                        </div>
                        @error('is_hold')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        @if ($is_hold)
                            <label for="is_holdreference" class="form-label">{{ __('IS HOLD REFERENCE ID NEEDED') }} ?</label>
                            <div class="form-check form-switch">
                                <input wire:model.live="is_holdreference" class="form-check-input border-primary"
                                    type="checkbox" id="is_holdreference">
                            </div>
                            @error('is_holdreference')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        @endif
                    </div>
                    <div class="form-floating mb-3">
                        <select wire:model.blur="language" class="form-select" id="floatinglanguage">
                            @foreach (Config::get('archive.languages') as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <label for="floatinglanguage" class="form-label">{{ __('Language') }}</label>
                        @error('language')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($purchase == 0 && $sale == 0)
                        <div class="form-floating mb-3">
                            <select wire:model.blur="tax_type" class="form-select" id="floatingtax_type">
                                @foreach (Config::get('archive.tax_type') as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <label for="floatingtax_type" class="form-label">{{ __('Tax Type') }}</label>
                            @error('tax_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div class="form-floating mb-3">
                            <input type="text" value="{{ Config::get('archive.tax_type')[$tax_type] }}"
                                class="form-control" id="floatingtax_type" placeholder="{{ __('Tax Type') }}" readonly>
                            <label for="floatingtax_type">{{ __('Tax Type') }}</label>
                        </div>
                    @endif
                </div>


                <div class="d-flex justify-content-center">
                    <span wire:click="onclickformreset" class="btn btn-danger mx-2">{{ __('Reset') }}</span>
                    <button type="submit" class="btn text-white theme_bg_color">{{ __('Update') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <form wire:submit.prevent="uploadcarticon" class="card shadow-sm mt-2" autocomplete="off">
            <div class="card-body">
                <div class="card-title fs-5 fw-bold">{{ __('POS Cart Icon') }} :</div>
                <div class="text-center">

                    @if ($carticon)
                        <img class="rounded shadow-sm w-50" src="{{ $carticon->temporaryUrl() }}">
                    @elseif ($existingcarticon)
                        <img class="rounded shadow-sm w-50" src="{{ url('storage/' . $existingcarticon) }}">
                    @else
                        <img class="rounded shadow-sm w-50 mx-auto" alt="carticon"
                            src="{{ asset('image/dummy/200x200.jpg') }}">
                    @endif

                    @error('carticon')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mx-auto mt-5">
                        <label for="carticonid" class="btn btn-primary ">{{ __('Change Cart Icon') }}</label>
                        <input type="file" wire:model="carticon" id="carticonid" class="d-none">
                    </div>
                    @if ($carticon?->temporaryUrl())
                        <button type="submit" class="btn btn-success mt-2">{{ __('Save') }}</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
