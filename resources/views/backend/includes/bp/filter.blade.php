<div class="d-flex align-items-center gap-2 gap-lg-3">
    <div class="m-0">
        <a href="#" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i>
            Filter
        </a>
        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-250px" data-kt-menu="true" id="kt_menu_64572f2fd326f">
            <div class="px-7 py-5">
                <div class="fs-5 text-dark fw-bold">Filter Blood Sugar Record</div>
            </div>
            <div class="separator border-gray-200"></div>
            <form action="{{ route('blood-pressures.filter') }}" method="POST" id="filter_form">
                @csrf
                <div class="px-7 py-5">
                    <div class="row mb-5">
                        <div class="col-12 mb-5">
                            <label for="from_date" class="form-label fw-semibold">From Date:</label>
                            <input class="form-control" id="from_date" value="{{ old('from_date') }}" type="date" name="from_date"/>
                            @error('from_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="to_date" class="form-label fw-semibold">To Date:</label>
                            <input class="form-control" id="to_date" value="{{ old('to_date') }}" type="date" name="to_date"/>
                            @error('to_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
