@extends('backend.layouts.app')
@section('title', 'dashboard')
@section('style')
    <style>
        .shadow-primary-:hover {
            box-shadow: 0 0 10px #d901ff !important;
        }
    </style>
@endsection
@section('body')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack w-100">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center mb-2">
                    Dashboard
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">All Data</li>
                </ul>
            </div>
{{--            <div class="d-flex align-items-center gap-2 gap-lg-3">--}}
{{--                <div class="m-0">--}}
{{--                    <a href="#" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">--}}
{{--                        <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i>--}}
{{--                        Doctor Report--}}
{{--                    </a>--}}
{{--                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-350px" data-kt-menu="true" id="kt_menu_64572f2fd326f">--}}
{{--                        <div class="px-7 py-5">--}}
{{--                            <div class="fs-5 text-dark fw-bold">Filter Blood Sugar Record</div>--}}
{{--                        </div>--}}
{{--                        <div class="separator border-gray-200"></div>--}}
{{--                        <form action="{{ route('doctor.report') }}" method="POST" id="filter_form">--}}
{{--                            @csrf--}}
{{--                            <div class="px-7 py-5">--}}
{{--                                <div class="row mb-5">--}}
{{--                                    <div class="col-5">--}}
{{--                                        <label for="pdf" class="form-label fw-semibold"><input id="pdf" value="pdf" type="radio" name="file" class="form-check-input me-2" checked>PDF</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-5">--}}
{{--                                        <label for="csv" class="form-label fw-semibold"><input id="csv" value="csv" type="radio" name="file" class="form-check-input me-2">CSV</label>--}}
{{--                                    </div>--}}
{{--                                    @error('file') <div class="text-danger">{{ $message }}</div> @enderror--}}
{{--                                </div>--}}
{{--                                <div class="row mb-5">--}}
{{--                                    <label for="days" class="form-label fw-semibold">Days:</label>--}}
{{--                                    <div>--}}
{{--                                        <select name="days" id="days" class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select Days" data-dropdown-parent="#kt_menu_64572f2fd326f" data-allow-clear="true">--}}
{{--                                            <option></option>--}}
{{--                                            <option value="7 Days" id="7" {{ old('days')=='7 Days'?'selected':'' }}>7 Days</option>--}}
{{--                                            <option value="15 Days" id="15" {{ old('days')=='15 Days'?'selected':'' }}>15 Days</option>--}}
{{--                                            <option value="1 Month" id="1" {{ old('days')=='1 Month'?'selected':'' }}>1 Month</option>--}}
{{--                                            <option value="2 Months" id="2" {{ old('days')=='2 Months'?'selected':'' }}>2 Months</option>--}}
{{--                                            <option value="3 Months" id="3" {{ old('days')=='3 Months'?'selected':'' }}>3 Months</option>--}}
{{--                                            <option value="6 Months" id="6" {{ old('days')=='6 Months'?'selected':'' }}>6 Months</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                    @error('days') <div class="text-danger">{{ $message }}</div> @enderror--}}
{{--                                </div>--}}
{{--                                <div class="row mb-5">--}}
{{--                                    <div class="col-6">--}}
{{--                                        <label for="from_date" class="form-label fw-semibold">From Date:</label>--}}
{{--                                        <input class="form-control" id="from_date" value="{{ old('from_date') }}" type="date" name="from_date"/>--}}
{{--                                        @error('from_date') <div class="text-danger">{{ $message }}</div> @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="col-6">--}}
{{--                                        <label for="to_date" class="form-label fw-semibold">To Date:</label>--}}
{{--                                        <input class="form-control" id="to_date" value="{{ old('to_date') }}" type="date" name="to_date" readonly/>--}}
{{--                                        @error('to_date') <div class="text-danger">{{ $message }}</div> @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mb-5">--}}
{{--                                    <label for="type" class="form-label fw-semibold">Type</label>--}}
{{--                                    <div>--}}
{{--                                        <select name="type[]" multiple id="type" class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_64572f2fd326f" data-allow-clear="true">--}}
{{--                                            <option></option>--}}
{{--                                            <option value="1" {{ '1'==old('type')?'selected':'' }}>Blood Pressure</option>--}}
{{--                                            <option value="2" {{ '2'==old('type')?'selected':'' }}>Blood Sugar</option>--}}
{{--                                        </select>--}}
{{--                                        @error('type') <div class="text-danger">{{ $message }}</div> @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="d-flex">--}}
{{--                                    <button type="submit" class="btn btn-sm btn-primary">Apply</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function (){
            const fromDate = $('#from_date');
            const toDate   = $('#to_date');
            const daysSelect = $('#days');

            function updateToField(days) {
                const startDate = new Date(fromDate.val());
                if (isNaN(startDate)) return;

                if ([7, 15].includes(days)) {
                    startDate.setDate(startDate.getDate() + days - 1);
                } else {
                    startDate.setMonth(startDate.getMonth() + days);
                    startDate.setDate(startDate.getDate() - 1);
                }

                const formatted = startDate.toISOString().split('T')[0];
                toDate.val(formatted);
            }

            function getSelectedDays() {
                return parseInt(daysSelect.find('option:selected').attr('id')) || 0;
            }

            function tryUpdate() {
                const days = getSelectedDays();
                if (fromDate.val() && days) updateToField(days);
            }

            daysSelect.on('change', tryUpdate);
            fromDate.on('change', tryUpdate);
        });
    </script>
@endsection
