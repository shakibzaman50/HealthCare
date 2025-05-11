@extends('layouts/contentNavbarLayout')

@section('title', 'Status List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ !empty($status->name) ? $status->name : 'Status' }}</h4>
        <div>
            <a href="{{ route('statuses.status.index') }}" class="btn btn-primary" title="Show All Status">
                <span class="fa-solid fa-table-list" aria-hidden="true"></span>
            </a>

            <a href="{{ route('statuses.status.create') }}" class="btn btn-secondary" title="Create New Status">
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
            action="{{ route('statuses.status.update', $status->id) }}" id="edit_status_form" name="edit_status_form"
            accept-charset="UTF-8">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('statuses.form', [
            'status' => $status,
            ])

            <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                <input class="btn btn-primary" type="submit" value="Update">
            </div>
        </form>

    </div>
</div>

@endsection