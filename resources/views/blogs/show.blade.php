@extends('layouts/layoutMaster')

@section('title', 'Blog')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($blog->title) ? $blog->title : 'Blog' }}</h4>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Title:</dt>
            <dd class="col-lg-10 col-xl-9">{{ $blog->title }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Tags:</dt>
            <dd class="col-lg-10 col-xl-9">{{ $blog->tags }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Thumbnail:</dt>
            <dd class="col-lg-10 col-xl-9">
                <img src="{{ asset($blog->thumbnail) }}" alt="thumbnail"/>
            </dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Content:</dt>
            <dd class="col-lg-10 col-xl-9">{!! $blog->content !!}</dd>
        </dl>

    </div>
</div>

@endsection
