@extends('layouts/contentNavbarLayout')

@section('title', 'Supplier List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="card p-2">
    <h5 class="card-header">Supplier List</h5>
    <div class="p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style2 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('suppliers.index') }}">Supplier</a>
                </li>
                <li class="breadcrumb-item active text-danger">List</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-3 col-md-6">
        @include('suppliers.includes.create')
    </div>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Prev. Due</th>
                <th>Total Due</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status==1 ? 'Active' : 'Inactive' }}</td>
                <td>{{ $user->account->previous_due ?? 0}}</td>
                <td>{{ $user->account->total_due ?? 0}}</td>
                <td>

                    @can('supplier-transaction')
                    <a class="btn btn-primary"
                        href="{{ route('supplier.transaction.show',$user->id) }}">Transactions</a>
                    @endcan
                    @can('supplier-order')
                    <a class="btn btn-primary" href="{{ route('supplier.invoices.list',$user->id) }}">Product
                        Invoice</a>
                    @endcan
                    @can('supplier-payment')

                    <a class="btn btn-primary" href="{{ route('supplier.payment.list',$user->id) }}">Payment Info</a>
                    @endcan
                    @can('supplier-edit')

                    @include('suppliers.includes.edit', ['user' => $user])
                    @endcan

                    @can('supplier-delete')

                    @include('suppliers.includes.delete', ['id' => $user->id])
                    @endcan

                    @can('supplier-create')

                    @include('suppliers.payments.modals.create', ['user' => $user])
                    @endcan

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<!--/ Contextual Classes -->
@endsection

<style>
    .btn-group .btn {
        margin-right: 5px;
        /* Adjust spacing between buttons */
    }

    .btn-group .btn:last-child {
        margin-right: 0;
        /* Remove right margin from the last button */
    }
</style>