@extends('layouts/layoutMaster')

@section('title', 'Show User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Subscribers</h3>
                </div>
                <div class="card-body">
                    @if ($subscribers->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Joining date</th>
                                    <th>Lifetime package</th>
                                    <th>Monthly date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $subscriber)
                                    <tr>
                                        <td>{{ $subscriber->name }}</td>
                                        <td>{{ $subscriber->email }}</td>
                                        <td>{{ $subscriber->phone }}</td>
                                        <td>{{ $subscriber->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $subscriber->lifetimePackage->name ?? 'No package' }}</td>
                                        <td>{{ $subscriber->monthlyPackage->name ?? 'No package' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No subscribers yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
