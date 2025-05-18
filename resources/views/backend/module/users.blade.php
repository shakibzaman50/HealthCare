@extends('backend.layouts.app')
@section('title', 'users')
@section('body')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack w-100">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-3">
                    Manage Users
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Manage</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Users</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <div class="m-0">
                    <a href="#" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-6 text-muted me-1"><span class="path1"></span><span class="path2"></span></i>
                        Filter
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown w-300px" data-kt-menu="true" id="kt_menu_64572f2fd326f">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Filter Users</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <form action="{{ route('users.filter') }}" method="POST" id="filter_form">
                            @csrf
                            <div class="px-7 py-5">
                                <div class="row mb-5">
                                    <div class="col-12 mb-5">
                                        <label for="status" class="form-label fw-semibold">Status</label>
                                        <div>
                                            <select name="status" id="status" class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select Type" data-dropdown-parent="#kt_menu_64572f2fd326f" data-allow-clear="true">
                                                <option></option>
                                                <option value="1" {{ old('status')=='1'?'selected':'' }}>Active</option>
                                                <option value="2" {{ old('status')=='2'?'selected':'' }}>Deleted</option>
                                            </select>
                                        </div>
                                        @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 mb-5">
                                        <label for="field" class="form-label fw-semibold">Field:</label>
                                        <div>
                                            <select name="field" id="field" class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select Field" data-dropdown-parent="#kt_menu_64572f2fd326f" data-allow-clear="true">
                                                <option></option>
                                                <option value="name" {{ old('field')=='name'?'selected':'' }}>Name</option>
                                                <option value="email" {{ old('field')=='email'?'selected':'' }}>Email</option>
                                            </select>
                                        </div>
                                        @error('field') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="value" class="form-label fw-semibold">Value:</label>
                                        <input class="form-control" id="value" value="{{ old('value') }}" type="text" name="value" placeholder="field value"/>
                                        @error('value') <div class="text-danger">{{ $message }}</div> @enderror
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
        </div>
    </div>
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div id="kt_app_content_container" class="app-container">
            <div class="card card-flush">
                <div class="card-header align-items-center pt-5 gap-2 gap-md-5">
                    <div class="card-title w-100 w-lg-50 me-0">
                        <div class="d-flex align-items-center position-relative my-1 w-100 w-lg-75">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
                            <input type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid w-lg-250px w-100 ps-12"
                                   placeholder="Search here"/>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">#</th>
                            <th class="min-w-100px ps-5">Name</th>
                            <th class="min-w-50px text-center">Email</th>
                            <th class="min-w-50px text-center">Status</th>
                            <th class="min-w-50px text-center">Is_Deleted</th>
                            <th class="text-end min-w-70px pe-5">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        @foreach($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>
                                    <div class="text-info fs-6 fw-bold">{{ $item->name }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="text-info fs-6 fw-bold">{{ $item->email }}</div>
                                </td>
                                <td class="text-center">
                                    {!! $item->status_badge !!}
                                </td>
                                <td class="text-center">
                                    {!! $item->delete_badge !!}
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="{{ route('users.show',encrypt($item->id)) }}" class="menu-link px-3 bg-light-info text-info">
                                                <i class="fa fa-eye text-info me-2"></i>Details
                                            </a>
                                        </div>
                                        @if(!$item->trashed())
                                            <div class="menu-item px-3">
                                                @php $class = $item->is_active==config('basic.status.active') ? 'warning' : 'success';@endphp
                                                <a href="{{ route('users.edit',encrypt($item->id)) }}" class="active-status menu-link px-3 bg-light-{{ $class  }} text-{{ $class  }}">
                                                    <i class="fa fa-blind text-{{ $class  }} me-2"></i><span id="active-status">{{ $item->is_active==config('basic.status.active') ? 'Deactivate' : 'Active' }}</span>
                                                </a>
                                            </div>
                                        @endif
                                        <div class="menu-item px-3">
                                            @php
                                                $class = $item->trashed() ? 'success' : 'danger';
                                            @endphp
                                            <form action="{{ route('users.destroy',encrypt($item->id)) }}" method="POST" class="delete-status menu-link px-3 bg-light-{{ $class  }} text-{{ $class  }}">
                                                <input type="hidden" name="_method" value="DELETE">
                                                @csrf
                                                <i class="fa fa-trash{{ $item->trashed() ? '-restore' : '' }} text-{{ $class  }} me-2"></i><span id="delete-status">{{ $item->trashed() ? 'Restore' : 'Delete' }}</span>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('.active-status').on('click', function () {
                event.preventDefault();
                let status = $(this).find('#active-status').text();
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${status} this User`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: status==='Deactivate' ? '#d33' : '#0fea5c',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: `Yes, ${status} it!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = $(this).attr('href');
                    }
                });
            });

            $('.delete-status').on('click', function () {
                let status = $(this).find('#delete-status').text();
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${status} this User`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: status==='Delete' ? '#d33' : '#0fea5c',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: `Yes, ${status} it!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).submit();
                    }
                });
            });
        });
    </script>
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('/') }}assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('/') }}assets/js/custom/apps/ecommerce/catalog/categories.js"></script>
@endsection
