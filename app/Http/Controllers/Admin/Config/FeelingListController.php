<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\FeelingListRequest;
use App\Models\FeelingList;
use App\Services\Config\FeelingListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeelingListController extends Controller
{
    protected $feelingListService;

    public function __construct(FeelingListService $feelingListService)
    {
        $this->feelingListService = $feelingListService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feelingLists = FeelingList::paginate(25);
        return view('feeling_list.index', compact('feelingLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('feeling_list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeelingListRequest $request)
    {
        try {
            $this->feelingListService->create($request->validated());
            return redirect()->route('feeling-lists.index')
              ->with('success_message', 'Feeling List was successfully added.');
        } catch (\Exception $e) {
            Log::error('Feeling List Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feelingList = FeelingList::findOrFail($id);
        return view('feeling_list.show', compact('feelingList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $feelingList = FeelingList::findOrFail($id);
        return view('feeling_list.edit', compact('feelingList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FeelingListRequest $request, string $id)
    {
        try {
            $feelingList = FeelingList::findOrFail($id);
            $this->feelingListService->update($feelingList, $request->validated());
            return redirect()->route('feeling-lists.index')
              ->with('success_message', 'Feeling List was successfully updated.');
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
            $feelingList = FeelingList::findOrFail($id);
            $this->feelingListService->delete($feelingList);

            return redirect()->route('feeling-lists.index')
                ->with('success_message', 'Feeling List was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
