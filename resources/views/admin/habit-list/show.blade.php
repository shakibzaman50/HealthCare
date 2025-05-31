@extends('layouts/contentNavbarLayout')

@section('title', 'Show Habit List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($habitList->name) ? $habitList->name : 'Habit List' }}</h4>
        <div>
            <form method="POST" action="{!! route('admin.habit-lists.destroy', $habitList->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('admin.habit-lists.edit', $habitList->id ) }}" class="btn btn-primary"
                    title="Edit Habit List">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Habit List"
                    onclick="return confirm(&quot;Click Ok to delete Habit List.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('admin.habit-lists.index') }}" class="btn btn-primary" title="Show All Habit List">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('admin.habit-lists.create') }}" class="btn btn-secondary" title="Create New Habit List">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name: </dt>
            <dd class="col-lg-10 col-xl-9">{{ $habitList->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Is Active: </dt>
            <dd class="col-lg-10 col-xl-9">{{ ($habitList->is_active) ? 'Yes' : 'No' }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Icon: </dt>
            <dd class="col-lg-10 col-xl-9">
                <img src="{{ asset($habitList->icon) }}" alt="icon">
            </dd>

        </dl>

    </div>
</div>

@endsection
