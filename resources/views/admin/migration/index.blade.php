@extends('layouts/layoutMaster')

@section('title', 'Migrations')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="card-title">Export database</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('database.export') }}" class="btn btn-dark">Export</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Import</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('import.database') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label" for="sql_file">Upload SQL File:</label>
                                <input class="form-control" type="file" name="sql_file" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Import</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
