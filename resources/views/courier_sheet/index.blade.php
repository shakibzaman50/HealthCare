@extends('layouts/contentNavbarLayout')

@section('title', 'Order List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>INVOICE</th>
                    <th>Courier</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courier_sheets as $courier)
                <tr>
                    <td>{{ $courier->id }}</td>
                    <td>{{ $courier->invoice }}</td>
                    <td>{{ $courier->company->name }}</td>
                    <td>{{ $courier->creator->name }}</td>
                    <td>
                        @include('courier_sheet.include.sheet_detail')
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection