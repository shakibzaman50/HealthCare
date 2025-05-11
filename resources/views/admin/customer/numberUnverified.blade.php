@extends('layouts/layoutMaster')

@section('title', 'Show users')

@section('content')
    <div class="container">
        <div class="row">
        
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage members</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="float-left">Find members</h3>
                                <a class="btn btn-info float-right" href="{{ route('manage-member-customers.create') }}">Add member</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="country" name="country" class="form-control">
                                        <option value="">Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="city" name="city" class="form-control" placeholder="City" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="zip" name="zip" class="form-control" placeholder="Zip" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="ip" name="ip" class="form-control" placeholder="ip address" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button id="search" type="button" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Customer List</h3>
                    </div>
                    <div class="card-body">
                        <table id="user-datatable" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Ip</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <!-- Define your table headers here -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this customer?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function () {
            var table = $('#user-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('users.numberUnverifiedData') }}',
                    data: function (d) {
                        d.name = $('#name').val();
                        d.email = $('#email').val();
                        d.ip_address = $('#ip_address').val();
                        d.country = $('#country').val();
                        d.city = $('#city').val();
                        d.zip = $('#zip').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    { data: null, name: 'serial_number', orderable: false, searchable: false, render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'ip_address', name: 'ip_address' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                        className: 'btn btn-danger'
                    }
                ]
            });

            $('#search').on('click', function() {
                console.log('Working');
                table.draw();
            });
        });
    </script>
    <script>
        function confirmDelete(customerId) {
            var form = document.getElementById('deleteForm');
            form.action = '/customers/' + customerId;
            $('#deleteModal').modal('show');
        }
    </script>

@stop
