@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Medicine Schedule')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

    <div class="card text-bg-theme">

         <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($medicineSchedule->name) ? $medicineSchedule->name : 'Medicine Schedule' }}</h4>
            <div>
                <a href="{{ route('medicine-schedules.index') }}" class="btn btn-primary" title="Show All Medicine Schedule">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('medicine-schedules.create') }}" class="btn btn-secondary" title="Create New Medicine Schedule">
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

            <form method="POST" class="needs-validation" novalidate action="{{ route('medicine-schedules.update', $medicineSchedule->id) }}" id="edit_medicine_schedule_form" name="edit_medicine_schedule_form" accept-charset="UTF-8" >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('admin.config.medicine_schedules.form', [
                                        'medicineSchedule' => $medicineSchedule,
                                      ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary text-black" type="submit" value="Update">
                </div>
            </form>

        </div>
    </div>

@endsection
