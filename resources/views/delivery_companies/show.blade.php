@extends('layouts/contentNavbarLayout')

@section('title', 'Status List')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($deliveryCompany->name) ? $deliveryCompany->name : 'Delivery Company' }}</h4>
        <div>
            <form method="POST"
                action="{!! route('delivery_companies.delivery_company.destroy', $deliveryCompany->id) !!}"
                accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('delivery_companies.delivery_company.edit', $deliveryCompany->id ) }}"
                    class="btn btn-primary" title="Edit Delivery Company">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Delivery Company"
                    onclick="return confirm(&quot;Click Ok to delete Delivery Company.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('delivery_companies.delivery_company.index') }}" class="btn btn-primary"
                    title="Show All Delivery Company">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('delivery_companies.delivery_company.create') }}" class="btn btn-secondary"
                    title="Create New Delivery Company">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $deliveryCompany->name }}</dd>

        </dl>

    </div>
</div>

@endsection