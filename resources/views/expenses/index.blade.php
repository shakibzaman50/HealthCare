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

@if(Session::has('success_message'))
<div class="alert alert-success alert-dismissible" role="alert">
    {!! session('success_message') !!}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">Expenses</h4>
        <div>
            <a href="{{ route('expenses.expense.create') }}" class="btn btn-secondary" title="Create New Expense">
                <span class="fa-solid fa-plus" aria-hidden="true"></span>
            </a>
        </div>
    </div>

    @if(count($expenses) == 0)
    <div class="card-body text-center">
        <h4>No Expenses Available.</h4>
    </div>
    @else
    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Created By</th>
                        <th>Received By</th>
                        <th>Update By</th>
                        <th>Payment Date</th>
                        <th>Invoice</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td class="align-middle">{{ optional($expense->Expensecategory)->name }}</td>
                        <td class="align-middle">{{ $expense->amount }}</td>
                        <td class="align-middle">{{ optional($expense->creator)->name }}</td>
                        <td class="align-middle">{{ optional($expense->receivedBy)->name }}</td>
                        <td class="align-middle">{{ optional($expense->updator)->name }}</td>
                        <td class="align-middle">{{ $expense->payment_date }}</td>
                        <td class="align-middle">
                            @if($expense->Invoice != null)
                            <img src="{{ asset('storage/' . $expense->Invoice) }}" width="100">
                            @else
                            No Image
                            @endif
                        </td>

                        <td class="text-end">

                            <form method="POST" action="{!! route('expenses.expense.destroy', $expense->id) !!}"
                                accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('expenses.expense.show', $expense->id ) }}" class="btn btn-info"
                                        title="Show Expense">
                                        <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                    </a>
                                    @can('expense-edit')
                                    <a href="{{ route('expenses.expense.edit', $expense->id ) }}"
                                        class="btn btn-primary" title="Edit Expense">
                                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                    </a>
                                    @endcan
                                    @can('expense-delete')
                                    <button type="submit" class="btn btn-danger" title="Delete Expense"
                                        onclick="return confirm(&quot;Click Ok to delete Expense.&quot;)">
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

        {!! $expenses->links('pagination') !!}
    </div>

    @endif

</div>
@endsection