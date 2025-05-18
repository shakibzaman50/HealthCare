<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\ActivityLevelRequest;
use App\Models\ActivityLevel;
use App\Services\Config\ActivityLevelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActivityLevelController extends Controller
{
    protected $activityLevelService;

    public function __construct(ActivityLevelService $activityLevelService)
    {
        $this->activityLevelService = $activityLevelService;
    }

    protected function findActivityLevel(int $id)
    {
        return ActivityLevel::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activityLevels = ActivityLevel::latest()->paginate(25);
        return view('activity_levels.index', compact('activityLevels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activity_levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityLevelRequest $request)
    {
        try {
            $this->activityLevelService->create($request->validated());
            return redirect()->route('activity-levels.index')
                ->with('success_message', 'Activity Level was successfully added.');
        } catch (\Exception $e) {
            Log::error('Activity Level Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activityLevel = $this->findActivityLevel($id);
        return view('activity_levels.show', compact('activityLevel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activityLevel = $this->findActivityLevel($id);
        return view('activity_levels.edit', compact('activityLevel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityLevelRequest $request, string $id)
    {
        try {
            $activityLevel = $this->findActivityLevel($id);
            $this->activityLevelService->update($activityLevel, $request->validated());
            return redirect()->route('activity-levels.index')
                ->with('success_message', 'Activity Level was successfully updated.');
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
            $activityLevel = $this->findActivityLevel($id);
            if (in_array($activityLevel->name, config('basic.activityLevels'))
                // || BloodSugar::where('feeling_id', $id)->exists()
            ) {
                return back()->with('error_message', 'This Activity Level cannot be deleted');
            }
            $this->activityLevelService->delete($activityLevel);

            return redirect()->route('activity-levels.index')
                ->with('success_message', 'Activity Level was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
