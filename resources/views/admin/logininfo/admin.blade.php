@extends('layouts/layoutMaster')

@section('title', 'Show users')

@section('content')
    <div class="container">
        <div class="row">
        
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
                                <th>User Name</th>
                                <th>Ip address</th>
                                <th>User type</th>
                                <th>Browser info</th>
                                <th>Created time</th>
                            </tr>
                            </thead>
                            <!-- Define your table headers here -->
                        </table>
                    </div>
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
                    url: '{{ route('admin.logininfo.data') }}',
                },
                columns: [
                    { data: null, name: 'serial_number', orderable: false, searchable: false, render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                    { data: 'user.name', name: 'user.name' },
                    { data: 'ip_address', name: 'ip_address' },
                    { data: 'user_type', name: 'user_type' },
                    { data: 'browser', name: 'browser' },
                    { data: 'created_at', name: 'created_at', orderable: false, searchable: false }
                ],

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
