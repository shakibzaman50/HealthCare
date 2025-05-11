@extends('layouts/layoutMaster')

@section('title', 'Edit blog')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($blog->title) ? $blog->title : 'Blog' }}</h4>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Title</dt>
            <dd class="col-lg-10 col-xl-9">{{ $blog->title }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Category</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($blog->blogCategory)->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Description</dt>
            <dd class="col-lg-10 col-xl-9">{{ $blog->description }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Source</dt>
            <dd class="col-lg-10 col-xl-9">{{ $blog->source }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Blog Seo</dt>
            <dd class="col-lg-10 col-xl-9">{{ ($blog->blog_seo) ? 'Yes' : 'No' }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Meta Tag</dt>
            <dd class="col-lg-10 col-xl-9">{{ $blog->meta_tag }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Meta Description</dt>
            <dd class="col-lg-10 col-xl-9">{{ $blog->meta_description }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Image</dt>
            <dd class="col-lg-10 col-xl-9"><img src="{{ asset('storage/' . $blog->image) }}" /></dd>
        </dl>

    </div>
</div>

@endsection
