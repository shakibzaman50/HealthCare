@extends('layouts/layoutMaster')

@section('title', 'Edit blog')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($blogCategory->name) ? $blogCategory->name : 'Blog Category' }}</h4>
        <div>
            <form method="POST" action="{!! route('blog_categories.blog_category.destroy', $blogCategory->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('blog_categories.blog_category.edit', $blogCategory->id ) }}" class="btn btn-primary" title="Edit Blog Category">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Blog Category" onclick="return confirm(&quot;Click Ok to delete Blog Category.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('blog_categories.blog_category.index') }}" class="btn btn-primary" title="Show All Blog Category">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('blog_categories.blog_category.create') }}" class="btn btn-secondary" title="Create New Blog Category">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $blogCategory->name }}</dd>

        </dl>

    </div>
</div>

@endsection
