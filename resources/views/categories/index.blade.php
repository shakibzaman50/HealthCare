@extends('layouts/contentNavbarLayout')

@section('title', 'Permission List')

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
    <div class="col-lg-3 col-md-6">
        @include('categories.includes.create')
    </div>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Slug</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($categories as $category)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td><img src="{{ asset('images/category/thumb/' . $category->image) }}" alt="" width="100px"></td>
            <td>

                <div class="btn-group" role="group" aria-label="Role Actions">
                    @include('categories.includes.edit', [
                    'category' => $category
                    ])
                    @include('categories.includes.delete', ['id' => $category->id])
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    <div>
        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection