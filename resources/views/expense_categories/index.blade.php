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

@if(Session::has('success_message'))
<div class="alert alert-success alert-dismissible" role="alert">
    {!! session('success_message') !!}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">Expense Categories</h4>
        <div>
            <a href="{{ route('expense_categories.expense_category.create') }}" class="btn btn-secondary"
                title="Create New Expense Category">
                <span class="fa-solid fa-plus" aria-hidden="true"></span>
            </a>
        </div>
    </div>

    @if(count($expenseCategories) == 0)
    <div class="card-body text-center">
        <h4>No Expense Categories Available.</h4>
    </div>
    @else
    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Name</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenseCategories as $expenseCategory)
                    <tr>
                        <td class="align-middle">{{ $expenseCategory->name }}</td>

                        <td class="text-end">

                            <form method="POST"
                                action="{!! route('expense_categories.expense_category.destroy', $expenseCategory->id) !!}"
                                accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('expense_categories.expense_category.show', $expenseCategory->id ) }}"
                                        class="btn btn-info" title="Show Expense Category">
                                        <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                    </a>
                                    <a href="{{ route('expense_categories.expense_category.edit', $expenseCategory->id ) }}"
                                        class="btn btn-primary" title="Edit Expense Category">
                                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                    </a>
                                    @can('expense-category-delete')
                                    <button type="submit" class="btn btn-danger" title="Delete Expense Category"
                                        onclick="return confirm(&quot;Click Ok to delete Expense Category.&quot;)">
                                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                                    </button>
                                    @endcan
                                </div>

                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {!! $expenseCategories->links('pagination') !!}
    </div>

    @endif

</div>
@endsection