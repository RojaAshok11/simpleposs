<div wire:ignore.self class="modal fade" id="holdsaleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="holdsaleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="storeholdsale" enctype="multipart/form-data">
                <div class="modal-header text-white theme_bg_color px-3 py-2">
                    <h5 class="modal-title" id="holdsaleModalLabel">
                        HOLD SALE </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <div class="alert alert-warning" role="alert">
                        <div class="fw-bold fs-3 text-center"> <i class="bi bi-exclamation-triangle me-2"></i>Alert
                        </div>
                        <div class="fs-4 text-center">Are you sure? You want to hold the sale.</div>
                    </div>

                    <div class="row g-3 justify-content-center mt-2">
                        @include('helper.formhelper.form', [
                            'type' => 'text',
                            'fieldname' => 'reference_id',
                            'labelname' => 'REFERENCE ID',
                            'labelidname' => 'reference_idid',
                            'required' => true,
                            'readonly' => false,
                            'col' => 'col-md-',
                        ])
                    </div>
                </div>
                <div class="modal-footer bg-light px-2 py-1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Hold
                        <span wire:loading.delay class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true">
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
