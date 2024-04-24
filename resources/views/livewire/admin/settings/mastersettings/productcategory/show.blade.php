<div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        @if ($showdata)
            <div class="modal-content">
                <div class="modal-header text-white theme_bg_color px-3 py-2">
                    <h5 class="modal-title" id="showModalLabel"> {{ __('SHOW  PRODUCT CATEGORY') }} :
                        {{ $showdata->uniqid }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-white">
                    <div class="row">
                        @include('helper.formhelper.showlabel', [
                            'name' => __('PRODUCT CATEGORY ID'),
                            'value' => $showdata->uniqid,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('PRODUCT CATEGORY NAME'),
                            'value' => $showdata->name,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])

                        @if ($showdata->image)
                            <div class="row col-md-6 p-1">
                                <label class="fw-bolder col-5">IMAGE </label>
                                <label class="fst-normal text-break col-7"><b> : </b>
                                    <img src="{{ url('storage/' . $showdata->image) }}" class="img-fluid rounded"
                                        style="width: 60px" height="50px"></label>
                            </div>
                        @endif

                        @include('helper.formhelper.showlabel', [
                            'name' => __('ACTIVE'),
                            'value' => $showdata->active
                                ? '<span class="badge bg-success fs-6">Yes</span>'
                                : '<span class="badge bg-danger fs-6">No</span>',
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('NOTE'),
                            'value' => $showdata->note,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('CREATED BY'),
                            'value' => $showdata->createdby?->name,
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @include('helper.formhelper.showlabel', [
                            'name' => __('CREATED AT'),
                            'value' => $showdata->created_at->format('d-M-Y h:i'),
                            'columnone' => 'col-md-6',
                            'columntwo' => 'col-5',
                            'columnthree' => 'col-7',
                        ])
                        @if ($showdata->updated_id)
                            @include('helper.formhelper.showlabel', [
                                'name' => __('UPDATED BY'),
                                'value' => $showdata->updatedby?->name,
                                'columnone' => 'col-md-6',
                                'columntwo' => 'col-5',
                                'columnthree' => 'col-7',
                            ])
                            @include('helper.formhelper.showlabel', [
                                'name' => __('UPDATED AT'),
                                'value' => $showdata->updated_at->format('d-M-Y h:i'),
                                'columnone' => 'col-md-6',
                                'columntwo' => 'col-5',
                                'columnthree' => 'col-7',
                            ])
                        @endif
                    </div>
                </div>
                <div class="modal-footer bg-light px-2 py-1">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        @endif
    </div>
</div>
