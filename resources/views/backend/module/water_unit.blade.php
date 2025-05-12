@extends('backend.layouts.app')
@section('title', 'water units')
@section('body')
    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-3">
                    Manage Water Unit
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted"><a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a></li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Manage</li>
                    <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                    <li class="breadcrumb-item text-muted">Water Unit</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div id="kt_app_content_container" class="app-container">
            <div class="card card-flush">
                <div class="card-header align-items-center pt-5 gap-2 gap-md-5">
                    <div class="card-title w-100 w-lg-50 me-0">
                        <div class="d-flex align-items-center position-relative my-1 w-100 w-lg-75">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                        class="path1"></span><span class="path2"></span></i>
                            <input type="text" data-kt-ecommerce-category-filter="search"
                                   class="form-control form-control-solid w-lg-250px w-100 ps-12"
                                   placeholder="Search here" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <a class="btn btn-primary" id="add_button">Add Unit</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">#</th>
                            <th class="min-w-150px ps-3">Name</th>
                            <th class="min-w-50px text-center">Status</th>
                            <th class="min-w-400px text-center">Created_At</th>
                            <th class="text-end min-w-70px pe-5">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        @foreach($waterUnits as $item)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>
                                    <div class="text-primary fs-5 fw-bold">{{ $item->name }}</div>
                                </td>
                                <td class="text-center">
                                    {!! $item->status_badge !!}
                                </td>
                                <td class="text-center">
                                    <div class="text-info fs-7">{{ $item->created_at->format('d-M, Y') }}</div>
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                       class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center"
                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions<i
                                                class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                         data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            @php $class = $item->status==config('basic.status.active') ? 'warning' : 'success' @endphp
                                            <a href="{{ route('water-units.edit', encrypt($item->id)) }}"
                                               class="status-change menu-link px-3 bg-light-{{ $class }} text-{{ $class }}">
                                                <i class="fa fa-eye{{ $item->status==config('basic.status.active') ? '-slash' : '' }} text-{{ $class }} me-2"></i><span
                                                        id="status-change">{{ $item->status==config('basic.status.active') ? 'Inactive' : 'Active' }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item px-3 mb-1">
                                            <a data-item="{{ $item }}"
                                               class="edit-item menu-link px-3 bg-light-primary text-primary"><i
                                                        class="fa fa-edit me-2 text-primary"></i>Edit</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a id="{{ $item->id }}"
                                               class="delete-item menu-link px-3 bg-light-danger text-danger">
                                                <i class="fa fa-trash text-danger me-2"></i>Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $waterUnits->links() }}
                </div>
            </div>
            <form id="delete_form" method="POST">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
            </form>
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="kt_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <form class="form" action="{{ route('water-units.store') }}" method="POST" id="modal_form"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" id="kt_modal_new_address_header">
                        <h3 class="text-center mx-auto" id="modal_title">Add New Water Unit</h3>
                        <div class="btn btn-sm btn-icon btn-active-color-primary" id="closeModalBtn"
                             data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <div id="method"></div>
                        <input type="hidden" value="" name="update" id="update">
                    </div>
                    <div class="modal-body py-10 px-lg-10" id="modal_body">
                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll"
                             data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                             data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header"
                             data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px">
                            <div class="row">
                                <div class="col-12 fv-row mb-5">
                                    <label for="name" class="required fs-5 fw-semibold mb-2">Name</label>
                                    <input id="name" value="{{ old('name') }}" type="text"
                                           class="form-control form-control-solid" placeholder="sugar unit name"
                                           name="name" />
                                    @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="submit" onclick="this.disabled=true; this.form.submit()" class="btn btn-primary">
                            <span class="indicator-label" id="submit_button">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            let update = $('#update');
            let method = $('#method');
            let form = $('#modal_form');
            let btn = $('#submit_button');
            let title = $('#modal_title');
            let modal = $('#kt_modal');
            let error = $('#kt_modal .text-danger');

            function pushContent() {
                update.val('update');
                btn.text('Update');
                title.text('Edit this Water Unit');
                method.html('<input type="hidden" name="_method" value="PUT">');
            }

            @if($errors->any())
            modal.modal('show');
            if ("{{ old('update') }}" === 'update') {
                form.attr('action', `{{ route('water-units.update','') }}/${localStorage.getItem('id')}`);
                pushContent();
            }
            @endif

            $('#add_button').on('click', function() {
                update.val('');
                btn.text('Submit');
                title.text('Add New Water Unit');
                method.html('<input type="hidden" name="_method" value="POST">');
                form.attr('action', "{{ route('water-units.store') }}");
                error.text('');
                modal.modal('show');
                form[0].reset();
            });

            $('.edit-item').on('click', function() {
                form[0].reset();
                let item = $(this).data('item');
                $('#name').val(item.name);
                form.attr('action', `{{ route('water-units.update','') }}/${item.id}`);
                pushContent();
                error.text('');
                modal.modal('show');
                localStorage.setItem('id', item.id);
            });

            $('#closeModalBtn').on('click', function() {
                modal.modal('hide');
            });

            $('.delete-item').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete_form').attr('action', `{{ route('water-units.destroy','') }}/${$(this).attr('id')}`).submit();
                    }
                });
            });

            $('.status-change').on('click', function() {
                event.preventDefault();
                let status = $(this).find('#status-change').text();
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${status} this Unit status`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: status === 'Inactive' ? '#d33' : '#0fea5c',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: `Yes, ${status} it!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = $(this).attr('href');
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
