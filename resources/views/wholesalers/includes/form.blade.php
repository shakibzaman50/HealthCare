<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
        value="{{ old('phone', $user->phone ?? '') }}" required>
    @error('phone')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
    @if(isset($user))
    <small>Leave blank to keep the current password.</small>
    @endif
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
        <option value="1" {{ (old('status', $user->status ?? '') == '1') ? 'selected' : '' }}>Active</option>
        <option value="0" {{ (old('status', $user->status ?? '') == '0') ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="previous_due">Previous Due</label>
    <input type="number" name="previous_due" class="form-control @error('previous_due') is-invalid @enderror"
        value="{{ old('previous_due', $user->account->previous_due ?? '') }}" min="0">
    @error('previous_due')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<button type="submit" class="btn btn-primary">Save</button>