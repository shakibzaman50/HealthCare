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

    public function latestRecord() : HeartRateResource
    {
        return new HeartRateResource(
            HeartRate::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->latest('measured_at')
                ->first()
        );
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

    protected function calculateHrvAndStress($bpm) : array
    {
        $hrv = round(12000 / $bpm);
        $minHrv = min($hrv, 120);
        $stress = 100 - ($minHrv / 120 * 100);
        $stress = round($stress);
        return [
            'hrv'    => $hrv,
            'stress' => $stress,
        ];
    }

    public function lastWeekAverageRecord() : array
    {
        $averageHeartRate = HeartRate::where('profile_id', $this->profileId)
            ->whereDate('measured_at', '>=', Carbon::now()->subWeek())
            ->avg('heart_rate');

        if ($averageHeartRate == 0) return [];


        $averageHeartRate = round($averageHeartRate);
        $status = $this->getHeartRateStatus($averageHeartRate);
        $result = $this->calculateHrvAndStress($averageHeartRate);

        return [
            'average_status'     => $status,
            'average_heart_rate' => $averageHeartRate,
            'average_hrv'        => $result['hrv'],
            'average_stress'     => $result['stress'],
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
        $result = $this->calculateHrvAndStress($request->heart_rate);

        return new HeartRateResource(
            HeartRate::create([
                'profile_id'  => $this->profileId,
                'unit_id'     => $request->unit_id,
                'heart_rate'  => $request->heart_rate,
                'status'      => $status,
                'hrv'         => $result['hrv'],
                'stress'      => $result['stress'],
                'measured_at' => $request->measured_at,
            ])
        );
    }

    public function delete(HeartRate $heartRate) : bool
    {
        return $heartRate->delete();
    }
}
