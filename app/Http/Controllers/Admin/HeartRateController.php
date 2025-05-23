<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeartRate;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HeartRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HeartRate::with(['profile', 'unit']);

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
            $heartRates = $query->get();

            // If specific records are selected, filter them
            if ($request->filled('selected_ids')) {
                $selectedIds = explode(',', $request->selected_ids);
                $heartRates = $heartRates->whereIn('id', $selectedIds);
            }

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="heart_rates.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function () use ($heartRates) {
                $file = fopen('php://output', 'w');

                // Add headers
                fputcsv($file, ['Profile', 'Heart Rate', 'Unit', 'Measured At']);

                // Add data
                foreach ($heartRates as $heartRate) {
                    fputcsv($file, [
                        $heartRate->profile->name ?? 'N/A',
                        $heartRate->heart_rate,
                        $heartRate->unit->name ?? 'N/A',
                        $heartRate->measured_at
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $heartRates = $query->latest()->paginate(10);
        $profiles = Profile::all();

        return view('admin.heart-rate.index', compact('heartRates', 'profiles'));
    }

    /**
     * Remove the specified resources from storage.
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:heart_rates,id'
            ]);

            HeartRate::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected records deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting records: ' . $e->getMessage()
            ], 500);
        }
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
        $heartRate = HeartRate::findOrFail($id);
        $heartRate->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }
}
