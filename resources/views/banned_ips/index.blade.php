@extends('layouts/layoutMaster')

@section('title', 'Edit blog')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Banned Ips</h4>
            <div>
                <a href="{{ route('banned_ips.banned_ip.create') }}" class="btn btn-secondary" title="Create New Banned Ip">
                    <span class="fa fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($bannedIps) == 0)
            <div class="card-body text-center">
                <h4>No Banned Ips Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Ip Address</th>
                            <th>Status</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($bannedIps as $bannedIp)
                        <tr>
                            <td class="align-middle">{{ $bannedIp->ip_address }}</td>
                            <td class="align-middle">{{ $bannedIp->status }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('banned_ips.banned_ip.destroy', $bannedIp->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">

                                        <button type="submit" class="btn btn-danger" title="Delete Banned Ip" onclick="return confirm(&quot;Click Ok to delete Banned Ip.&quot;)">
                                            Remove
                                        </button>
                                    </div>

                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            {!! $bannedIps->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
