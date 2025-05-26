@foreach($users as $user)
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->phone }}</td>
    <td>
        @if($user->status == 1)
        <span class="badge bg-success">Active</span>
        @else
        <span class="badge bg-danger">Inactive</span>
        @endif
    </td>
    <td>
        <span class="badge bg-primary rounded-pill">
            {{ $user->profiles->count() }} Profile(s)
        </span>
    </td>
    <td>
        <a href="{{ route('user-profiles.show', $user) }}" class="btn btn-primary btn-sm">
            View Profiles
        </a>
    </td>
</tr>
@endforeach