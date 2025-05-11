@extends('layouts/layoutMaster')

@section('title', 'Withdraw requests')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Withdraw requests</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            @can('admin-menu')
                            <th width="280px">Action</th>
                            @endcan
                        </tr>
                        @foreach ($withdraws as $withdraw)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $withdraw->customer->name }}</td>
                            <td>{{ $withdraw->amount }}</td>
                            <td>{{ $withdraw->created_at->format('d/m/Y') }}</td>
                            <td>{{ $withdraw->status }}</td>
                            @can('admin-menu')
                            @if($withdraw->status == 'pending')
                            <td>
                                <form action="{{ route('change-withdraw-status') }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="withdraw_id" value="{{ $withdraw->id }}" />
                                    <input type="hidden" name="status" value="approved" />
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                                <form action="{{ route('change-withdraw-status') }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="withdraw_id" value="{{ $withdraw->id }}" />
                                    <input type="hidden" name="status" value="rejected" />
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            </td>
                            @endif
                            @endcan
                        </tr>
                        @endforeach
                    </table>
                    <div>
                        {{ $withdraws->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection