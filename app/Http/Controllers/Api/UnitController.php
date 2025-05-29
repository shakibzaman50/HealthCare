<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLevel;
use App\Models\BpUnit;
use App\Models\FeelingList;
use App\Models\HeartRateUnit;
use App\Models\HeightUnit;
use App\Models\MedicineSchedule;
use App\Models\MedicineType;
use App\Models\MedicineUnit;
use App\Models\PhysicalCondition;
use App\Models\SugarSchedule;
use App\Models\SugarUnit;
use App\Models\WaterUnit;
use App\Models\WeightUnit;
use Illuminate\Http\JsonResponse;

class UnitController extends Controller
{
    /**
     * Get activity levels
     */
    public function activityLevels(): JsonResponse
    {
        $units = ActivityLevel::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Activity levels retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get BP units
     */
    public function bpUnits(): JsonResponse
    {
        $units = BpUnit::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'BP units retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get feeling lists
     */
    public function feelingLists(): JsonResponse
    {
        $units = FeelingList::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Feeling lists retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get heart rate units
     */
    public function heartRateUnits(): JsonResponse
    {
        $units = HeartRateUnit::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Heart rate units retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get height units
     */
    public function heightUnits(): JsonResponse
    {
        $units = HeightUnit::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Height units retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get medicine schedules
     */
    public function medicineSchedules(): JsonResponse
    {
        $units = MedicineSchedule::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Medicine schedules retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get medicine types
     */
    public function medicineTypes(): JsonResponse
    {
        $units = MedicineType::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Medicine types retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get medicine units
     */
    public function medicineUnits(): JsonResponse
    {
        $units = MedicineUnit::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Medicine units retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get physical conditions
     */
    public function physicalConditions(): JsonResponse
    {
        $units = PhysicalCondition::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Physical conditions retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get sugar schedules
     */
    public function sugarSchedules(): JsonResponse
    {
        $units = SugarSchedule::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Sugar schedules retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get sugar units
     */
    public function sugarUnits(): JsonResponse
    {
        $units = SugarUnit::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Sugar units retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get water units
     */
    public function waterUnits(): JsonResponse
    {
        $units = WaterUnit::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Water units retrieved successfully',
            'data' => $units
        ]);
    }

    /**
     * Get weight units
     */
    public function weightUnits(): JsonResponse
    {
        $units = WeightUnit::active()->get();
        return response()->json([
            'status' => true,
            'message' => 'Weight units retrieved successfully',
            'data' => $units
        ]);
    }
}
