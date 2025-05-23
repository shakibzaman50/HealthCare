@extends('layouts/layoutMaster')

@section('title', $blog->title)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">{{ $blog->title }}</h4>
                    <div>
                        <a href="{{ route('blogs.index') }}" class="btn btn-primary" title="Show All Blogs">
                            <i class="fa-solid fa-table-list me-1"></i> All Blogs
                        </a>
                        <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-secondary" title="Edit Blog">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Blog Header -->
                            <div class="blog-header mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <span
                                        class="badge bg-label-{{ $blog->status === 'published' ? 'success' : 'warning' }} me-2">
                                        {{ ucfirst($blog->status) }}
                                    </span>
                                    <span
                                        class="badge bg-label-{{ $blog->visibility === 'public' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($blog->visibility) }}
                                    </span>
                                </div>

                                @if($blog->thumbnail)
                                <div class="blog-thumbnail mb-4">
                                    <img src="{{ $blog->thumbnail_url }}" alt="{{ $blog->title }}"
                                        class="img-fluid rounded w-100" style="max-height: 400px; object-fit: cover;">
                                </div>
                                @endif
                            </div>

                            <!-- Blog Content -->
                            <div class="blog-content">
                                <div class="content-wrapper">
                                    {!! $blog->content !!}
                                </div>
                            </div>

                            <!-- Blog Tags -->
                            @if($blog->tags)
                            <div class="blog-tags mt-4">
                                <h5 class="mb-3">Tags</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(explode(', ', $blog->tags) as $tag)
                                    <span class="badge bg-label-info">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-lg-4">
                            <!-- Blog Meta Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Blog Information</h5>
                                </div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Created</dt>
                                        <dd class="col-sm-8">{{ $blog->created_at->format('M d, Y') }}</dd>

                                        <dt class="col-sm-4">Updated</dt>
                                        <dd class="col-sm-8">{{ $blog->updated_at->format('M d, Y') }}</dd>

                                        @if($blog->meta_title)
                                        <dt class="col-sm-4">Meta Title</dt>
                                        <dd class="col-sm-8">{{ $blog->meta_title }}</dd>
                                        @endif

                                        @if($blog->meta_description)
                                        <dt class="col-sm-4">Meta Description</dt>
                                        <dd class="col-sm-8">{{ $blog->meta_description }}</dd>
                                        @endif
                                    </dl>
                                </div>
                            </div>

                            <!-- Preview Card -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Preview</h5>
                                </div>
                                <div class="card-body">
                                    {{-- <a href="{{ route('blogs.preview', $blog->id) }}" class="btn btn-primary w-100"
                                        target="_blank">
                                        <i class="fa-solid fa-eye me-1"></i> View Public Page
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .blog-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }

    .blog-content h1,
    .blog-content h2,
    .blog-content h3,
    .blog-content h4,
    .blog-content h5,
    .blog-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .blog-content p {
        margin-bottom: 1.5rem;
    }

    .blog-content blockquote {
        border-left: 4px solid #696cff;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
    }

    .blog-content ul,
    .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }

    .blog-content table {
        width: 100%;
        margin-bottom: 1.5rem;
        border-collapse: collapse;
    }

    .blog-content table th,
    .blog-content table td {
        padding: 0.75rem;
        border: 1px solid #ddd;
    }

    .blog-content table th {
        background-color: #f8f9fa;
    }

    .content-wrapper {
        background-color: #fff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .blog-header {
        position: relative;
    }

    .blog-thumbnail {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .badge {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
</style>
@endsection