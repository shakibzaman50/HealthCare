<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\SugarScheduleRequest;
use App\Models\SugarSchedule;
use App\Services\Config\SugarScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SugarScheduleController extends Controller
{
    protected $sugarScheduleService;

    public function __construct(SugarScheduleService $sugarScheduleService)
    {
       $this->sugarScheduleService = $sugarScheduleService;
    }

    protected function findSugarSchedule(int $id)
    {
        return SugarSchedule::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sugarSchedules = SugarSchedule::latest()->paginate(25);
        return view('admin.config.sugar_schedule.index', compact('sugarSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.config.sugar_schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SugarScheduleRequest $request)
    {
        try {
            $this->sugarScheduleService->create($request->validated());
            return redirect()->route('sugar-schedules.index')
                ->with('success_message', 'Sugar Schedule was successfully added.');
        } catch (\Exception $e) {
            Log::error('Sugar Schedule Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sugarSchedule = $this->findSugarSchedule($id);
        return view('admin.config.sugar_schedule.show', compact('sugarSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sugarSchedule = $this->findSugarSchedule($id);
        return view('admin.config.sugar_schedule.edit', compact('sugarSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SugarScheduleRequest $request, string $id)
    {
        try {
            $sugarSchedule = $this->findSugarSchedule($id);
            $this->sugarScheduleService->update($sugarSchedule, $request->validated());
            return redirect()->route('sugar-schedules.index')
                ->with('success_message', 'Sugar Schedule was successfully updated.');
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
            $sugarSchedule = $this->findSugarSchedule($id);
            if (in_array($sugarSchedule->name, config('basic.sugarSchedules'))
              // || BloodSugar::where('feeling_id', $id)->exists()
            ) {
                return back()->with('error_message', 'This Sugar Schedule cannot be deleted');
            }
            $this->sugarScheduleService->delete($sugarSchedule);

            return redirect()->route('sugar-schedules.index')
                ->with('success_message', 'Sugar Schedule was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
              ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
