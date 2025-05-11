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
            <h4 class="m-0">Blogs</h4>
            <div>
                <a href="{{ route('blogs.blog.create') }}" class="btn btn-secondary" title="Create New Blog">
                    <span class="fa fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($blogs) == 0)
            <div class="card-body text-center">
                <h4>No Blogs Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($blogs as $blog)
                        <tr>
                            <td class="align-middle">{{ $blog->title }}</td>
                            <td class="align-middle">{{ optional($blog->blogCategory)->name }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('blogs.blog.destroy', $blog->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('blogs.blog.show', $blog->id ) }}" class="btn btn-info" title="Show Blog">
                                            Show
                                        </a>
                                        <a href="{{ route('blogs.blog.edit', $blog->id ) }}" class="btn btn-primary" title="Edit Blog">
                                            Edit
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Blog" onclick="return confirm(&quot;Click Ok to delete Blog.&quot;)">
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

            {!! $blogs->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
