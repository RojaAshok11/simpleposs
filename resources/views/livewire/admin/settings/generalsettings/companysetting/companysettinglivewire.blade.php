<div class="row justify-content-center ">
    <div class="col-md-5">
        <form wire:submit.prevent="store" class="card shadow-sm bg-white" autocomplete="off">
            <div class="card-body">
                <div class="card-title fs-5 fw-bold">{{ __('Company Information') }}:</div>
                <div class="row"></div>
                <div class="form-floating mb-3">
                    <input wire:model="companyfullname" type="text"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="{{ __('Company Fullname') }}" id="floatingcompanyfullname" autofocus>
                    <label for="floatingcompanyfullname">{{ __('Company Fullname') }}</label>
                    @error('companyfullname')
                        <span class="text-danger"> <strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="companyshortname" type="text" class="form-control"
                        id="floatingcompanyshortname" placeholder="{{ __('Company Shortname') }}">
                    <label for="floatingcompanyshortname">{{ __('Company Shortname') }}</label>
                    @error('companyshortname')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="phone" type="text" class="form-control" id="floatingphone"
                        placeholder="{{ __('Phone') }}">
                    <label for="floatingphone">{{ __('Phone') }}</label>
                    @error('phone')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="alternate_phone" type="text" class="form-control" id="floatingalternate_phone"
                        placeholder="{{ __('Alternate Phone') }}">
                    <label for="floatingalternate_phone">{{ __('Alternate Phone') }}</label>
                    @error('alternate_phone')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="email" type="text" class="form-control" id="floatingemail"
                        placeholder="{{ __('Email') }}">
                    <label for="floatingemail">{{ __('Email') }}</label>
                    @error('email')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="panno" type="text" class="form-control" id="floatingpanno"
                        placeholder="{{ __('Pan No') }}">
                    <label for="floatingpanno">{{ __('Pan No') }}</label>
                    @error('panno')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="gstno" type="text" class="form-control" id="floatinggstno"
                        placeholder="{{ __('GST No') }}">
                    <label for="floatinggstno">{{ __('GST No') }}</label>
                    @error('gstno')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input wire:model="websitename" type="text" class="form-control" id="floatingwebsitename"
                        placeholder="{{ __('Webiste') }}">
                    <label for="floatingwebsitename">{{ __('Webiste') }}</label>
                    @error('websitename')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- <div class="form-floating mb-3">
                    <select wire:model.blur="pos_theme" class="form-select" id="floatingpostheme">
                        @foreach (Config::get('archive.pos_theme') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <label for="floatingpostheme" class="form-label">Pos Theme</label>
                    @error('pos_theme')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <select wire:model.blur="pos_bill_position" class="form-select" id="floatingposbillposition">
                        @foreach (Config::get('archive.pos_bill_position') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <label for="floatingposbillposition" class="form-label">Pos Bill Position</label>
                    @error('pos_bill_position')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="form-floating mb-3">
                    <textarea wire:model="address" class="form-control" placeholder="{{ __('Address') }}" id="floatingaddress"></textarea>
                    <label for="floatingaddress">{{ __('Address') }}</label>
                    @error('address')
                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="d-flex justify-content-center">
                    <span wire:click="onclickformreset" class="btn btn-danger mx-2">{{ __('Reset') }}</span>
                    <button type="submit" class="btn text-white theme_bg_color">{{ __('Update') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <form wire:submit.prevent="uploadlogo" class="card shadow-sm mb-2" autocomplete="off">
            <div class="card-body">
                <div class="card-title fs-5 fw-bold">{{ __('Logo') }}:</div>
                <div class="text-center">
                    @if ($logo)
                        <img class="rounded shadow-sm w-50" src="{{ $logo->temporaryUrl() }}">
                    @elseif ($existinglogo)
                        <img class="rounded shadow-sm w-50" src="{{ url('storage/' . $existinglogo) }}">
                    @else
                        <img class="rounded shadow-sm w-50 mx-auto" alt="logo"
                            src="{{ asset('image/dummy/200x200.jpg') }}">
                    @endif

                    @error('logo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mx-auto mt-5">
                        <label for="logoid" class="btn btn-primary ">{{ __('Change Logo') }}</label>
                        <input type="file" wire:model="logo" id="logoid" class="d-none">
                    </div>
                    @if ($logo?->temporaryUrl())
                        <button type="submit" class="btn btn-success mt-2">{{ __('Save') }}</button>
                    @endif
                </div>
            </div>
        </form>
        <form wire:submit.prevent="uploadfavicon" class="card shadow-sm mt-2" autocomplete="off">
            <div class="card-body">
                <div class="card-title fs-5 fw-bold">{{ __('Favicon') }}:</div>
                <div class="text-center">

                    @if ($favicon)
                        <img class="rounded shadow-sm w-50" src="{{ $favicon->temporaryUrl() }}">
                    @elseif ($existingfavicon)
                        <img class="rounded shadow-sm w-50" src="{{ url('storage/' . $existingfavicon) }}">
                    @else
                        <img class="rounded shadow-sm w-50 mx-auto" alt="favicon"
                            src="{{ asset('image/dummy/200x200.jpg') }}">
                    @endif

                    @error('favicon')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mx-auto mt-5">
                        <label for="faviconid" class="btn btn-primary ">{{ __('Change Favicon') }}</label>
                        <input type="file" wire:model="favicon" id="faviconid" class="d-none">
                    </div>
                    @if ($favicon?->temporaryUrl())
                        <button type="submit" class="btn btn-success mt-2">{{ __('Save') }}</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
