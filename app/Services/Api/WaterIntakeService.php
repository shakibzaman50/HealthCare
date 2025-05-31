<?php

namespace App\Services\Api;

use App\Helpers\ApiResponse;
use App\Http\Resources\Api\WaterIntake\WaterIntakeCollection;
use App\Http\Resources\Api\WaterIntake\WaterIntakeResource;
use App\Models\WaterIntake;
use App\Models\WaterUnit;
use Carbon\Carbon;

class WaterIntakeService
{
    protected $profileId, $reportService;

    public function __construct($id)
    {
        $this->profileId = $id;
        $this->reportService = new ReportService($id);
    }

    public function latestRecord() : WaterIntakeResource|null
    {
        $latestRecord = WaterIntake::with(['unit'])
            ->where('profile_id', $this->profileId)
            ->latest('drink_at')
            ->first();

        if ($latestRecord) {
            return new WaterIntakeResource($latestRecord);
        }
        return null;
    }

    public function history() : WaterIntakeCollection
    {
        return new WaterIntakeCollection(
            WaterIntake::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->latest('drink_at')
                ->paginate(20)
        );
    }

    public function RecordByDate($date)
    {
        return WaterIntakeResource::collection(
            WaterIntake::with(['unit'])
                ->where('profile_id', $this->profileId)
                ->whereDate('drink_at', $date)
                ->latest('drink_at')
                ->get()
        );
    }

    public function convertIntoL(int $id, float $amount) : float
    {
        $unit = WaterUnit::findOrFail($id);
        return $amount / $unit->divided_by;
    }

    protected function getStatusAndDone($newAmount, $date) : array
    {
        $drinkAt = Carbon::parse($date);
        $waterDrank = WaterIntake::where('profile_id', $this->profileId)
            ->whereDate('drink_at', $drinkAt)
            ->sum('amount_in_l');

        $drankToday = $waterDrank + $newAmount;

        return $this->calculateStatusAndDone($drankToday);
    }

    protected function calculateStatusAndDone($drankToday) : array
    {
        $goal = 5;
        $status = $goal <= $drankToday;
        $done = min(100, round(($drankToday / $goal) * 100));
        return [
            'done'    => $done,
            'status'  => $status,
        ];
    }

    public function fetchRangedData($startDate, $endDate, string $sortDirection='desc')
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate   = Carbon::parse($endDate)->endOfDay();

        return WaterIntake::where('profile_id', $this->profileId)
            ->whereBetween('drink_at', [$startDate, $endDate])
            ->orderBy('drink_at', $sortDirection)
            ->get();
    }

    public function filter($request)
    {
        return WaterIntakeResource::collection(
            $this->fetchRangedData($request->from_date, $request->to_date)
        );
    }

    public function export($request)
    {
        $waterIntakes = $this->fetchRangedData($request->from_date, $request->to_date);

        if ($waterIntakes->isEmpty()) return ApiResponse::response('false', 'No data found', 404);

        $waterIntakes = $waterIntakes->groupBy(fn($r) => Carbon::parse($r->drink_at)->format('Y-m-d'))
            ->map(function ($readings) {
                return [
                    'entries'    => $readings->map(fn ($entry) => [
                        'time'   => Carbon::parse($entry->drink_at)->format('h:i A'),
                        'amount' => $entry->amount.' '.$entry->unit?->name,
                        'status' => $entry->status==1 ? 'Hydrated' : 'Dehydrated',
                        'done'   => $entry->done.'%',
                    ]),
                ];
            });

        $path = $this->reportService->makeReport($request, [], [], [], [], $waterIntakes);

        return ApiResponse::response(true, 'Heart Rate successfully exported.',[
            'url' => $path,
        ]);
    }

    public function store($request) : WaterIntakeResource
    {
        $amountInL = $this->convertIntoL($request->unit_id, $request->amount);
        $result = $this->getStatusAndDone($amountInL, $request->drink_at);

        return new WaterIntakeResource(
            WaterIntake::create([
                'profile_id'  => $this->profileId,
                'unit_id'     => $request->unit_id,
                'amount'      => $request->amount,
                'amount_in_l' => $amountInL,
                'status'      => $result['status'],
                'done'        => $result['done'],
                'drink_at'    => $request->drink_at,
            ])
        );
    }

    public function delete(WaterIntake $waterIntake) : bool
    {
        $setRecords = WaterIntake::where('profile_id', $this->profileId)
          ->whereDate('drink_at', Carbon::parse($waterIntake->drink_at))
          ->select('id','amount_in_l','status','done')
          ->get();

        $total = $setRecords->where('id','<',$waterIntake->id)->sum('amount_in_l');
        $afterDeleted = $setRecords->where('id','>',$waterIntake->id);

        foreach ($afterDeleted as $record) {
            $total += $record->amount_in_l;
            $result = $this->calculateStatusAndDone($total);
            $record->update([
                'done'   => $result['done'],
                'status' => $result['status'],
            ]);
        }
        return $waterIntake->delete();
    }
}
