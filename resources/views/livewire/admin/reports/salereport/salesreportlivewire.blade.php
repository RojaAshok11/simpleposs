<div>
    <div class="card shadow-sm">
        <div class="card-header text-white theme_bg_color p-1">
            <div class="d-flex flex-row bd-highlight">
                <div class="flex-grow-1 bd-highlight mt-1"><span class="h5">{{ __('Sales Reports') }}</span>
                </div>
                <div class="bd-highlight d-flex gap-1">
                    <a class="btn btn-sm btn-secondary shadow float-end mx-1"href="{{ route('adminreports') }}"
                        role="button">{{ __('Back') }}</a>
                </div>
            </div>

        </div>
        <div class="card-body p-0">
            <div class="row g-1 align-items-center p-2">
                <div class="col-auto">
                    <label for="startdateid" class="col-form-label fw-bold fs-6">{{ __('From Date') }} :
                    </label>

                </div>
                <div class="col-auto">
                    <input type="date" wire:model="from_date" class="form-control form-control-sm" id="startdateid">
                </div>


                <div class="col-auto">
                    <label for="enddateid" class="col-form-label fw-bold fs-6">  {{ __('To Date ') }} : </label>
                </div>
                <div class="col-auto">
                    <input type="date" wire:model="to_date" class="form-control form-control-sm" id="enddateid">
                </div>

                <div class="col-auto">
                    <select wire:model.lazy="transactionstatus" class="form-select form-select-sm ">
                        <option value="0">{{ __('Select Status') }}</option>
                        @foreach (Config::get('archive.mode') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto">
                    <input type="text" wire:model="searchTerm" id="searchitem" class="form-control form-control-sm"
                        placeholder={{ __('Search') }} aria-describedby="passwordHelpInline">
                </div>

                <div class="col-auto text-start mt-1">
                    <button wire:click="export" class="btn btn-sm btn-success fw-bold">{{ __('Excel') }} 
                        <i class="bi bi-arrow-down"></i></button>
                    <button wire:click="pdf" class="btn btn-sm btn-success fw-bold">{{ __('PDF') }} 
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

            <div class="container text-center my-2">
                <div class="row">
                    <div class="col">
                        <h5 class="fw-bold text-start">{{ __('PROFIT') }} :<span
                                class="ms-2 badge text-bg-success rounded-pill">{{ $this->salereport->sum('grandtotal') - $this->salereport->sum('sub_total') }}</span>
                        </h5>
                    </div>
                    <div class="col">

                    </div>
                    <div class="col">
                        <h5 class="fw-bold">{{ __('TOTAL SALE AMOUNT') }} :<span
                                class="ms-2 badge text-bg-danger rounded-pill">{{ $this->salereport->sum('total') }}</span>
                        </h5>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <table id="salereportreport_id" class="table text-center table-hover m-0 p-0">
                    <thead>
                        <tr
                            class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                            <th>{{ __('S.NO') }}</th>
                            <th>{{ __('SALES ID') }}</th>
                            <th>{{ __('NAME') }}</th>
                            <th>{{ __('PAYMENT MODE') }}</th>
                            <th>{{ __('TOTAL ITEM') }}</th>
                            <th>{{ __('PROFIT') }}</th>
                            <th>{{ __('TOTAL') }}</th>
                            <th>{{ __('CREATED AT') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->salereport as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->uniqid }}</td>
                                <td>{{ $item->customer?->name }}</td>
                                <td>{{ $item->mode ? Config::get('archive.mode')[$item->mode] : '-' }}</td>
                                <td>{{ $item->total_items }}</td>
                                <td class="fw-bold text-success">{{ $item->grandtotal - $item->sub_total }}</td>
                                <td>{{ $item->total }}</td>
                                <td>{{ $item->created_at->format('d-m-Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-2">
                {!! $this->salereport->links() !!}
            </div>
        </div>
    </div>
</div>
