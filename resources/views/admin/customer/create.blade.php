@extends('layouts/layoutMaster')

@section('title', 'Show User')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Create User</h3>
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
            <form action="{{ route('manage-member-customers.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email address:</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="country" class="form-label">Country:</label>
                <select name="country_id" class="form-select">
                  <option value="">Select a country</option>
                  @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <label for="city" class="form-label">City:</label>
                <input type="text" name="city" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="zip" class="form-label">Zip code:</label>
                <input type="text" name="zip" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" name="address" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" class="form-control">
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select name="status" class="form-select">
                  <option value="">Select status</option>
                  <option value="1">Active</option>
                  <option value="2">Inactive</option>
                  <option value="3">Banned</option>
                </select>
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" name="email_verified_at" class="form-check-input" id="email_verified_at" value="{{ date('Y-m-d') }}">
                <label for="email_verified_at" class="form-check-label">Email verified</label>
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" name="document_verified" class="form-check-input" id="document_verified" value="1">
                <label for="document_verified" class="form-check-label">Document verified</label>
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" name="2fa_auth" class="form-check-input" id="2fa_auth" value="1">
                <label for="2fa_auth" class="form-check-label">2FA Auth</label>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Profile picture:</label>
                <input class="form-control" type="file" name="image" id="image">
              </div>
              <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
