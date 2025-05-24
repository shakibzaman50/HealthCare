<?php

namespace App\Services\Config;

use App\Helpers\Helpers;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    public function create($request): Blog
    {
        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $this->handleThumbnailUpload($request->file('thumbnail'));
        }

        return Blog::create([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'tags'      => implode(', ', $request->tags),
            'is_active' => $request->has('is_active'),
            'thumbnail' => $thumbnail,
            'content'   => $request->content,
            'status'    => $request->status ?? 'draft',
            'visibility' => $request->visibility ?? 'public',
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);
    }

    public function update(Blog $blog, $request): Blog
    {
        $thumbnail = $blog->thumbnail;
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($blog->thumbnail) {
                $this->deleteThumbnail($blog->thumbnail);
            }
            $thumbnail = $this->handleThumbnailUpload($request->file('thumbnail'));
        }

        $blog->update([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'tags'      => implode(', ', $request->tags),
            'is_active' => $request->has('is_active'),
            'thumbnail' => $thumbnail,
            'content'   => $request->content,
            'status'    => $request->status ?? $blog->status,
            'visibility' => $request->visibility ?? $blog->visibility,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return $blog;
    }

    public function delete(Blog $blog): bool
    {
        if (file_exists($blog->thumbnail)) {
            unlink($blog->thumbnail);
        }
        return $blog->delete();
    }

    protected function handleThumbnailUpload($file)
    {
        // Generate unique filename
        $filename = 'blog-' . time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Store in public disk under thumbnails directory
        $path = $file->storeAs('thumbnails', $filename, 'public');

        return $path;
    }

    protected function deleteThumbnail($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
