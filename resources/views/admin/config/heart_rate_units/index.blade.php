@extends('layouts/contentNavbarLayout')

@section('title', 'List Heart Rate Unit')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

@if(Session::has('success_message'))
<div class="alert alert-success alert-dismissible" role="alert">
    {!! session('success_message') !!}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(Session::has('error_message'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {!! session('error_message') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">Heart Rate Units</h4>
        <div>
            <a href="{{ route('heart-rate-units.create') }}" class="btn btn-secondary"
                title="Create New Heart Rate Unit">
                <span class="fa-solid fa-plus" aria-hidden="true"></span>
            </a>
        </div>
    </div>

    @if(count($heartRateUnits) == 0)
    <div class="card-body text-center">
        <h4>No Heart Rate Units Available.</h4>
    </div>
    @else
    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Is Active</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($heartRateUnits as $heartRateUnit)
                    <tr>
                        <td class="align-middle">{{ $heartRateUnit->name }}</td>
                        <td class="align-middle">{{ ($heartRateUnit->is_active) ? 'Yes' : 'No' }}</td>

                        <td class="text-end">

                            <form method="POST" action="{!! route('heart-rate-units.destroy', $heartRateUnit->id) !!}"
                                accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('heart-rate-units.show', $heartRateUnit->id ) }}"
                                        class="btn btn-info" title="Show Heart Rate Unit">
                                        <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                    </a>
                                    <a href="{{ route('heart-rate-units.edit', $heartRateUnit->id ) }}"
                                        class="btn btn-primary" title="Edit Heart Rate Unit">
                                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                    </a>

                                    <button type="submit" class="btn btn-danger" title="Delete Heart Rate Unit"
                                        onclick="return confirm(&quot;Click Ok to delete Heart Rate Unit.&quot;)">
                                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                                    </button>
                                </div>

                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {!! $heartRateUnits->links('pagination') !!}
    </div>

    @endif

</div>
@endsection
