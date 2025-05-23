@extends('layouts/layoutMaster')

@section('title', 'Edit Blog')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">{{ !empty($blog->title) ? $blog->title : 'Edit Blog' }}</h4>
                    <div>
                        <a href="{{ route('blogs.index') }}" class="btn btn-primary" title="Show All Blogs">
                            <i class="fa-solid fa-table-list me-1"></i> All Blogs
                        </a>
                        <a href="{{ route('blogs.create') }}" class="btn btn-secondary" title="Create New Blog">
                            <i class="fa-solid fa-plus me-1"></i> New Blog
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" class="needs-validation" novalidate
                        action="{{ route('blogs.update', $blog->id) }}" id="edit_blog_form" name="edit_blog_form"
                        accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="PUT">

                        <div class="row">
                            <div class="col-lg-8">
                                @include ('admin.config.blogs.form', [
                                'blog' => $blog,
                                ])
                            </div>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Publish</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option value="draft" {{ $blog->status === 'draft' ? 'selected' : ''
                                                    }}>Draft</option>
                                                <option value="published" {{ $blog->status === 'published' ? 'selected'
                                                    : '' }}>Published</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Visibility</label>
                                            <select class="form-select" name="visibility">
                                                <option value="public" {{ $blog->visibility === 'public' ? 'selected' :
                                                    '' }}>Public</option>
                                                <option value="private" {{ $blog->visibility === 'private' ? 'selected'
                                                    : '' }}>Private</option>
                                            </select>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-save me-1"></i> Update
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Featured Image</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($blog->thumbnail)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $blog->thumbnail) }}"
                                                alt="Current thumbnail" class="img-fluid rounded mb-2">
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <input class="form-control" type="file" name="thumbnail" id="thumbnail">
                                            <small class="text-muted">Recommended size: 1200x630 pixels</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">SEO Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Meta Title</label>
                                            <input type="text" class="form-control" name="meta_title"
                                                value="{{ old('meta_title', $blog->meta_title) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Meta Description</label>
                                            <textarea class="form-control" name="meta_description"
                                                rows="3">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection