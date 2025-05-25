<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BloodSugar\StoreBloodSugarRequest;
use App\Models\Profile;
use App\Services\Api\BloodSugarService;
use Illuminate\Http\Request;

class BloodSugarController extends Controller
{
    public function __construct(
        public BloodSugarService $bloodSugarService
    ) {
    }

    /**
     * Get paginated list of blood sugar records
     */
    public function index()
    {
        $bloodSugars = $this->bloodSugarService->list();

        $profiles = Profile::query()->get();
        return view('admin.blood-sugar.index', compact('bloodSugars', 'profiles'));
    }

    /**
     * Create new blood sugar record
     */
    public function store(StoreBloodSugarRequest $request)
    {
        $this->bloodSugarService->create($request->validated());

        return redirect()->back();
    }

    /**
     * Delete blood sugar record
     */
    public function destroy($id)
    {
        $this->bloodSugarService->delete($id);

        return redirect()->route('admin.blood-sugars.index')
            ->with('success_message', 'Blood Sugar Record was successfully deleted.');
    }

    /**
     * Export blood sugar records to CSV
     */
    public function exportToCsv(Request $request)
    {
        return $this->bloodSugarService->exportForAdmin((array) $request->selectedIds);
    }

    public function bulkDelete(Request $request)
    {
        $this->bloodSugarService->bulkDelete((array) $request->ids);

        return redirect()->route('admin.blood-sugars.index')
            ->with('success_message', 'Blood Sugar Records were successfully deleted.');
    }
}