@extends('layouts/contentNavbarLayout')

@section('title', 'List Sugar Schedule')

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

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Sugar Schedules</h4>
            <div>
                <a href="{{ route('sugar-schedules.create') }}" class="btn btn-secondary" title="Create New Sugar Schedule">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($sugarSchedules) == 0)
            <div class="card-body text-center">
                <h4>No Sugar Schedule Available.</h4>
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
                    @foreach($sugarSchedules as $sugarSchedule)
                        <tr>
                            <td class="align-middle">{{ $sugarSchedule->name }}</td>
                            <td class="align-middle">{{ ($sugarSchedule->is_active) ? 'Yes' : 'No' }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('sugar-schedules.destroy', $sugarSchedule->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('sugar-schedules.show', $sugarSchedule->id ) }}" class="btn btn-info" title="Show Sugar Schedule">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('sugar-schedules.edit', $sugarSchedule->id ) }}" class="btn btn-primary" title="Edit Sugar Schedule">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Sugar Schedule" onclick="return confirm(&quot;Click Ok to delete Sugar Schedule.&quot;)">
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

            {!! $sugarSchedules->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
