<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HabitTaskRequest;
use App\Models\HabitList;
use App\Models\HabitSchedule;
use App\Models\HabitTask;
use App\Services\Admin\HabitTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HabitTaskController extends Controller
{
    protected $habitTaskService;

    public function __construct(HabitTaskService $habitTaskService)
    {
        $this->habitTaskService = $habitTaskService;
    }

    protected function findHabitTask(int $id) : HabitTask
    {
        return HabitTask::findOrFail($id);
    }

    protected function getHabitList()
    {
        return HabitList::active()->select('id','name')->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habitTasks = HabitTask::with('habitList')
            ->whereNull('profile_id')
            ->paginate(25);

        return view('admin.habit-task.index', compact('habitTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $habitLists = $this->getHabitList();
        return view('admin.habit-task.create', compact('habitLists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HabitTaskRequest $request)
    {
        try {
            $this->habitTaskService->create($request);
            return redirect()->route('admin.habit-tasks.index')
                ->with('success_message', 'Habit Task was successfully added.');
        } catch (\Exception $e) {
            Log::error('Habit Task Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $habitTask = $this->findHabitTask($id);
        return view('admin.habit-task.show', compact('habitTask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $habitLists = $this->getHabitList();
        $habitTask = $this->findHabitTask($id);
        return view('admin.habit-task.edit', compact('habitTask', 'habitLists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HabitTaskRequest $request, string $id)
    {
        try {
            $habitTask = $this->findHabitTask($id);
            $this->habitTaskService->update($habitTask, $request);
            return redirect()->route('admin.habit-tasks.index')
                ->with('success_message', 'Habit Task was successfully updated.');
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
            $habitTask = $this->findHabitTask($id);
            $allTasks = collect(config('basic.habitTasks'))->flatten()->all();
            if (in_array($habitTask->name, $allTasks)
                || HabitSchedule::where('habit_task_id', $id)->exists()
            ) {
                return back()->with('error_message', 'This Habit Item cannot be deleted');
            }
            $this->habitTaskService->delete($habitTask);

            return redirect()->route('admin.habit-tasks.index')
                ->with('success_message', 'Habit Tasks was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
