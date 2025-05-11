@extends('layouts/layoutMaster')

@section('title', 'Show User')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Show Permission</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $permission->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection