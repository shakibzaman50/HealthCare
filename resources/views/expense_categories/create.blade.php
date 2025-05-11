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
@php
use Illuminate\Support\Str;
@endphp

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">Create New Expense Category</h4>
        <div>
            <a href="{{ route('expense_categories.expense_category.index') }}" class="btn btn-primary"
                title="Show All Expense Category">
                <span class="fa-solid fa-table-list" aria-hidden="true"></span>
            </a>
        </div>
    </div>


    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="list-unstyled mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" class="needs-validation" novalidate
            action="{{ route('expense_categories.expense_category.store') }}" accept-charset="UTF-8"
            id="create_expense_category_form" name="create_expense_category_form">
            {{ csrf_field() }}
            @include ('expense_categories.form', [
            'expenseCategory' => null,
            ])

            <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                <input class="btn-primary p-2 rounded" type="submit" value="Add">
            </div>

        </form>

    </div>
</div>

@endsection