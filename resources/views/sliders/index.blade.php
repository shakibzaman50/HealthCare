@extends('layouts/contentNavbarLayout')

@section('title', 'Slider List')

@section('content')

@if(Session::has('success_message'))
<div class="alert alert-success alert-dismissible" role="alert">
    {!! session('success_message') !!}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">Sliders</h4>
        <div>
            <a href="{{ route('sliders.slider.create') }}" class="btn btn-secondary" title="Create New Slider">
                <span class="fa-solid fa-plus" aria-hidden="true"></span>
            </a>
        </div>
    </div>

    @if(count($sliders) == 0)
    <div class="card-body text-center">
        <h4>No Sliders Available.</h4>
    </div>
    @else
    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Text</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th>Image</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slider)
                    <tr>
                        <td class="align-middle">{{ $slider->id }}</td>
                        <td class="align-middle">{{ $slider->name }}</td>
                        <td class="align-middle">{{ $slider->text }}</td>
                        <td class="align-middle">{{ $slider->link }}</td>
                        <td class="align-middle"><span
                                class="badge {{ $slider->status==1?'bg-success':'bg-danger' }}">{{
                                $slider->status==1?'Active':'Inactive' }}</span>
                        </td>
                        <td class="align-middle">
                            <img src="{{ asset('storage/' . $slider->image) }}" width="100">
                        </td>

                        <td class="text-end">

                            <form method="POST" action="{!! route('sliders.slider.destroy', $slider->id) !!}"
                                accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('sliders.slider.show', $slider->id ) }}" class="btn btn-info"
                                        title="Show Slider">
                                        <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                    </a>
                                    <a href="{{ route('sliders.slider.edit', $slider->id ) }}" class="btn btn-primary"
                                        title="Edit Slider">
                                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                    </a>

                                    <button type="submit" class="btn btn-danger" title="Delete Slider"
                                        onclick="return confirm(&quot;Click Ok to delete Slider.&quot;)">
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

        {!! $sliders->links('pagination') !!}
    </div>

    @endif

</div>
@endsection