@extends('layouts/contentNavbarLayout')

@section('title', 'Global Setting')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

    <div class="card text-bg-theme">

         <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Create New Global Setting</h4>
            <div>
                <a href="{{ route('global_settings.global_setting.index') }}" class="btn btn-primary" title="Show All Global Setting">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
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

            <form method="POST" class="needs-validation" novalidate action="{{ route('global_settings.global_setting.store') }}" accept-charset="UTF-8" id="create_global_setting_form" name="create_global_setting_form"  enctype="multipart/form-data">
            {{ csrf_field() }}
            @include ('global_settings.form', [
                                        'globalSetting' => null,
                                      ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Add">
                </div>

            </form>

        </div>
    </div>

@endsection
