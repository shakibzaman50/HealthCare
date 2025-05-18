<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\BlogRequest;
use App\Models\Blog;
use App\Models\FeelingList;
use App\Models\PhysicalCondition;
use App\Services\Config\BlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    protected function findBlog(int $id)
    {
        return Blog::findOrFail($id);
    }

    protected function getTags()
    {
        $feelingList = FeelingList::pluck('name');
        $physicalConditions = PhysicalCondition::pluck('name');
        return $feelingList->merge($physicalConditions)->values();
    }

    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $blogs = Blog::latest()->paginate(25);
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allTags = $this->getTags();
        return view('blogs.create', compact('allTags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        try {
            $this->blogService->create($request);
            return redirect()->route('blogs.index')
                ->with('success_message', 'Blog was successfully added.');
        } catch (\Exception $e) {
            Log::error('Blog Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = $this->findBlog($id);
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = $this->findBlog($id);
        $allTags = $this->getTags();
        return view('blogs.edit', compact('blog', 'allTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        try {
            $blog = $this->findBlog($id);
            $this->blogService->update($blog, $request);
            return redirect()->route('blogs.index')
               ->with('success_message', 'Blog was successfully updated.');
        } catch (\Exception $e) {
            Log::error('Updated failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $blog = $this->findBlog($id);
            $this->blogService->delete($blog);

            return redirect()->route('blogs.index')
                ->with('success_message', 'Feeling List was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
