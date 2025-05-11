@extends('layouts/layoutMaster')

@section('title', 'Edit blog')

@section('content')

    <div class="card text-bg-theme">

         <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($blogCategory->name) ? $blogCategory->name : 'Blog Category' }}</h4>
            <div>
                <a href="{{ route('blog_categories.blog_category.index') }}" class="btn btn-primary" title="Show All Blog Category">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('blog_categories.blog_category.create') }}" class="btn btn-secondary" title="Create New Blog Category">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
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

            <form method="POST" class="needs-validation" novalidate action="{{ route('blog_categories.blog_category.update', $blogCategory->id) }}" id="edit_blog_category_form" name="edit_blog_category_form" accept-charset="UTF-8" >
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('blog_categories.form', [
                                        'blogCategory' => $blogCategory,
                                      ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Update">
                </div>
            </form>

        </div>
    </div>

@endsection
