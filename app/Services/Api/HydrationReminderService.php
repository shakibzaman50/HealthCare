<?php

namespace App\Services\Api;

use App\Http\Resources\Api\HydrationReminder\HydrationReminderCollection;
use App\Http\Resources\Api\HydrationReminder\HydrationReminderResource;
use App\Models\HydrationReminder;
use Carbon\Carbon;

class HydrationReminderService
{
    protected $profileId;

    public function __construct($id)
    {
      $this->profileId = $id;
    }

    public function latestRecord() : HydrationReminderResource
    {
        return new HydrationReminderResource(
            HydrationReminder::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->latest('drink_at')
                ->first()
        );
    }

    public function history() : HydrationReminderCollection
    {
        return new HydrationReminderCollection(
            HydrationReminder::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->latest('drink_at')
                ->paginate(20)
        );
    }

    public function RecordByDate($date)
    {
        return HydrationReminderResource::collection(
            HydrationReminder::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->whereDate('drink_at', $date)
                ->latest('drink_at')
                ->get()
        );
    }

    protected function getHydrationReminderStatus($bpm) : string
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
        $averageHydration = HydrationReminder::where('profile_id', $this->profileId)
            ->whereDate('drink_at', '>=', Carbon::now()->subWeek())
            ->avg('heart_rate');

        if ($averageHydration == 0) return [];

        $averageHydration = round($averageHydration);
        $status = $this->getHydrationReminderStatus($averageHydration);

        return [
            'average_status'    => $status,
            'average_hydration' => $averageHydration,
        ];
    }

    public function fetchRangedData($startDate, $endDate, string $sortDirection='desc')
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate   = Carbon::parse($endDate)->endOfDay();

        return HydrationReminder::where('profile_id', $this->profileId)
            ->whereBetween('drink_at', [$startDate, $endDate])
            ->orderBy('drink_at', $sortDirection)
            ->get();
    }

    public function filter($request)
    {
        return HydrationReminderResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
    }

    public function export($request)
    {
        return HydrationReminderResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
    }

    public function store($request) : HydrationReminderResource
    {
        $status = $this->getHydrationReminderStatus($request->heart_rate);

        return new HydrationReminderResource(
            HydrationReminder::create([
                'profile_id'  => $this->profileId,
                'unit_id'     => $request->unit_id,
                'amount'      => $request->amount,
                'status'      => $status,
                'drink_at'    => $request->drink_at,
            ])
        );
    }

    public function delete(HydrationReminder $hydrationReminder) : bool
    {
        return $hydrationReminder->delete();
    }
}
