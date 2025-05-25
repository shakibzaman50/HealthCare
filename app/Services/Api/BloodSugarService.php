<?php

namespace App\Services\Api;

use App\Helpers\BloodSugarStatus;
use App\Http\Resources\BloodSugar\BloodSugarCollection;
use App\Http\Resources\BloodSugar\BloodSugarResource;
use App\Models\BloodSugar;
use App\Models\SugarSchedule;
use App\Models\SugarUnit;
use Carbon\Carbon;
use Exception;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Service class for managing Blood Sugar Records
 */
class BloodSugarService
{
    /**
     * Get paginated list of blood sugar records with related data
     *
     * @return BloodSugarCollection
     */
    function list($profileId = null)
    {
        return new BloodSugarCollection(
            QueryBuilder::for(BloodSugar::class)
                ->with(['sugarSchedule', 'sugarUnit'])
                ->allowedFilters([
                    'profile_id',
                    AllowedFilter::callback('date', function ($query, $value) {
                        $startDate = Carbon::parse($value[0])->format('Y-m-d');
                        $endDate = Carbon::parse($value[1])->addDay()->format('Y-m-d');
                        $query->whereBetween('measured_at', [$startDate, $endDate]);
                    })
                ])
                ->when(!request()->has('filter[date]'), function ($query) {
                    $query->whereBetween('measured_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()->addDay()]);
                })
                ->when($profileId, function ($query) use ($profileId) {
                    $query->where('profile_id', $profileId);
                })
                ->paginate(15)
        );
    }

    function units()
    {
        return SugarUnit::select('id', 'name')->get();
    }

    function sugarSchedules()
    {
        return SugarSchedule::select('id', 'name')->get();
    }

    /**
     * Create a new blood sugar record
     *
     * @param array $data The blood sugar record data
     * @return BloodSugarResource
     */
    function create(array $data)
    {
        return new BloodSugarResource(
            BloodSugar::create($data)
        );
    }

    /**
     * Get a specific blood sugar record by ID with related data
     *
     * @param int $id The record ID
     * @return BloodSugarResource
     */
    function view($id)
    {
        return new BloodSugarResource(
            BloodSugar::with(['profile', 'sugarSchedule', 'sugarUnit'])->findOrFail($id)
        );
    }

    /**
     * Delete a blood sugar record by ID
     *
     * @param int $id The record ID
     * @return bool|null Returns true if deleted successfully, null if record not found
     */
    function delete($id)
    {
        try {
            $bloodSugar = BloodSugar::findOrFail($id);
            $bloodSugar->delete();
            return true;
        } catch (Exception $exception) {
            throw new NotFoundHttpException('Blood sugar record not found');
        }
    }

    function getStatistics($profileId)
    {
        return new BloodSugarResource(BloodSugar::where('profile_id', $profileId)
        ->when(request()->has('last_week_avg'), function ($query) {
            $query->whereBetween('measured_at', [Carbon::now()->subDays(7)->startOfDay(), Carbon::now()->endOfDay()->addDay()]);
        })
        ->when(request()->has('last_record'), function ($query) {
            $query->orderBy('measured_at', 'desc')->first();
        })
        ->first());
    }

    function rangeGuideline($data)
    {
        return [
            'status' => BloodSugarStatus::check(
                value : $data['value'],
                scheduleId : $data['sugar_schedule_id'],
                unitId : $data['unit_id']
            ),
            'schedule' => SugarSchedule::find($data['sugar_schedule_id'])->name,
            'unit' => SugarUnit::find($data['unit_id'])->name,
        ];
    }

    /**
     * Export blood sugar records to CSV
     *
     * @param array|null $selectedIds Array of record IDs to export, null for all records
     * @return string CSV content
     */
    public function exportForApi($data)
    {
        $records = BloodSugar::with(['profile', 'sugarSchedule', 'sugarUnit'])
        ->whereBetween('measured_at', [Carbon::parse($data['from_date'])->format('Y-m-d'), Carbon::parse($data['to_date'])->addDay()->format('Y-m-d')])
        ->get();

        $csvHeader = [
            'ID',
            'Profile Name',
            'Blood Sugar Level',
            'Schedule',
            'Unit',
            'Notes',
            'Measured At'
        ];

        $csvData = [];
        foreach ($records as $record) {
            $csvData[] = [
                $record->id,
                $record->profile->name ?? 'N/A',
                $record->sugar_level,
                $record->sugarSchedule->name ?? 'N/A',
                $record->sugarUnit->name ?? 'N/A',
                $record->notes,
                $record->measured_at,
            ];
        }

        if ($data['file'] == 'csv') { // CSV
            $output = fopen('php://temp', 'r+');
            fputcsv($output, $csvHeader);

            foreach ($csvData as $row) {
                fputcsv($output, $row);
            }

            rewind($output);
            $csv = stream_get_contents($output);
            fclose($output);

            return response()->streamDownload(function () use ($csv) {
                echo $csv;
            }, 'blood_sugar_records.csv');
        } else { // PDF
            // $pdf = PDF::loadView('exports.blood-sugar-records', [
            //     'header' => $csvHeader,
            //     'data' => $csvData
            // ]);
            return "Working on it pdf"; // TODO: Implement PDF export
            // return $pdf->download('blood_sugar_records.pdf');
        }
    }

    public function exportForAdmin(array $selectedIds)
    {
        $records = BloodSugar::with(['profile', 'sugarSchedule', 'sugarUnit'])
        ->whereIn('id', $selectedIds)
        ->get();

        $csvHeader = [
            'ID',
            'Profile Name',
            'Blood Sugar Level',
            'Schedule',
            'Unit',
            'Notes',
            'Measured At'
        ];

        $csvData = [];
        foreach ($records as $record) {
            $csvData[] = [
                $record->id,
                $record->profile->name ?? 'N/A',
                $record->sugar_level,
                $record->sugarSchedule->name ?? 'N/A',
                $record->sugarUnit->name ?? 'N/A',
                $record->notes,
                $record->measured_at,
            ];
        }

            $output = fopen('php://temp', 'r+');
            fputcsv($output, $csvHeader);

            foreach ($csvData as $row) {
                fputcsv($output, $row);
            }

            rewind($output);
            $csv = stream_get_contents($output);
            fclose($output);

            return response()->streamDownload(function () use ($csv) {
                echo $csv;
            }, 'blood_sugar_records.csv');
    }

    public function bulkDelete(array $selectedIds)
    {
        return BloodSugar::whereIn('id', $selectedIds)->delete();
    }

    public function statistics($data)
    {
        $sugarSchedules = SugarSchedule::query()->get();
        // return last week average
        $lastWeekAvg = [];
        if(array_key_exists('last_week_avg', $data)){
            $sugarSchedules->each(function($schedule) use (&$lastWeekAvg){
                // Get distinct units used for this schedule
                $units = BloodSugar::where('sugar_schedule_id', $schedule->id)
                    ->whereBetween('measured_at', [Carbon::now()->subDays(7)->startOfDay(), Carbon::now()->endOfDay()])
                    ->select('sugar_unit_id')
                    ->distinct()
                    ->get();
                
                // Calculate average for each unit within this schedule
                foreach ($units as $unit) {
                    $bloodSugar = BloodSugar::where('sugar_schedule_id', $schedule->id)
                        ->where('sugar_unit_id', $unit->sugar_unit_id)
                        ->whereBetween('measured_at', [Carbon::now()->subDays(7)->startOfDay(), Carbon::now()->endOfDay()]);
                    
                    if($bloodSugar->count() > 0){
                        $lastWeekAvg[] = [
                            'value' => $bloodSugar->avg('value'),
                            'unit' => $bloodSugar->first()->sugarUnit->name,
                            'schedule' => $schedule->name,
                        ];
                    }
                }
            });
        }

        // return last record
        $lastRecord = [];
        if(array_key_exists('last_record', $data)){
            $sugarSchedules->each(function($schedule) use (&$lastRecord){
                $lastRecord[] = [
                    'value' => BloodSugar::orderBy('measured_at', 'desc')->first()->value,
                    'unit' => BloodSugar::orderBy('measured_at', 'desc')->first()->sugarUnit->name,
                    'schedule' => $schedule->name,
                ];
            });
        }

        return [
            'last_week_avg' => $lastWeekAvg,
            'last_record' => $lastRecord,
        ];
    }
}