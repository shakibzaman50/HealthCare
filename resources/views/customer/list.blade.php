@extends('layouts/contentNavbarLayout')

@section('title', 'Customer List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="card-body">
    @if ($message = Session::get('success'))
    <div class="alert alert-primary">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card">
        <h4 class="p-2">Customer Lists</h4>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                {{-- <th width="280px">Action</th> --}}
            </tr>
            @foreach ($lists as $list)
            <tr>
                <td>{{ $list->id }}</td>
                <td>{{ $list->name }}</td>
                <td>{{ $list->phone }}</td>
                <td>{{ $list->email }}</td>
                {{-- <td>

                    <div class="btn-group" role="group" aria-label="Role Actions">
                        @include('categories.includes.edit', [
                        'category' => $list
                        ])
                        @include('categories.includes.delete', ['id' => $list->id])
                    </div>
                </td> --}}
            </tr>
            @endforeach
        </table>
        <div>
            {{ $lists->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
@endsection