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
        <h4 class="m-0">{{ isset($title) ? $title : 'Expense' }}</h4>
        <div>
            <form method="POST" action="{!! route('expenses.expense.destroy', $expense->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}
                @can('expense-edit')

                <a href="{{ route('expenses.expense.edit', $expense->id ) }}" class="btn btn-primary"
                    title="Edit Expense">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>
                @endcan
                @can('expense-delete')
                <button type="submit" class="btn btn-danger" title="Delete Expense"
                    onclick="return confirm(&quot;Click Ok to delete Expense.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>
                @endcan
                <a href="{{ route('expenses.expense.index') }}" class="btn btn-primary" title="Show All Expense">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('expenses.expense.create') }}" class="btn btn-secondary" title="Create New Expense">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Category</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($expense->Expensecategory)->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Description</dt>
            <dd class="col-lg-10 col-xl-9">{{ $expense->description }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Amount</dt>
            <dd class="col-lg-10 col-xl-9">{{ $expense->amount }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Created By</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($expense->creator)->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Received By</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($expense->receivedBy)->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated By</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($expense->updator)->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Payment Date</dt>
            <dd class="col-lg-10 col-xl-9">{{ $expense->payment_date }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Updated Date</dt>
            <dd class="col-lg-10 col-xl-9">{{ ($expense->updated_at) }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Invoice</dt>
            <dd class="col-lg-10 col-xl-9">
                <div class="card">
                    <img src="{{ asset('storage/' . $expense->Invoice) }}">
                </div>
            </dd>

        </dl>

    </div>
</div>

@endsection