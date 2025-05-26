<?php

namespace App\Services\Api;

use App\Http\Controllers\Admin\BloodPressureController;
use App\Http\Resources\Api\BloodPressure\BloodPressureCollection;
use App\Http\Resources\Api\BloodPressure\BloodPressureResource;
use App\Models\BloodPressure;
use Carbon\Carbon;

class BloodPressureService
{
    protected $profileId;

    public function __construct($id)
    {
        $this->profileId = $id;
    }

    public function latestRecord() : BloodPressureResource
    {
        return new BloodPressureResource(
            BloodPressure::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->latest('measured_at')
                ->first()
        );
    }

    public function history() : BloodPressureCollection
    {
        return new BloodPressureCollection(
            BloodPressure::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->latest('measured_at')
                ->paginate(20)
        );
    }

    public function RecordByDate($date)
    {
        return BloodPressureResource::collection(
            BloodPressure::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->whereDate('measured_at', $date)
                ->latest('measured_at')
                ->get()
        );
    }

    protected function getHeartRateStatus($bpm) : string
    {
        return match (true) {
            $bpm < 60   => 'Low',
            $bpm <= 100 => 'Normal',
            $bpm <= 120 => 'Elevated',
            $bpm <= 140 => 'High',
            default     => 'Very High',
        };
    }

    public function lastWeekAverageRecord() : array
    {
        $averageHeartRate = BloodPressure::where('profile_id', $this->profileId)
            ->whereDate('measured_at', '>=', Carbon::now()->subWeek())
            ->avg('heart_rate');

        if ($averageHeartRate == 0) return [];

        $averageHeartRate = round($averageHeartRate);
        $status = $this->getHeartRateStatus($averageHeartRate);

        return [
            'average_status'     => $status,
            'average_heart_rate' => $averageHeartRate,
        ];
    }

    public function fetchRangedData($startDate, $endDate, string $sortDirection='desc')
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate   = Carbon::parse($endDate)->endOfDay();

        return BloodPressure::where('profile_id', $this->profileId)
            ->whereBetween('measured_at', [$startDate, $endDate])
            ->orderBy('measured_at', $sortDirection)
            ->get();
    }

    public function filter($request)
    {
        return BloodPressureResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
    }

    public function export($request)
    {
        return BloodPressureResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
    }

    public function store($request) : BloodPressureResource
    {
        $status = $this->getHeartRateStatus($request->heart_rate);

        return new BloodPressureResource(
            BloodPressure::create([
                'profile_id'  => $this->profileId,
                'unit_id'     => $request->unit_id,
                'heart_rate'  => $request->heart_rate,
                'status'      => $status,
                'measured_at' => $request->measured_at,
            ])
        );
    }

    public function delete(BloodPressure $bloodPressure) : bool
    {
        return $bloodPressure->delete();
    }
}
