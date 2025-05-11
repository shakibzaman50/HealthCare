@extends('layouts/layoutMaster')

@section('title', 'With balance users')
@section('page-style')
  @vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  ]);
  <style>
    /* Ensure the container is displayed as a flexbox */
    .lf-wrapper {
      display: flex;
      justify-content: space-between; /* Distribute space between items */
      align-items: center; /* Align items vertically */
    }

    /* Optional: Style length changing input */
    .lf-wrapper .dataTables_length {
      margin-right: auto; /* Push the length changing input to the left */
    }

    /* Optional: Style filtering input */
    .lf-wrapper .dataTables_filter {
      margin-left: auto; /* Push the filtering input to the right */
    }

    /* Additional styling if needed */
    .dt-buttons button{
      margin-right: 5px;
    }


  </style>
@endsection
@section('content')
  <div class="container">
    <div class="row">

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">With balance users</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h3 class="mb-0">Find members</h3>
                  <a class="btn btn-secondary create-new btn-primary waves-effect waves-light" href="{{ route('manage-member-customers.create') }}">Add member</a>
                </div>
              </div>
            </div>
            <div class="mt-4">
              <div class="row">
                <!-- Name Input -->
                <div class="col-md-4 mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" id="name" name="name" class="form-control" placeholder="Name" />
                </div>

                <!-- Email Input -->
                <div class="col-md-4 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" id="email" name="email" class="form-control" placeholder="Email" />
                </div>

                <!-- Country Select -->
                <div class="col-md-4 mb-3">
                  <label for="country" class="form-label">Country</label>
                  <select id="country" name="country" class="form-select">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                      <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- City Input -->
                <div class="col-md-4 mb-3">
                  <label for="city" class="form-label">City</label>
                  <input type="text" id="city" name="city" class="form-control" placeholder="City" />
                </div>

                <!-- Zip Input -->
                <div class="col-md-4 mb-3">
                  <label for="zip" class="form-label">Zip</label>
                  <input type="text" id="zip" name="zip" class="form-control" placeholder="Zip" />
                </div>

                <!-- IP Address Input -->
                <div class="col-md-4 mb-3">
                  <label for="ip" class="form-label">IP Address</label>
                  <input type="text" id="ip" name="ip" class="form-control" placeholder="IP Address" />
                </div>

                <!-- Search Button -->
                <div class="col-md-4 mb-3">
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
                <th>A Active</th>
                <th>M Active</th>
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
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
       aria-hidden="true">
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

@section('vendor-script')

  @vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  ])
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(function () {
      var table = $('#user-datatable').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        searching: true,
        ordering:  true,
        ajax: {
          url: '{{ route('users.withBalanceData') }}',
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
          { data: 'lifetime_package', name: 'lifetime_package' },
          { data: 'monthly_package_status', name: 'monthly_package_status' },
          { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        dom: 'B<"top"<"lf-wrapper"lf>>rt<"bottom"ip><"clear">',
        lengthMenu: [ [10, 25, 50, 100,-1], [10, 25, 50, 100,'all']], // Page length options
        pageLength: 10, // Default page length
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
        ],
        // Default page length
      });

      $('#search').on('click', function() {
        console.log('Working');
        table.draw();
      });
    });


    function confirmDelete(customerId) {
      var form = document.getElementById('deleteForm');
      form.action = '/customers/' + customerId;
      $('#deleteModal').modal('show');
    }
  </script>
@stop
