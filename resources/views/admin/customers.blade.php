@extends('layouts/layoutMaster')

@section('title', 'Customer List')

@section('content_header')
<h1>Customer List</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="row m-4">
                <div class="col-md-4">
                    <form method="GET" action="{{ route('admin.customer.list') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <input class="form-control" type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.customer.list') }}" class="btn btn-danger">Clear X</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <form method="GET" action="{{ route('customers.exportCSV') }}">
                        <button type="submit" class="btn btn-success">Export to CSV</button>
                    </form>
                </div>
            </div>

            <table class="table table-bordered" id="datatable">
                <thead>
                    <tr>
                        <th>Contacted</th>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Order ID</th>
                        <th>ASIN Purchased</th>
                        <th>2nd Gift</th>
                        <th>Date</th>
                        <th>Rating</th>
                        <th>Last Step</th>
                        <th>Funnel Name</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="contacted" name="contacted" {{ $customer->contacted == 1 ?
                            'checked' : '' }}
                            data-id="{{ $customer->id }}"
                            data-toggle="toggle"
                            data-on="Ready"
                            data-off="Not Ready"
                            data-onstyle="success"
                            data-offstyle="danger">
                        </td>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->order->order_no ?? 'N/A' }}</td>
                        <td>{{ $customer->product_asin ?? 'N/A'}}</td>
                        <td>{{ $customer->order ? ($customer->order->second_order == 0 ? 'Not
                            Requested':($customer->order->order_type == 1 ? 'Requested Oximeter':'Requested Thermometer'
                            )) : 'N/A' }}</td>
                        <td>{{ $customer->created_at }}</td>
                        @php
                        $rating = $customer->review->recommendation ?? 0;
                        $rating = max(0, min($rating, 5));
                        @endphp

                        <td>
                            <div>
                                @for ($i = 1; $i <= 5; $i++) <i class="fa{{ $i <= $rating ? 's' : 'r' }} fa-star"></i>
                                    @endfor
                            </div>
                        </td>
                        <td>{{ $customer->funnel_step ?? 'N/A' }}</td>
                        <td>{{ $customer->funnel_name ?? 'N/A' }}</td>
                        <td>{{ $customer->note ?? 'N/A' }}</td>
                        <td>
                            @if($customer->review)
                            <a class="btn btn-success text-light" data-toggle="modal" id="mediumButton"
                                data-target="#mediumModal"
                                data-attr="{{ route('admin.customer.review',$customer->review->review) }}"
                                title="View Review"> View Review
                            </a>
                            @endif
                            <a class="btn btn-primary text-light" data-toggle="modal" id="mediumButton"
                                data-target="#mediumModal" data-attr="{{ route('admin.customer.note',$customer) }}"
                                title="Update Note"> Update Note
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <div>
                    Showing {{ $customers->count() }} of {{ $customers->total() }} records
                </div>
                <div>
                    {{ $customers->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body" id="mediumBody">
                <div>
                    <!-- the result to be displayed apply here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.5/dist/sweetalert2.min.css">
<link rel="stylesheet" href="{{ asset('css/admin.css') }} " type="text/css">
@stop
@section('js')
{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.5/dist/sweetalert2.min.js"></script>
<script>
    $(document).on('click', '#mediumButton', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href,
            beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#mediumModal').modal("show");
                $('#mediumBody').html(result).show();
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            },
            timeout: 8000
        })
    });
        $(document).ready(function() {

            $(document).on('change', 'input.contacted', function() {
                var customerid = $(this).data('id');
                var isChecked = $(this).prop('checked');
                $.ajax({
                        url: '{{ url("update/customer/contact") }}',
                        method: 'POST',
                        data: { _token: "{{ @csrf_token() }}", contact: (isChecked?1:0), customerid: customerid },
                        success: function(data) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Customer contact status has been updated.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            console.log(data);
                        },
                        error: function(xhr, status, error) {
                    // Handle errors if needed
                    console.error('Error:', error);
                }
                    });
            });
        })
</script>
@stop