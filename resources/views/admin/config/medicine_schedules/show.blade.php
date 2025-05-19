@extends('layouts/contentNavbarLayout')

@section('title', 'Show Medicine Schedule')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($medicineSchedule->name) ? $medicineSchedule->name : 'Medicine Schedule' }}</h4>
        <div>
            <form method="POST" action="{!! route('medicine-schedules.destroy', $medicineSchedule->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('medicine-schedules.edit', $medicineSchedule->id ) }}" class="btn btn-primary"
                    title="Edit Medicine Schedule">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Medicine Schedule"
                    onclick="return confirm(&quot;Click Ok to delete Medicine Schedule.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('medicine-schedules.index') }}" class="btn btn-primary" title="Show All Medicine Schedule">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('medicine-schedules.create') }}" class="btn btn-secondary" title="Create New Medicine Schedule">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $medicineSchedule->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Is Active</dt>
            <dd class="col-lg-10 col-xl-9">{{ ($medicineSchedule->is_active) ? 'Yes' : 'No' }}</dd>
        </dl>
    </div>
</div>

@endsection
