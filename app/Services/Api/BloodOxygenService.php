<?php

namespace App\Services\Api;

use App\Helpers\ApiResponse;
use App\Http\Resources\Api\BloodOxygen\BloodOxygenCollection;
use App\Http\Resources\Api\BloodOxygen\BloodOxygenResource;
use App\Models\BloodOxygen;
use Carbon\Carbon;

class BloodOxygenService
{
    protected $profileId, $reportService;

    public function __construct($id)
    {
        $this->profileId = $id;
        $this->reportService = new ReportService($id);
    }

    public function latestRecord() : BloodOxygenResource|null
    {
        $latestRecord = BloodOxygen::where('profile_id', $this->profileId)
            ->latest('measured_at')
            ->first();

        if ($latestRecord) {
          return new BloodOxygenResource($latestRecord);
        }
        return null;
    }

    public function history() : BloodOxygenCollection
    {
        return new BloodOxygenCollection(
            BloodOxygen::where('profile_id', $this->profileId)
                ->latest('measured_at')
                ->paginate(20)
        );
    }

    public function RecordByDate($date)
    {
        return BloodOxygenResource::collection(
            BloodOxygen::where('profile_id', $this->profileId)
                ->whereDate('measured_at', $date)
                ->latest('measured_at')
                ->get()
        );
    }

    public function lastWeekAverageRecord() : array
    {
        $averageOxygenLevel = BloodOxygen::where('profile_id', $this->profileId)
            ->whereDate('measured_at', '>=', Carbon::now()->subWeek())
            ->avg('oxygen_level');

        if ($averageOxygenLevel == 0) return [];
        $averageOxygenLevel = round($averageOxygenLevel);

        return [
            'average_status'       => $averageOxygenLevel >= 95 ? 'Saturated' : 'Desaturated',
            'average_oxygen_level' => $averageOxygenLevel,
        ];
    }

    public function fetchRangedData($startDate, $endDate, string $sortDirection='desc')
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate   = Carbon::parse($endDate)->endOfDay();

        return BloodOxygen::where('profile_id', $this->profileId)
            ->whereBetween('measured_at', [$startDate, $endDate])
            ->orderBy('measured_at', $sortDirection)
            ->get();
    }

    public function filter($request)
    {
        return BloodOxygenResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
    }

    public function export($request)
    {
        $bloodOxygens = $this->fetchRangedData($request->from_date, $request->to_date);

        if ($bloodOxygens->isEmpty()) return ApiResponse::response('false', 'No data found', 404);

        $bloodOxygens = $bloodOxygens->groupBy(fn($r) => Carbon::parse($r->measured_at)->format('Y-m-d'))
            ->map(function ($readings) {
                return [
                    'entries'    => $readings->map(fn ($entry) => [
                        'time'         => Carbon::parse($entry->measured_at)->format('h:i A'),
                        'oxygen_level' => $entry->oxygen_level,
                        'status'       => $entry->status==1 ? 'Saturated' : 'Desaturated',
                    ]),
                ];
            });

        $path = $this->reportService->makeReport($request, [], [], [], $bloodOxygens, []);
        return ApiResponse::response(true, 'Blood Oxygen successfully exported.',[
            'url' => $path,
        ]);
    }

    public function store($request) : BloodOxygenResource
    {
        return new BloodOxygenResource(
            BloodOxygen::create([
                'profile_id'   => $this->profileId,
                'oxygen_level' => $request->oxygen_level,
                'status'       => $request->oxygen_level >= 95,
                'measured_at'  => $request->measured_at,
            ])
        );
    }

    public function delete(BloodOxygen $bloodOxygen) : bool
    {
        return $bloodOxygen->delete();
    }
}
