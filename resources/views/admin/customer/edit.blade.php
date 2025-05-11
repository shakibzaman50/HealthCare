@extends('layouts/layoutMaster')

@section('title', 'Show User')


@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit user</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ $customer->name }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="name">Email address:</label>
                            <input type="email" name="email" class="form-control" value="{{ $customer->email }}"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country:</label>
                            <select name="country_id" class="form-control">
                                <option value="">Select a country</option>
                                @foreach($countries as $country)
                                    <option @if($customer->country_id == $country->id) selected @endif value="{{$country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" name="city" class="form-control" value="{{ $customer->city }}"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="zip">Zip code:</label>
                            <input type="text" name="zip" class="form-control" value="{{ $customer->zip }}"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" name="address" class="form-control" value="{{ $customer->address }}"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="password">New password:</label>
                            <input type="password" name="password" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="name">Status:</label>
                            <select name="status" class="form-control">
                                <option value="">Select status</option>
                                <option @if($customer->status == 'active') selected @endif value="active">Active</option>
                                <option @if($customer->status == 'inactive') selected @endif value="inactive">Inactive</option>
                                <option @if($customer->status == 'banned') selected @endif value="banned">Banned</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email_verified_at">Email verified:</label>
                            <input type="checkbox" name="email_verified_at" class="form-control" @if(!is_null($customer->email_verified_at)) checked @endif value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="document_verified">Document verified:</label>
                            <input type="checkbox" name="document_verified" class="form-control" value="1">
                        </div>
                        <div class="form-group">
                            <label for="2fa _auth">2FA Auth:</label>
                            <input type="checkbox" name="2fa _auth" class="form-control" value="1">
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
