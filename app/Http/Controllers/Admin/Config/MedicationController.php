<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Profile;
use App\Models\MedicineType;
use App\Models\MedicineUnit;
use App\Services\Api\MedicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicationController extends Controller
{

    public function __construct(
        public MedicationService $medicationService
    ) {
        //
    }

    public function index(Request $request)
    {


        // Handle export
        // if ($request->has('export_csv')) {
        //     return $this->exportCsv($query, $request);
        // }

        $medicines = $this->medicationService->list();
        $profiles = Profile::select('id', 'name')->get();
        $medicineTypes = MedicineType::where('is_active', true)->get();
        $medicineUnits = MedicineUnit::where('is_active', true)->get();

        return view('admin.config.medication.index', compact(
            'medicines',
            'profiles',
            'medicineTypes',
            'medicineUnits'
        ));
    }

    public function show(Medicine $medicine)
    {
        try {
            $medicine->load(['profile', 'medicineType', 'medicineUnit', 'reminders.schedules.scheduleTimes']);

            return view('admin.config.medication.show', compact('medicine'));
        } catch (\Exception $e) {
            Log::error('Admin medication show failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to load medication details.');
        }
    }

    public function destroy(Medicine $medicine)
    {
        try {
            $medicine->delete();

            return response()->json([
                'success' => true,
                'message' => 'Medicine deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Admin medication delete failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete medicine.'
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No medicines selected.'
                ], 400);
            }

            Medicine::whereIn('id', $ids)->delete();

            return response()->json([
                'success' => true,
                'message' => count($ids) . ' medicine(s) deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error('Admin medication bulk delete failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete medicines.'
            ], 500);
        }
    }

    public function toggleStatus(Medicine $medicine)
    {
        try {
            $medicine->update(['is_active' => !$medicine->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Medicine status updated successfully.',
                'is_active' => $medicine->is_active
            ]);
        } catch (\Exception $e) {
            Log::error('Admin medication toggle status failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update medicine status.'
            ], 500);
        }
    }

    private function exportCsv($query, Request $request)
    {
        try {
            $medicines = $query->get();

            $filename = 'medicines_' . now()->format('Y_m_d_H_i_s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($medicines) {
                $file = fopen('php://output', 'w');

                // CSV headers
                fputcsv($file, [
                    'ID',
                    'Profile Name',
                    'Medicine Name',
                    'Type',
                    'Strength',
                    'Unit',
                    'Status',
                    'Notes',
                    'Created At'
                ]);

                // CSV data
                foreach ($medicines as $medicine) {
                    fputcsv($file, [
                        $medicine->id,
                        $medicine->profile->name ?? 'N/A',
                        $medicine->name,
                        $medicine->medicineType->name ?? 'N/A',
                        $medicine->strength,
                        $medicine->medicineUnit->name ?? 'N/A',
                        $medicine->is_active ? 'Active' : 'Inactive',
                        $medicine->notes,
                        $medicine->created_at->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Admin medication export failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to export medicines.');
        }
    }
}