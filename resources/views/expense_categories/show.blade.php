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
        <h4 class="m-0">{{ isset($expenseCategory->name) ? $expenseCategory->name : 'Expense Category' }}</h4>
        <div>
            <form method="POST"
                action="{!! route('expense_categories.expense_category.destroy', $expenseCategory->id) !!}"
                accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('expense_categories.expense_category.edit', $expenseCategory->id ) }}"
                    class="btn btn-primary" title="Edit Expense Category">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Expense Category"
                    onclick="return confirm(&quot;Click Ok to delete Expense Category.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('expense_categories.expense_category.index') }}" class="btn btn-primary"
                    title="Show All Expense Category">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('expense_categories.expense_category.create') }}" class="btn btn-secondary"
                    title="Create New Expense Category">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $expenseCategory->name }}</dd>

        </dl>

    </div>
</div>

@endsection