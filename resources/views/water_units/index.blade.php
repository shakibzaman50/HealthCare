@extends('layouts/contentNavbarLayout')

@section('title', 'List Water Unit')

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
            <h4 class="m-0">Water Units</h4>
            <div>
                <a href="{{ route('water-units.create') }}" class="btn btn-secondary" title="Create New Water Unit">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($waterUnits) == 0)
            <div class="card-body text-center">
                <h4>No Water Units Available.</h4>
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
                    @foreach($waterUnits as $waterUnit)
                        <tr>
                            <td class="align-middle">{{ $waterUnit->name }}</td>
                            <td class="align-middle">{{ ($waterUnit->is_active) ? 'Yes' : 'No' }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('water-units.destroy', $waterUnit->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('water-units.show', $waterUnit->id ) }}" class="btn btn-info" title="Show Water Unit">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('water-units.edit', $waterUnit->id ) }}" class="btn btn-primary" title="Edit Water Unit">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Water Unit" onclick="return confirm(&quot;Click Ok to delete Water Unit.&quot;)">
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

            {!! $waterUnits->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
