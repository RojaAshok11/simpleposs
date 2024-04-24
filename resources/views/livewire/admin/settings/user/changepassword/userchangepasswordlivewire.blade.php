<div class="col-md-4 mx-auto mt-5">
    <form wire:submit.prevent="changepassword" class="p-4 p-md-5 border rounded-3 shadow-sm bg-white">
        <div class="form-floating mb-3">
            <input wire:model.blur="currentpassword" type="password"
                class="form-control @error('currentpassword') is-invalid @enderror"
                placeholder="{{ __('Current Password') }}" id="floatingcurrentpassword" autofocus>
            <label for="floatingcurrentpassword">{{ __('Current Password') }}</label>
            @error('currentpassword')
                <span class="text-danger"> <strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input wire:model.blur="password" type="password" class="form-control" id="floatingpassword"
                placeholder="{{ __('New Password') }}">
            <label for="floatingpassword">{{ __('New Password') }}</label>
            @error('password')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input wire:model.blur="password_confirmation" type="password" class="form-control"
                id="floatingpassword_confirmation" placeholder="{{ __('Confirm New Password') }}">
            <label for="floatingpassword_confirmation">{{ __('Confirm New Password') }}</label>
            @error('password_confirmation')
                <span class="text-danger"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="d-flex justify-content-center">
            <span wire:click="onclickformreset" class="btn btn-danger mx-2">{{ __('Reset') }}</span>
            <button type="submit" class="btn text-white theme_bg_color">{{ __('Change Password') }}</button>
        </div>
    </form>
</div>
