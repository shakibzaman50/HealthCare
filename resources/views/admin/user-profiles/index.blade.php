@extends('layouts/layoutMaster')

@section('title', 'User Profiles')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Users List</h4>
                <div class="d-flex justify-content-end">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Search by name or email...">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Profiles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            @include('admin.user-profiles._table_rows')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const usersTableBody = document.getElementById('usersTableBody');

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const searchTerm = e.target.value.trim();

        searchTimeout = setTimeout(() => {
            if (searchTerm.length >= 2) {
                fetch(`/user-profiles/search?q=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        usersTableBody.innerHTML = data.html;
                    })
                    .catch(error => console.error('Error:', error));
            } else if (searchTerm.length === 0) {
                // Reset to original table content
                fetch('/user-profiles')
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTableBody = doc.getElementById('usersTableBody');
                        usersTableBody.innerHTML = newTableBody.innerHTML;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }, 300); // 300ms debounce
    });
</script>
@endsection