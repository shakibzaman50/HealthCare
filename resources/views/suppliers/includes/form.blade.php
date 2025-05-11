<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" required>
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control">
    @if(isset($user))
    <small>Leave blank to keep the current password.</small>
    @endif
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select name="status" class="form-control" required>
        <option value="1" {{ (old('status', $user->status ?? '') == '1') ? 'selected' : '' }}>Active</option>
        <option value="0" {{ (old('status', $user->status ?? '') == '0') ? 'selected' : '' }}>Inactive</option>
    </select>
</div>
<div class="form-group">
    <label for="previous_due">Previous Due</label>
    <input type="number" name="previous_due" class="form-control"
        value="{{ old('previous_due', $user->account->previous_due ?? '') }}" min="0">
</div>
<button type="submit" class="btn btn-primary">Save</button>