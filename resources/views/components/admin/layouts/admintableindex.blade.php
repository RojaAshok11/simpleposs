<div class="card shadow-sm">
    <div class="card-header text-white theme_bg_color">
        <div class="d-flex flex-row bd-highlight">
            <div class="flex-grow-1 bd-highlight mt-1"><span class="h5">{{ $title }}</span></div>
            <div class="bd-highlight">
                {{ $action }}
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="clearfix">
            <div class="col-md-1 float-start">
                <select wire:click="updatepagination" wire:model="paginationlength" class="form-select"
                    aria-label="Default select example">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="mb-2 col-md-3 float-end">
                <input wire:model.live="searchTerm" type="text" class="form-control bg-white"
                    placeholder="{{ __('Search...') }}">
            </div>
        </div>

        <div class="table-responsive">
            <table id="tableid" class="table table-striped table-hover w-100 text-center">
                <thead
                    class="text-white table-{{ App::make('themesetting') ? strtolower(App::make('themesetting')->theme_name) : 'teal' }}">
                    <tr>
                        {{ $tableheader }}
                    </tr>
                </thead>
                <tbody>
                    {{ $tablebody }}
                </tbody>
            </table>


            <div class="d-flex bd-highlight">
                <div class="p-1 bd-highlight">{{ $tablerecordtotal }}</div>
                <div class="ms-auto p-1 bd-highlight">{{ $pagination }}</div>
            </div>
        </div>
    </div>
</div>
