<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BloodPressure;
use App\Models\Profile;
use Illuminate\Http\Request;

class BloodPressureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BloodPressure::with(['profile']);

        // Apply filters
        if ($request->filled('profile_id')) {
            $query->where('profile_id', $request->profile_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('measured_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('measured_at', '<=', $request->end_date);
        }

        // Handle export
        if ($request->has('export_csv')) {
            $bloodPressures = $query->get();

            // If specific records are selected, filter them
            if ($request->filled('selected_ids')) {
                $selectedIds = explode(',', $request->selected_ids);
                $bloodPressures  = $bloodPressures->whereIn('id', $selectedIds);
            }

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="blood_pressures.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function () use ($bloodPressures) {
                $file = fopen('php://output', 'w');

                // Add headers
                fputcsv($file, ['Profile', 'Systolic', 'Diastolic', 'Unit', 'Measured At']);

                // Add data
                foreach ($bloodPressures as $bloodPressure) {
                    fputcsv($file, [
                        $bloodPressure->profile->name ?? 'N/A',
                        $bloodPressure->systolic,
                        $bloodPressure->diastolic,
                        $bloodPressure->unit->name ?? 'N/A',
                        Helpers::formattedDateTime($bloodPressure->measured_at)
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $bloodPressures = $query->latest()->paginate(10);
        $profiles = Profile::select('id', 'name')->get();

        return view('admin.blood-pressure.index', compact('bloodPressures', 'profiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bloodPressure = BloodPressure::findOrFail($id);
        $bloodPressure->delete();
        return response()->json(['message' => 'Blood Pressure Record deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:heart_rates,id'
            ]);

            BloodPressure::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected Blood Pressure records deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting records: ' . $e->getMessage()
            ], 500);
        }
    }
}
