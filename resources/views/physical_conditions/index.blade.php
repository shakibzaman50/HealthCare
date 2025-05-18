@extends('layouts/contentNavbarLayout')

@section('title', 'List Physical Condition Unit')

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
            <h4 class="m-0">Physical Conditions</h4>
            <div>
                <a href="{{ route('physical-conditions.physical-condition.create') }}" class="btn btn-secondary" title="Create New Physical Condition">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>
        
        @if(count($physicalConditions) == 0)
            <div class="card-body text-center">
                <h4>No Physical Conditions Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Is Active</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($physicalConditions as $physicalCondition)
                        <tr>
                            <td class="align-middle">{{ $physicalCondition->name }}</td>
                            <td class="align-middle">{{ ($physicalCondition->is_active) ? 'Yes' : 'No' }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('physical-conditions.physical-condition.destroy', $physicalCondition->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('physical-conditions.physical-condition.show', $physicalCondition->id ) }}" class="btn btn-info" title="Show Physical Condition">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('physical-conditions.physical-condition.edit', $physicalCondition->id ) }}" class="btn btn-primary" title="Edit Physical Condition">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Physical Condition" onclick="return confirm(&quot;Click Ok to delete Physical Condition.&quot;)">
                                            <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            {!! $physicalConditions->links('pagination') !!}
        </div>
        
        @endif
    
    </div>
@endsection