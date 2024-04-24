<div>
    <div class="card shadow-sm">
        <div class="card-header text-white theme_bg_color p-1">
            <div class="d-flex flex-row bd-highlight">
                <div class="flex-grow-1 bd-highlight mt-1"><span class="h5">{{ __('CREDIT / DEBIT REPORTS')}}
                        ({{ $this->balance }})</span>
                </div>
                <div class="bd-highlight d-flex gap-1">
                    <a class="btn btn-sm btn-secondary shadow float-end mx-1"href="{{ route('adminreports') }}"
                        role="button">{{ __('Back') }}</a>
                </div>
            </div>

        </div>
        <div class="card-body p-0">
            <div class="row g-3 align-items-center p-2">
                <div class="col-auto">
                    <label for="startdateid" class="col-form-label fw-bold fs-6"> {{ __('From Date') }} :
                    </label>

                </div>
                <div class="col-auto">
                    <input type="date" wire:model="from_date" class="form-control form-control-sm" id="startdateid">
                </div>


                <div class="col-auto">
                    <label for="enddateid" class="col-form-label fw-bold fs-6">
                        {{ __('To Date ') }} : </label>
                </div>
                <div class="col-auto">
                    <input type="date" wire:model="to_date" class="form-control form-control-sm" id="enddateid">
                </div>

                <div class="col-auto">
                    <input type="text" wire:model="searchTerm" id="searchitem" class="form-control form-control-sm"
                        placeholder={{ __('Select Status') }} aria-describedby="passwordHelpInline">
                </div>

                <div class="col-auto text-start mt-3">
                    <button wire:click="export" class="btn btn-sm btn-success fw-bold"> {{ __('Excel') }}
                        <i class="bi bi-arrow-down"></i></button>
                    <button wire:click="pdf" class="btn btn-sm btn-success fw-bold"> {{ __('PDF') }} 
                        <i class="bi bi-arrow-down"></i></button>
                    <button wire:click="clear" class="btn btn-sm btn-secondary">{{ __('Clear') }} </button>
                </div>

                <div class="col-auto">
                    <select wire:click="updatepagination" wire:model.lazy="paginationlength"
                        class="form-select form-select-sm ">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table id="salereportreport_id" class="table text-center table-hover m-0 p-0">
                    <thead class="text-white theme_bg_color">
                        <tr
                            class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                            <th>{{ __('S.NO') }}</th>
                            <th>{{ __('REFERENCE ID') }}</th>
                            <th>{{ __('CREDIT') }}</th>
                            <th>{{ __('DEBIT') }}</th>
                            <th>{{ __('BALANCE') }}</th>
                            <th>{{ __('CREATED AT') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->amountcdreport as $eachamountcd)
                            <tr class="{{ $eachamountcd->c_or_d == 'C' ? 'table-success' : 'table-danger' }}">
                                <td>
                                    {{ $loop->iteration }}</td>
                                <td>
                                    {{ $eachamountcd->amountcdable->uniqid }}</td>
                                <td class="text-center">
                                    {{ $eachamountcd->credit }}</td>
                                <td class="text-center">
                                    {{ $eachamountcd->debit }}</td>
                                <td class="text-center">
                                    {{ $eachamountcd->balance }}</td>
                                <td class="text-center">
                                    {{ $eachamountcd->created_at->format('d-m-Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-2">
                {!! $this->amountcdreport->links() !!}
            </div>
        </div>
    </div>
</div>
