<?php

namespace App\Services\Api;

use App\Http\Resources\Api\BloodOxygen\BloodOxygenCollection;
use App\Http\Resources\Api\BloodOxygen\BloodOxygenResource;
use App\Models\BloodOxygen;
use Carbon\Carbon;

class BloodOxygenService
{
    protected $profileId;

    public function __construct($id)
    {
        $this->profileId = $id;
    }

    public function latestRecord()
    {
        return new BloodOxygenResource(
            BloodOxygen::where('profile_id', $this->profileId)
                ->latest('measured_at')
                ->first()
        );
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
        return BloodOxygenResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
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
