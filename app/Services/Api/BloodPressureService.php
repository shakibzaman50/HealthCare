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

    protected function getHeartRateStatus(int $systolic, int $diastolic) : string
    {
        return match (true) {
            $systolic < 90 || $diastolic < 60 => 'Low Pressure',
            $systolic < 120 && $diastolic < 80 => 'Normal',
            $systolic < 130 && $diastolic < 80 => 'Elevated',
            ($systolic >= 130 && $systolic < 140) || ($diastolic >= 80 && $diastolic < 90) => 'High BP (stage-1)',
            ($systolic >= 140 && $systolic < 180) || ($diastolic >= 90 && $diastolic < 120) => 'High BP (stage-2)',
            $systolic >= 180 || $diastolic >= 120 => 'Hypertensive Crisis',
            default => 'Unclassified',
        };
    }

    public function lastWeekAverageRecord() : array
    {
        $averageSystolic = BloodPressure::where('profile_id', $this->profileId)
            ->whereDate('measured_at', '>=', Carbon::now()->subWeek())
            ->avg('systolic');

        $averageDiastolic = BloodPressure::where('profile_id', $this->profileId)
            ->whereDate('measured_at', '>=', Carbon::now()->subWeek())
            ->avg('diastolic');

        if ($averageSystolic == 0 || $averageDiastolic == 0) return [];

        $averageSystolic = round($averageSystolic);
        $averageDiastolic = round($averageDiastolic);
        $status = $this->getHeartRateStatus($averageSystolic, $averageDiastolic);

        return [
            'average_status'    => $status,
            'average_systolic'  => $averageSystolic,
            'average_diastolic' => $averageDiastolic,
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
        $status = $this->getHeartRateStatus($request->systolic, $request->diastolic);

        return new BloodPressureResource(
            BloodPressure::create([
                'profile_id'  => $this->profileId,
                'unit_id'     => $request->unit_id,
                'systolic'    => $request->systolic,
                'diastolic'   => $request->diastolic,
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
