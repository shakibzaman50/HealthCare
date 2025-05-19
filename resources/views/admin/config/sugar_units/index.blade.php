@extends('layouts/contentNavbarLayout')

@section('title', 'List Blood Sugar Unit')

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
            <h4 class="m-0">Sugar Units</h4>
            <div>
                <a href="{{ route('sugar-units.create') }}" class="btn btn-secondary" title="Create New Sugar Unit">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($sugarUnits) == 0)
            <div class="card-body text-center">
                <h4>No Sugar Units Available.</h4>
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
                    @foreach($sugarUnits as $sugarUnit)
                        <tr>
                            <td class="align-middle">{{ $sugarUnit->name }}</td>
                            <td class="align-middle">{{ ($sugarUnit->is_active) ? 'Yes' : 'No' }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('sugar-units.destroy', $sugarUnit->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('sugar-units.show', $sugarUnit->id ) }}" class="btn btn-info" title="Show Sugar Unit">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('sugar-units.edit', $sugarUnit->id ) }}" class="btn btn-primary" title="Edit Sugar Unit">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>
                                        <button type="submit" class="btn btn-danger" title="Delete Sugar Unit" onclick="return confirm(&quot;Click Ok to delete Sugar Unit.&quot;)">
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
            {!! $sugarUnits->links('pagination') !!}
        </div>
        @endif
    </div>
@endsection
