@extends('layouts/layoutMaster')

@section('title', 'Edit blog')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Banned Ip' }}</h4>
        <div>
            <form method="POST" action="{!! route('banned_ips.banned_ip.destroy', $bannedIp->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('banned_ips.banned_ip.edit', $bannedIp->id ) }}" class="btn btn-primary" title="Edit Banned Ip">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Banned Ip" onclick="return confirm(&quot;Click Ok to delete Banned Ip.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('banned_ips.banned_ip.index') }}" class="btn btn-primary" title="Show All Banned Ip">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('banned_ips.banned_ip.create') }}" class="btn btn-secondary" title="Create New Banned Ip">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Ip Address</dt>
            <dd class="col-lg-10 col-xl-9">{{ $bannedIp->ip_address }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Status</dt>
            <dd class="col-lg-10 col-xl-9">{{ $bannedIp->status }}</dd>

        </dl>

    </div>
</div>

@endsection
