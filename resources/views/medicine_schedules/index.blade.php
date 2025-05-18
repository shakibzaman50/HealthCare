@extends('layouts/contentNavbarLayout')

@section('title', 'List Medicine Schedule')

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
            <h4 class="m-0">Medicine Schedules</h4>
            <div>
                <a href="{{ route('medicine-schedules.create') }}" class="btn btn-secondary" title="Create New Medicine Schedule">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($medicineSchedules) == 0)
            <div class="card-body text-center">
                <h4>No Medicine Schedule Available.</h4>
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
                    @foreach($medicineSchedules as $medicineSchedule)
                        <tr>
                            <td class="align-middle">{{ $medicineSchedule->name }}</td>
                            <td class="align-middle">{{ ($medicineSchedule->is_active) ? 'Yes' : 'No' }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('medicine-schedules.destroy', $medicineSchedule->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('medicine-schedules.show', $medicineSchedule->id ) }}" class="btn btn-info" title="Show Medicine Schedule">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('medicine-schedules.edit', $medicineSchedule->id ) }}" class="btn btn-primary" title="Edit Medicine Schedule">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Medicine Schedule" onclick="return confirm(&quot;Click Ok to delete Medicine Schedule.&quot;)">
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
            {!! $medicineSchedules->links('pagination') !!}
        </div>
        @endif
    </div>
@endsection
