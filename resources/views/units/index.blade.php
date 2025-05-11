@extends('layouts/contentNavbarLayout')

@section('title', 'Permission List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Units Management</h4>
                    @include('units.includes.create')
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Abbreviation</th>
                                    <th>Conversion Rate</th>
                                    <th>Base Unit</th>
                                    <th width="200px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $unit->name }}</td>
                                    <td>{{ $unit->abbreviation }}</td>
                                    <td>{{ $unit->conversion_rate }}</td>
                                    <td>{{ $unit->is_base_unit ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Unit Actions">
                                            @include('units.includes.edit', ['unit' => $unit])
                                            <form action="{{ route('units.destroy', $unit->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger ms-1"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $units->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection