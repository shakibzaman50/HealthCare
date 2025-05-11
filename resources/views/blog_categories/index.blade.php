@extends('layouts/layoutMaster')

@section('title', 'Edit blog')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Blog Categories</h4>
            <div>
                <a href="{{ route('blog_categories.blog_category.create') }}" class="btn btn-secondary" title="Create New Blog Category">
                    <span class="fa fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($blogCategories) == 0)
            <div class="card-body text-center">
                <h4>No Blog Categories Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($blogCategories as $blogCategory)
                        <tr>
                            <td>{{ $blogCategory->id }}</td>
                            <td class="align-middle">{{ $blogCategory->name }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('blog_categories.blog_category.destroy', $blogCategory->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('blog_categories.blog_category.edit', $blogCategory->id ) }}" class="btn btn-primary" title="Edit Blog Category">
                                            Edit
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Blog Category" onclick="return confirm(&quot;Click Ok to delete Blog Category.&quot;)">
                                            Delete
                                        </button>
                                    </div>

                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            {!! $blogCategories->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
