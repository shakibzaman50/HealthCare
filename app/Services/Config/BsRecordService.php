<?php

namespace App\Services\Config;

use App\Http\Resources\BsRecord\BsRecordCollection;
use App\Http\Resources\BsRecord\BsRecordResource;
use App\Models\BsRecord;
use Carbon\Carbon;
use Exception;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Service class for managing Blood Sugar Records
 */
class BsRecordService
{
    /**
     * Get paginated list of blood sugar records with related data
     *
     * @return BsRecordCollection
     */
    function list($profileId = null)
    {
        return new BsRecordCollection(
            QueryBuilder::for(BsRecord::class)
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

    /**
     * Create a new blood sugar record
     *
     * @param array $data The blood sugar record data
     * @return BsRecordResource
     */
    function create(array $data)
    {
        return new BsRecordResource(
            BsRecord::create($data)
        );
    }

    /**
     * Get a specific blood sugar record by ID with related data
     *
     * @param int $id The record ID
     * @return BsRecordResource
     */
    function view($id)
    {
        return new BsRecordResource(
            BsRecord::with(['profile', 'sugarSchedule', 'sugarUnit'])->findOrFail($id)
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
            $bsRecord = BsRecord::findOrFail($id);
            $bsRecord->delete();
            return true;
        } catch (Exception $exception) {
            throw new NotFoundHttpException('Blood sugar record not found');
        }
    }

    function getStatistics($profileId)
    {
        return new BsRecordResource(BsRecord::where('profile_id', $profileId)
        ->when(request()->has('last_week_avg'), function ($query) {
            $query->whereBetween('measured_at', [Carbon::now()->subDays(7)->startOfDay(), Carbon::now()->endOfDay()->addDay()]);
        })
        ->when(request()->has('last_record'), function ($query) {
            $query->orderBy('measured_at', 'desc')->first();
        })
        ->first());
    }

    /**
     * Export blood sugar records to CSV
     *
     * @param array|null $selectedIds Array of record IDs to export, null for all records
     * @return string CSV content
     */
    public function exportToCsv(string $from_date, string $to_date, string $file = 'pdf')
    {
        $records = BsRecord::with(['profile', 'sugarSchedule', 'sugarUnit'])
        ->whereBetween('measured_at', [Carbon::parse($from_date)->format('Y-m-d'), Carbon::parse($to_date)->addDay()->format('Y-m-d')])
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

        if ($file == '2') { // CSV
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
}