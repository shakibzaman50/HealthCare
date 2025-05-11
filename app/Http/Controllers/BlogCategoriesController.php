<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Exception;

class BlogCategoriesController extends Controller
{

    /**
     * Display a listing of the blog categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $blogCategories = BlogCategory::paginate(25);

        return view('blog_categories.index', compact('blogCategories'));
    }

    /**
     * Show the form for creating a new blog category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('blog_categories.create');
    }

    /**
     * Store a new blog category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        BlogCategory::create($data);

        return redirect()->route('blog_categories.blog_category.index')
            ->with('success_message', 'Blog Category was successfully added.');
    }

    /**
     * Display the specified blog category.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);

        return view('blog_categories.show', compact('blogCategory'));
    }

    /**
     * Show the form for editing the specified blog category.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);
        

        return view('blog_categories.edit', compact('blogCategory'));
    }

    /**
     * Update the specified blog category in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $blogCategory = BlogCategory::findOrFail($id);
        $blogCategory->update($data);

        return redirect()->route('blog_categories.blog_category.index')
            ->with('success_message', 'Blog Category was successfully updated.');  
    }

    /**
     * Remove the specified blog category from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $blogCategory = BlogCategory::findOrFail($id);
            $blogCategory->delete();

            return redirect()->route('blog_categories.blog_category.index')
                ->with('success_message', 'Blog Category was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'name' => 'string|min:1|max:255|nullable', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
