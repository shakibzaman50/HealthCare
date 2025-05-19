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
            <form method="POST" action="{!! route('global_settings.destroy', $globalSetting->id) !!}"
                accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('global_settings.edit', $globalSetting->id ) }}" class="btn btn-primary"
                    title="Edit Global Setting">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Global Setting"
                    onclick="return confirm(&quot;Click Ok to delete Global Setting.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('global_settings.index') }}" class="btn btn-primary" title="Show All Global Setting">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('global_settings.create') }}" class="btn btn-secondary"
                    title="Create New Global Setting">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <tbody>
                    <tr>
                        <th class="text-end" style="width: 25%;">Logo</th>
                        <td>
                            <img src="{{ asset('storage/' . $globalSetting->logo) }}" alt="Logo" class="img-thumbnail"
                                width="100">
                        </td>
                    </tr>
                    <tr>
                        <th class="text-end">Favicon</th>
                        <td>
                            <img src="{{ asset('storage/' . $globalSetting->favicon) }}" alt="Favicon"
                                class="img-thumbnail" width="64">
                        </td>
                    </tr>
                    <tr>
                        <th class="text-end">Site Title</th>
                        <td>{{ $globalSetting->site_title }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Slogan</th>
                        <td class="text-muted">{{ $globalSetting->slogan }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Phone</th>
                        <td>{{ $globalSetting->phone }}</td>
                    </tr>
                    <tr>
                        <th class="text-end">Email</th>
                        <td><a href="mailto:{{ $globalSetting->email }}">{{ $globalSetting->email }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-end">Website</th>
                        <td><a href="{{ $globalSetting->website }}" target="_blank">{{ $globalSetting->website }}</a>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-end">Address</th>
                        <td>{{ $globalSetting->address }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



</div>

@endsection