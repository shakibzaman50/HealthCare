@extends('layouts/contentNavbarLayout')

@section('title', 'Global Setting')

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

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">Global Settings</h4>
        <div>
            <a href="{{ route('global_settings.global_setting.create') }}" class="btn btn-secondary"
                title="Create New Global Setting">
                Add
            </a>
        </div>
    </div>

    @if(count($globalSettings) == 0)
    <div class="card-body text-center">
        <h4>No Global Settings Available.</h4>
    </div>
    @else
    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Favicon</th>
                        <th>Site Title</th>
                        <th>Slogan</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($globalSettings as $globalSetting)
                    <tr>
                        <td class="align-middle">{{ $globalSetting->logo }}</td>
                        <td class="align-middle">{{ $globalSetting->favicon }}</td>
                        <td class="align-middle">{{ $globalSetting->site_title }}</td>
                        <td class="align-middle">{{ $globalSetting->slogan }}</td>
                        <td class="align-middle">{{ $globalSetting->phone }}</td>
                        <td class="align-middle">{{ $globalSetting->email }}</td>
                        <td class="align-middle">{{ $globalSetting->website }}</td>
                        <td class="align-middle">{{ $globalSetting->address }}</td>
                        <td class="text-end">
                            <form method="POST"
                                action="{!! route('global_settings.global_setting.destroy', $globalSetting->id) !!}"
                                accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('global_settings.global_setting.show', $globalSetting->id ) }}"
                                        class="btn btn-info" title="Show Global Setting">
                                        Show
                                    </a>
                                    <a href="{{ route('global_settings.global_setting.edit', $globalSetting->id ) }}"
                                        class="btn btn-primary" title="Edit Global Setting">
                                        Edit
                                    </a>

                                    <button type="submit" class="btn btn-danger" title="Delete Global Setting"
                                        onclick="return confirm(&quot;Click Ok to delete Global Setting.&quot;)">
                                        Delete
                                    </button>
                                </div>

                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {!! $globalSettings->links('pagination') !!}
    </div>

    @endif

</div>
@endsection