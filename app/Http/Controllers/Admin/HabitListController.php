<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HabitListRequest;
use App\Models\HabitList;
use App\Models\HabitTask;
use App\Services\Admin\HabitListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HabitListController extends Controller
{
    protected $habitListService;

    public function __construct(HabitListService $habitListService)
    {
        $this->habitListService = $habitListService;
    }

    public function findHabitList(int $id) : HabitList
    {
        return HabitList::findOrFail($id);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habitLists = HabitList::paginate(25);
        return view('admin.habit-list.index', compact('habitLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.habit-list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HabitListRequest $request)
    {
        try {
            $this->habitListService->create($request);
            return redirect()->route('admin.habit-lists.index')
                ->with('success_message', 'Habit List was successfully added.');
        } catch (\Exception $e) {
            Log::error('Habit List Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $habitList = $this->findHabitList($id);
        return view('admin.habit-list.show', compact('habitList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $habitList = $this->findHabitList($id);
        return view('admin.habit-list.edit', compact('habitList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HabitListRequest $request, string $id)
    {
        try {
            $habitList = $this->findHabitList($id);
            $this->habitListService->update($habitList, $request);
            return redirect()->route('admin.habit-lists.index')
                ->with('success_message', 'Habit List was successfully updated.');
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
            $habitList = $this->findHabitList($id);
            if (HabitTask::where('habit_list_id', $id)->exists()) {
              return back()->with('error_message', 'This Habit Item cannot be deleted');
            }
            $this->habitListService->delete($habitList);

            return redirect()->route('admin.habit-lists.index')
                ->with('success_message', 'Habit List was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
