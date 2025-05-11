@extends('layouts/contentNavbarLayout')

@section('title', 'Status List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($status->name) ? $status->name : 'Status' }}</h4>
        <div>
            <form method="POST" action="{!! route('statuses.status.destroy', $status->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('statuses.status.edit', $status->id ) }}" class="btn btn-primary" title="Edit Status">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Status"
                    onclick="return confirm(&quot;Click Ok to delete Status.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('statuses.status.index') }}" class="btn btn-primary" title="Show All Status">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('statuses.status.create') }}" class="btn btn-secondary" title="Create New Status">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $status->name }}</dd>

        </dl>

    </div>
</div>

@endsection