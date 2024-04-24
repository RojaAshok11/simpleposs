<div>
    <div class="col-md-12">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <form wire:submit="login" class="p-4 p-md-5 border rounded-3 bg-light">
        <div class="form-floating mb-3">
            <input wire:model="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">{{ __('Email address') }}</label>
            @error('email')
                <span class="text-danger error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating mb-3">
            <input wire:model="password" type="password" class="form-control" id="floatingPassword"
                placeholder="Password">
            <label for="floatingPassword">{{ __('Password') }}</label>
            @error('password')
                <span class="text-danger error">{{ $message }}</span>
            @enderror
        </div>
        {{-- <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div> --}}
        <button class="w-100 btn btn-lg btn-primary" type="submit">{{ __('Sign in') }}</button>
        <hr class="my-4">
        <small class="text-muted">@Starpos Feedback {{ date('Y') }}</small>
    </form>
</div>
