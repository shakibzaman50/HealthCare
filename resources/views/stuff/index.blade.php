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
<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Users Management</h4>
            <a class="btn btn-success" href="{{ route('users.create') }}">Create New User</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-datatable table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Roles</th>
                    <th scope="col">Status</th>
                    <th scope="col" width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                        <span class="badge bg-success">{{ $v }}</span>
                        @endforeach
                        @endif
                    </td>
                    <td>
                        @php
                        $statusLabel = array_flip(config('app.user_status'));
                        $status = $statusLabel[$user->status] ?? 'N/A';
                        @endphp
                        <span
                            class="badge rounded p-2 text-white {{ $user->status == config('app.user_status.active') ? 'bg-success' :'bg-danger' }}">
                            {{ Str::ucfirst($status) }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-2" role="group" aria-label="User Actions">
                            <a class="btn btn-primary flex-fill" href="{{ route('users.show', $user->id) }}">Show</a>
                            <a class="btn btn-success flex-fill" href="{{ route('users.edit', $user->id) }}">Edit</a>
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger flex-fill">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{!! $data->render() !!}
@endsection