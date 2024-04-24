<div wire:ignore.self class="modal fade" id="createoreditModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="createoreditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            @if ($product)
                <div class="modal-header text-white theme_bg_color px-3 py-2">
                    <h5 class="modal-title" id="createoreditModalLabel">{{ __('STOCK ADJUSTMENT') }} :
                        {{ $product->uniqid }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <h5 class="text-center fw-semibold font-monospace mt-1">{{ __('CURRENT STOCK') }} :<span
                        class="badge bg-success ms-2">{{ $product?->stock }}</span></h5>
            @endif

            <div class="modal-body">
                <div class="row g-3">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <label for="stockadjustid" class="form-label">{{ __('STOCK') }}</label>
                            <span class="text-danger fw-bold">*</span>
                            <input wire:model.blur="form.stockadjust" type="text" class="form-control"
                                id="stockadjustid">
                            @error('form.stockadjust')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                @if ($product)
                    <div class="row justify-content-center mt-3">
                        <div class="col-4 text-end">
                            <button wire:click.prevent="addstock({{ $product->id }})" class="btn btn-sm btn-success"
                                type="button">{{ __('ADD') }}<i class="bi bi-plus-lg ms-1"></i></i></button>
                        </div>
                        <div class="col-4">
                            <button wire:click.prevent="substock({{ $product->id }})" class="btn btn-sm btn-danger"
                                type="button">{{ __('SUB') }}<i class="bi bi-dash-lg ms-1"></i></i></button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer bg-light px-2 py-1">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
