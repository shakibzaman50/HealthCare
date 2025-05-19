@extends('layouts/contentNavbarLayout')

@section('title', 'List Medicine Unit')

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
            <h4 class="m-0">Medicine Units</h4>
            <div>
                <a href="{{ route('medicine-units.create') }}" class="btn btn-secondary" title="Create New Medicine Unit">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($medicineUnits) == 0)
            <div class="card-body text-center">
                <h4>No Medicine Units Available.</h4>
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
                    @foreach($medicineUnits as $medicineUnit)
                        <tr>
                            <td class="align-middle">{{ $medicineUnit->name }}</td>
                            <td class="align-middle">{{ ($medicineUnit->is_active) ? 'Yes' : 'No' }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('medicine-units.destroy', $medicineUnit->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('medicine-units.show', $medicineUnit->id ) }}" class="btn btn-info" title="Show Medicine Unit">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('medicine-units.edit', $medicineUnit->id ) }}" class="btn btn-primary" title="Edit Medicine Unit">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Medicine Unit" onclick="return confirm(&quot;Click Ok to delete Medicine Unit.&quot;)">
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
            {!! $medicineUnits->links('pagination') !!}
        </div>
        @endif
    </div>
@endsection
