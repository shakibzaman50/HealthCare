@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Blood Presure Unit')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

    <div class="card text-bg-theme">

         <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($bpUnit->name) ? $bpUnit->name : 'Bp Unit' }}</h4>
            <div>
                <a href="{{ route('bp-units.index') }}" class="btn btn-primary" title="Show All Bp Unit">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('bp-units.create') }}" class="btn btn-secondary" title="Create New Bp Unit">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" class="needs-validation" novalidate action="{{ route('bp-units.update', $bpUnit->id) }}" id="edit_bp_unit_form" name="edit_bp_unit_form" accept-charset="UTF-8" >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('admin.config.bp_units.form', [
                                        'bpUnit' => $bpUnit,
                                      ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary text-black" type="submit" value="Update">
                </div>
            </form>

        </div>
    </div>

@endsection
