<div wire:ignore.self class="modal fade" id="printbarcodemodal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="printbarcodemodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        @if ($showbarcodeproduct)
            <div class="modal-content">
                <div class="modal-header text-white theme_bg_color px-3 py-2"
                    style="background-color: {{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_bg_color) : 'teal' }}">
                    <h5 class="modal-title" id="printbarcodemodalLabel">{{ __('Print Barcode') }} :
                        {{ $showbarcodeproduct->uniqid }} </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container my-4">
                        @php
                            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                        @endphp
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="col-md-4">
                                <label for="printcountid" class="form-label">{{ __('PRINT COUNT') }}</label>
                                <input wire:model.live="printcount" type="number" class="form-control"
                                    id="printcountid">
                                @error('printcount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            @for ($i = 0; $i < $printcount; $i++)
                                <div class="col-md-3">
                                    {{ strval($showbarcodeproduct->uniqid) }}
                                    {!! $generator->getBarcode(strval($showbarcodeproduct->uniqid), $generator::TYPE_CODE_128) !!}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-2 py-1">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" wire:click='printbarcode'
                        class="btn btn-success">{{ __('Print') }}</button>
                </div>
            </div>
        @endif
    </div>
</div>
