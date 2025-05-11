@extends('layouts/contentNavbarLayout')

@section('title', 'Slider Show')

@section('content')

<div class="card text-bg-theme">

    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($slider->name) ? $slider->name : 'Slider' }}</h4>
        <div>
            <form method="POST" action="{!! route('sliders.slider.destroy', $slider->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('sliders.slider.edit', $slider->id ) }}" class="btn btn-primary" title="Edit Slider">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Slider"
                    onclick="return confirm(&quot;Click Ok to delete Slider.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('sliders.slider.index') }}" class="btn btn-primary" title="Show All Slider">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('sliders.slider.create') }}" class="btn btn-secondary" title="Create New Slider">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $slider->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Text</dt>
            <dd class="col-lg-10 col-xl-9">{{ $slider->text }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Image</dt>
            <dd class="col-lg-10 col-xl-9">{{ asset('storage/' . $slider->image) }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Link</dt>
            <dd class="col-lg-10 col-xl-9">{{ $slider->link }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Status</dt>
            <dd class="col-lg-10 col-xl-9">{{ $slider->status }}</dd>

        </dl>

    </div>
</div>

@endsection