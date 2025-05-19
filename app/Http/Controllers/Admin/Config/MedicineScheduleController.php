<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\MedicineScheduleRequest;
use App\Models\MedicineSchedule;
use App\Services\Config\MedicineScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicineScheduleController extends Controller
{
    protected $medicineScheduleService;

    public function __construct(MedicineScheduleService $medicineScheduleService)
    {
        $this->medicineScheduleService = $medicineScheduleService;
    }

    protected function findMedicineSchedule(int $id)
    {
        return MedicineSchedule::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicineSchedules = MedicineSchedule::latest()->paginate(25);
        return view('admin.config.medicine_schedules.index', compact('medicineSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.config.medicine_schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineScheduleRequest $request)
    {
        try {
            $this->medicineScheduleService->create($request->validated());
            return redirect()->route('medicine-schedules.index')
                ->with('success_message', 'Medicine Schedule was successfully added.');
        } catch (\Exception $e) {
            Log::error('Medicine Schedule Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicineSchedule = $this->findMedicineSchedule($id);
        return view('admin.config.medicine_schedules.show', compact('medicineSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicineSchedule = $this->findMedicineSchedule($id);
        return view('admin.config.medicine_schedules.edit', compact('medicineSchedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineScheduleRequest $request, string $id)
    {
        try {
            $medicineSchedule = $this->findMedicineSchedule($id);
            $this->medicineScheduleService->update($medicineSchedule, $request->validated());
            return redirect()->route('medicine-schedules.index')
                ->with('success_message', 'Medicine Schedule was successfully updated.');
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
            $medicineSchedule = $this->findMedicineSchedule($id);
            if (in_array($medicineSchedule->name, config('basic.medicineSchedules'))
                // || BloodSugar::where('feeling_id', $id)->exists()
            ) {
                return back()->with('error_message', 'This Medicine Schedule cannot be deleted');
            }
            $this->medicineScheduleService->delete($medicineSchedule);

            return redirect()->route('medicine-schedules.index')
                ->with('success_message', 'Medicine Schedule was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
