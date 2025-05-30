<?php

namespace App\Services\Api;

use App\Http\Resources\Api\HeartRate\HeartRateCollection;
use App\Http\Resources\Api\HeartRate\HeartRateResource;
use App\Models\HeartRate;
use Carbon\Carbon;

class HeartRateService
{
    protected $profileId;

    public function __construct($id)
    {
        $this->profileId = $id;
    }

    public function latestRecord() : HeartRateResource|null
    {
        $latestRecord = HeartRate::with(['unit'])
            ->where('profile_id', $this->profileId)
            ->latest('measured_at')
            ->first();

        if ($latestRecord) {
          return new HeartRateResource($latestRecord);
        }
        return null;
    }

    public function history() : HeartRateCollection
    {
        return new HeartRateCollection(
            HeartRate::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->latest('measured_at')
                ->paginate(20)
        );
    }

    public function RecordByDate($date)
    {
        return HeartRateResource::collection(
            HeartRate::with(['unit'])
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

    protected function getHRVStatus($hrv) : string
    {
        return match (true) {
            $hrv > 100    => 'Excellent',
            $hrv >= 70    => 'Good',
            $hrv >= 50    => 'Average',
            $hrv >= 30    => 'Below Average',
            default       => 'Low',
        };
    }

    protected function calculateStress($hrv) : string
    {
        return match (true) {
            $hrv > 100    => rand(0, 10),
            $hrv >= 70    => rand(10, 30),
            $hrv >= 50    => rand(30, 50),
            $hrv >= 30    => rand(50, 70),
            default       => rand(70, 100),
        };
    }

    protected function calculateHRV($bpm) : float
    {
        $rrInterval = 60000 / $bpm;
        $variation = rand(3, 10) / 100;
        return round($rrInterval * $variation);
    }

    public function lastWeekAverageRecord() : array
    {
        $averageHeartRate = HeartRate::where('profile_id', $this->profileId)
            ->whereDate('measured_at', '>=', Carbon::now()->subWeek())
            ->avg('heart_rate');

        if ($averageHeartRate == 0) return [];


        $averageHeartRate = round($averageHeartRate);
        $status = $this->getHeartRateStatus($averageHeartRate);
        $hrv = $this->calculateHRV($averageHeartRate);
        $hrvStatus = $this->getHRVStatus($hrv);
        $stress = $this->calculateStress($hrv);

        return [
            'average_status'     => $status,
            'average_heart_rate' => $averageHeartRate,
            'average_hrv'        => $hrv,
            'average_hrv_status' => $hrvStatus,
            'average_stress'     => $stress,
        ];
    }

    public function fetchRangedData($startDate, $endDate, string $sortDirection='desc')
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate   = Carbon::parse($endDate)->endOfDay();

        return HeartRate::where('profile_id', $this->profileId)
            ->whereBetween('measured_at', [$startDate, $endDate])
            ->orderBy('measured_at', $sortDirection)
            ->get();
    }

    public function filter($request)
    {
        return HeartRateResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
    }

    public function export($request)
    {
        return HeartRateResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
    }

    public function store($request) : HeartRateResource
    {
        $status = $this->getHeartRateStatus($request->heart_rate);
        $hrv = $this->calculateHRV($request->heart_rate);
        $hrvStatus = $this->getHRVStatus($hrv);
        $stress = $this->calculateStress($hrv);

        return new HeartRateResource(
            HeartRate::create([
                'profile_id'  => $this->profileId,
                'unit_id'     => $request->unit_id,
                'heart_rate'  => $request->heart_rate,
                'status'      => $status,
                'hrv'         => $hrv,
                'hrv_status'  => $hrvStatus,
                'stress'      => $stress,
                'measured_at' => $request->measured_at,
            ])
        );
    }

    public function delete(HeartRate $heartRate) : bool
    {
        return $heartRate->delete();
    }
}
