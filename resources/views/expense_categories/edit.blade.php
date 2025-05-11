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
        <h4 class="m-0">{{ !empty($expenseCategory->name) ? $expenseCategory->name : 'Expense Category' }}</h4>
        <div>
            <a href="{{ route('expense_categories.expense_category.index') }}" class="btn btn-primary"
                title="Show All Expense Category">
                <span class="fa-solid fa-table-list" aria-hidden="true"></span>
            </a>

            <a href="{{ route('expense_categories.expense_category.create') }}" class="btn btn-secondary"
                title="Create New Expense Category">
                <span class="fa-solid fa-plus" aria-hidden="true"></span>
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
            action="{{ route('expense_categories.expense_category.update', $expenseCategory->id) }}"
            id="edit_expense_category_form" name="edit_expense_category_form" accept-charset="UTF-8">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('expense_categories.form', [
            'expenseCategory' => $expenseCategory,
            ])

            <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                <input class="p-2 rounded btn-primary" type="submit" value="Update">
            </div>
        </form>

    </div>
</div>

@endsection