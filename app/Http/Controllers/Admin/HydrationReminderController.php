<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\HydrationReminder;
use App\Models\Profile;
use Illuminate\Http\Request;

class HydrationReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HydrationReminder::with(['profile', 'unit']);

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
            $hydrationReminders = $query->get();

            // If specific records are selected, filter them
            if ($request->filled('selected_ids')) {
                $selectedIds = explode(',', $request->selected_ids);
                $hydrationReminders  = $hydrationReminders->whereIn('id', $selectedIds);
            }

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="hydration_reminders.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function () use ($hydrationReminders) {
                $file = fopen('php://output', 'w');

                // Add headers
                fputcsv($file, ['Profile', 'Amount', 'Unit', 'Measured At']);

                // Add data
                foreach ($hydrationReminders as $hydrationReminder) {
                    fputcsv($file, [
                        $hydrationReminder->profile->name ?? 'N/A',
                        $hydrationReminder->amount,
                        $hydrationReminder->unit->name ?? 'N/A',
                        Helpers::formattedDateTime($hydrationReminder->drink_at)
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $hydrationReminders = $query->latest()->paginate(10);
        $profiles = Profile::select('id', 'name')->get();

        return view('admin.hydration-reminder.index', compact('hydrationReminders', 'profiles'));
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
        $hydrationReminder = HydrationReminder::findOrFail($id);
        $hydrationReminder->delete();
        return response()->json(['message' => 'Hydration Reminder Record deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:heart_rates,id'
            ]);

            HydrationReminder::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected Hydration Reminder records deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting records: ' . $e->getMessage()
            ], 500);
        }
    }
}
