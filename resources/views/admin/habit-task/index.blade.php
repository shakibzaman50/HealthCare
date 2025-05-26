@extends('layouts/contentNavbarLayout')

@section('title', 'Habit Task')

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
            <h4 class="m-0">Habit Task</h4>
            <div>
                <a href="{{ route('admin.habit-tasks.create') }}" class="btn btn-secondary" title="Create New Habit Task">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($habitTasks) == 0)
            <div class="card-body text-center">
                <h4>No Habit Task Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>List Name</th>
                            <th>Is Active</th>
                            <th>Icon</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($habitTasks as $habitTask)
                        <tr>
                            <td class="align-middle">{{ $habitTask->name }}</td>
                            <td class="align-middle">{{ $habitTask->habitList->name }}</td>
                            <td class="align-middle">{{ ($habitTask->is_active) ? 'Yes' : 'No' }}</td>
                            <td>
                                @if(file_exists($habitTask->icon))
                                    <img src="{{ asset($habitTask->icon) }}" alt="icon" class="img-fluid" style="width: 40px; height: 40px;">
                                @else
                                    <span>N/A</span>
                                @endif
                            </td>
                            <td class="text-end">

                                <form method="POST" action="{!! route('admin.habit-tasks.destroy', $habitTask->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.habit-tasks.show', $habitTask->id ) }}" class="btn btn-info" title="Show Habit Task">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('admin.habit-tasks.edit', $habitTask->id ) }}" class="btn btn-primary" title="Edit Habit Task">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Habit Task" onclick="return confirm(&quot;Click Ok to delete Habit Task.&quot;)">
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

            {!! $habitTasks->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
