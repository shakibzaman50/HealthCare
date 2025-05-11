@extends('layouts/contentNavbarLayout')

@section('title', 'Global Setting List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection
@section('content')

    <div class="card text-bg-theme">
  
         <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($title) ? $title : 'Global Setting' }}</h4>
            <div>
                <a href="{{ route('global_settings.global_setting.index') }}" class="btn btn-primary" title="Show All Global Setting">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('global_settings.global_setting.create') }}" class="btn btn-secondary" title="Create New Global Setting">
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

            <form method="POST" class="needs-validation" novalidate action="{{ route('global_settings.global_setting.update', $globalSetting->id) }}" id="edit_global_setting_form" name="edit_global_setting_form" accept-charset="UTF-8"  enctype="multipart/form-data">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('global_settings.form', [
                                        'globalSetting' => $globalSetting,
                                      ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Update">
                </div>
            </form>

        </div>
    </div>

@endsection