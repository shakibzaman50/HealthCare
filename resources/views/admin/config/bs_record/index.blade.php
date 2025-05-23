@extends('layouts/contentNavbarLayout')

@section('title', 'List Blood Sugar Records')

@section('vendor-script')
    @vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(Session::has('success_message'))
                            <div class="alert alert-success">
                                <span class="glyphicon glyphicon-ok"></span>
                                {!! session('success_message') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Schedule</th>
                                        <th>Value</th>
                                        <th>Unit</th>
                                        <th>Measurement At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bsRecords as $bsRecord)
                                        <tr>
                                            <td>{{ $bsRecord->id }}</td>
                                            <td>{{ $bsRecord->profile->name ?? 'N/A' }}</td>
                                            <td>{{ $bsRecord->sugarSchedule->name ?? 'N/A' }}</td>
                                            <td>{{ $bsRecord->value }}</td>
                                            <td>{{ $bsRecord->sugarUnit->name ?? 'N/A' }}</td>
                                            <td>{{ $bsRecord->measurement_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <span
                                                    class="badge text-capitalize {{ $bsRecord->status == 'Normal' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                                    {{ $bsRecord->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('bs-records.destroy', $bsRecord->id) }}"
                                                    accept-charset="UTF-8">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group btn-group-sm">

                                                        <button type="submit" class="btn btn-danger" title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-wrapper">
                            {{ $bsRecords->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection