<?php

namespace App\Services\Config;

use App\Helpers\Helpers;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogService
{
    public function create($request) : Blog
    {
        $thumbnail = Helpers::getFileUrl($request->thumbnail, 'thumbnail/');
        return Blog::create([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'tags'      => implode(', ',$request->tags),
            'is_active' => $request->has('is_active'),
            'thumbnail' => $thumbnail,
            'content'   => $request->content,
        ]);
    }

    public function update(Blog $blog, $request): Blog
    {
        $thumbnail = Helpers::getFileUrl($request->thumbnail, 'thumbnail/', $blog->thumbnail);
        $blog->update([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'tags'      => implode(', ',$request->tags),
            'is_active' => $request->has('is_active'),
            'thumbnail' => $thumbnail,
            'content'   => $request->content,
        ]);
        return $blog;
    }

    public function delete(Blog $blog): bool
    {
        if (file_exists($blog->thumbnail)){
            unlink($blog->thumbnail);
        }
        return $blog->delete();
    }
}
