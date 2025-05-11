@extends('layouts/contentNavbarLayout')

@section('title', 'Status List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection
@section('content')

@if(Session::has('success_message'))
<div class="alert alert-success alert-dismissible" role="alert">
    {!! session('success_message') !!}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">Delivery Companies</h4>
        <div>
            <a href="{{ route('delivery_companies.delivery_company.create') }}" class="btn btn-secondary"
                title="Create New Delivery Company">
                Add
            </a>
        </div>
    </div>

    @if(count($deliveryCompanies) == 0)
    <div class="card-body text-center">
        <h4>No Delivery Companies Available.</h4>
    </div>
    @else
    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Name</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryCompanies as $deliveryCompany)
                    <tr>
                        <td class="align-middle">{{ $deliveryCompany->name }}</td>

                        <td class="text-end">

                            <form method="POST"
                                action="{!! route('delivery_companies.delivery_company.destroy', $deliveryCompany->id) !!}"
                                accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('delivery_companies.delivery_company.show', $deliveryCompany->id ) }}"
                                        class="btn btn-info" title="Show Delivery Company">
                                        Show
                                    </a>
                                    <a href="{{ route('delivery_companies.delivery_company.edit', $deliveryCompany->id ) }}"
                                        class="btn btn-primary" title="Edit Delivery Company">
                                        Edit
                                    </a>

                                    <button type="submit" class="btn btn-danger" title="Delete Delivery Company"
                                        onclick="return confirm(&quot;Click Ok to delete Delivery Company.&quot;)">
                                        Delete
                                    </button>
                                </div>

                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {!! $deliveryCompanies->links('pagination') !!}
    </div>

    @endif

</div>
@endsection