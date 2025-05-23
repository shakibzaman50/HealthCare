<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BloodOxygen;
use App\Models\Profile;
use Illuminate\Http\Request;

class BloodOxygenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BloodOxygen::with(['profile']);

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
            $bloodOxygens = $query->get();

            // If specific records are selected, filter them
            if ($request->filled('selected_ids')) {
                $selectedIds = explode(',', $request->selected_ids);
                $bloodOxygens  = $bloodOxygens->whereIn('id', $selectedIds);
            }

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="blood_oxygens.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function () use ($bloodOxygens) {
                $file = fopen('php://output', 'w');

                // Add headers
                fputcsv($file, ['Profile', 'Oxygen Level', 'Measured At']);

                // Add data
                foreach ($bloodOxygens as $bloodOxygen) {
                    fputcsv($file, [
                        $bloodOxygen->profile->name ?? 'N/A',
                        $bloodOxygen->oxygen_level.'%',
                        Helpers::formattedDateTime($bloodOxygen->measured_at)
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

      $bloodOxygens = $query->latest()->paginate(10);
      $profiles = Profile::select('id', 'name')->get();

      return view('admin.blood-oxygen.index', compact('bloodOxygens', 'profiles'));
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
        $bloodOxygen = BloodOxygen::findOrFail($id);
        $bloodOxygen->delete();
        return response()->json(['message' => 'Blood Oxygen Record deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:heart_rates,id'
            ]);

            BloodOxygen::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected Blood Oxygen records deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting records: ' . $e->getMessage()
            ], 500);
        }
    }
}
