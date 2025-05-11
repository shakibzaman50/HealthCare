@extends('layouts/layoutMaster')

@section('title', 'eCommerce Product List - Apps')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/select2/select2.scss'
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/select2/select2.js'
])
@endsection

@section('page-script')
@vite([
'resources/assets/js/app-ecommerce-product-list.js'
])
@endsection

@section('title', 'User List')

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">Create New Expense</h4>
        <div>
            <a href="{{ route('expenses.expense.index') }}" class="btn btn-primary" title="Show All Expense">
                <span class="fa-solid fa-table-list" aria-hidden="true"></span>
            </a>
        </div>
    </div>


    <div class="card-body">

        <form method="POST" class="needs-validation" novalidate action="{{ route('expenses.expense.store') }}"
            accept-charset="UTF-8" id="create_expense_form" name="create_expense_form" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include ('expenses.form', [
            'expense' => null,
            ])

            <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                <input class="p-2 rounded btn-primary" type="submit" value="Add">
            </div>

        </form>

    </div>
</div>

@endsection