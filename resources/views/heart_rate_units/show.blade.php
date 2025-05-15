@extends('layouts/contentNavbarLayout')

@section('title', 'Show Heart Rate Unit')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($heartRateUnit->name) ? $heartRateUnit->name : 'Heart Rate Unit' }}</h4>
        <div>
            <form method="POST" action="{!! route('heart-rate-units.heart-rate-unit.destroy', $heartRateUnit->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('heart-rate-units.heart-rate-unit.edit', $heartRateUnit->id ) }}" class="btn btn-primary" title="Edit Heart Rate Unit">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Heart Rate Unit" onclick="return confirm(&quot;Click Ok to delete Heart Rate Unit.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('heart-rate-units.heart-rate-unit.index') }}" class="btn btn-primary" title="Show All Heart Rate Unit">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('heart-rate-units.heart-rate-unit.create') }}" class="btn btn-secondary" title="Create New Heart Rate Unit">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $heartRateUnit->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Is Active</dt>
            <dd class="col-lg-10 col-xl-9">{{ ($heartRateUnit->is_active) ? 'Yes' : 'No' }}</dd>

        </dl>

    </div>
</div>

@endsection