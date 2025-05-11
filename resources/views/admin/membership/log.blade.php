@extends('layouts/layoutMaster')

@section('title', 'Membership plan')

@section('content')
  <div class="container">
    <div class="row">

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Membership log</h3>
          </div>
          <div class="card-body">
            <table id="user-datatable" class="table table-bordered">
              <thead>
              <tr>
                <th>User</th>
                <th>Package name</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
              </thead>
              <!-- Define your table headers here -->
              <tbody>
              @foreach ($logs as $log)
                <tr>
                  <td>{{ $log->customer->name }}</td>
                  <td>{{ $log->package->name }}</td>
                  <td>{{ $log->package->price }}</td>
                  <td><span>Active</span></td>
                </tr>
                @endforeach
              </tbody>
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
          url: '{{ route('users.paiddata') }}',
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
