@extends('layouts/contentNavbarLayout')

@section('title', 'Global Setting List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection
@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Global Setting' }}</h4>
        <div>
            <form method="POST" action="{!! route('global_settings.global_setting.destroy', $globalSetting->id) !!}"
                accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('global_settings.global_setting.edit', $globalSetting->id ) }}"
                    class="btn btn-primary" title="Edit Global Setting">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Global Setting"
                    onclick="return confirm(&quot;Click Ok to delete Global Setting.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('global_settings.global_setting.index') }}" class="btn btn-primary"
                    title="Show All Global Setting">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('global_settings.global_setting.create') }}" class="btn btn-secondary"
                    title="Create New Global Setting">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Logo</dt>
            <dd class="col-lg-10 col-xl-9">
                <img src="{{ asset('storage/' . $globalSetting->logo) }}" width="100">
            </dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Favicon</dt>
            <dd class="col-lg-10 col-xl-9">
                <img src="{{ asset('storage/' . $globalSetting->favicon) }}" width="100">
            </dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Site Title</dt>
            <dd class="col-lg-10 col-xl-9">{{ $globalSetting->site_title }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Slogan</dt>
            <dd class="col-lg-10 col-xl-9">{{ $globalSetting->slogan }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Phone</dt>
            <dd class="col-lg-10 col-xl-9">{{ $globalSetting->phone }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Email</dt>
            <dd class="col-lg-10 col-xl-9">{{ $globalSetting->email }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Website</dt>
            <dd class="col-lg-10 col-xl-9">{{ $globalSetting->website }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Address</dt>
            <dd class="col-lg-10 col-xl-9">{{ $globalSetting->address }}</dd>
        </dl>

    </div>
</div>

@endsection