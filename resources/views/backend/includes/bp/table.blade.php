<div class="card-header align-items-center pt-5 gap-2 gap-md-5">
    <div class="card-title w-100 w-lg-50 me-0">
        <div class="d-flex align-items-center position-relative my-1 w-100 w-lg-75">
            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span class="path2"></span></i>
            <input type="text" data-kt-ecommerce-category-filter="search" class="form-control form-control-solid w-lg-250px w-100 ps-12"
                   placeholder="Search here"/>
        </div>
    </div>
    <div class="card-toolbar">
        @isset($add)
            <a class="btn btn-primary" id="add_button">Add BP</a>
        @endisset
    </div>
</div>
<div class="card-body pt-0">
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
        <thead>
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th class="w-10px pe-2">#</th>
            <th class="min-w-100px ps-6">Date</th>
            <th class="min-w-50px text-center">Time</th>
            <th class="min-w-50px text-center">Average</th>
            <th class="min-w-50px text-center">Status</th>
            <th class="w-250px text-center">Note</th>
            <th class="text-end min-w-70px pe-5">Actions</th>
        </tr>
        </thead>
        <tbody class="fw-semibold text-gray-600">
        @foreach($bloodPressures as $item)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>
                    <div class="text-info fs-6 fw-bold">{{ $item->formattedDate }}</div>
                </td>
                <td class="text-center">
                    <div class="badge badge-light-info fs-6">{{ $item->formattedTime }}</div>
                </td>
                <td class="text-center">
                    <div class="badge badge-light-info fs-6">{{ $item->average }}</div>
                </td>
                <td class="text-center">
                    <div class="badge badge-light-info fs-6">{{ $item->status }}</div>
                </td>
                <td class="text-center">
                    <div class="fs-7 text-info">{{ $item->note }}</div>
                </td>
                <td class="text-end">
                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions<i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        @isset($delete)
                        <div class="menu-item px-3">
                            <a id="{{ encrypt($item->id) }}" class="delete-item menu-link px-3 bg-light-danger text-danger">
                                <i class="fa fa-trash text-danger me-2"></i>Delete
                            </a>
                        </div>
                        @endisset
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card-footer">
    {{ $bloodPressures->links() }}
</div>
<form id="delete_form" method="POST">
    @csrf
    <input type="hidden" name="_method" value="DELETE">
</form>
