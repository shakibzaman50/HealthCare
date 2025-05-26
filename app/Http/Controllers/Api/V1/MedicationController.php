<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Medicine\MedicineResource;
use App\Http\Resources\Medicine\MedicineCollection;
use App\Http\Resources\Medicine\MedicineFrequencyResource;
use App\Models\Medicine;
use App\Models\MedicineFrequency;
use App\Models\MedicineSchedule;
use App\Services\Api\MedicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MedicationController extends Controller
{
    public function __construct(
        private MedicationService $medicationService
    ) {
        //
    }

    /**
     * Get paginated list of medications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $medications = $this->medicationService->list($request->profile_id);
        return ApiResponse::success(
            'Medications retrieved successfully',
            new MedicineCollection($medications)
        );
    }

    /**
     * Store a new medication
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profile_id' => 'required|exists:profiles,id',
                'medicine_type_id' => 'required|exists:medicine_types,id',
                'medicine_unit_id' => 'required|exists:medicine_units,id',
                'name' => 'required|string|max:255',
                'strength' => 'required|integer',
                'notes' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error(
                    'Validation failed',
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    $validator->errors()
                );
            }

            $medication = $this->medicationService->create($request->all());
            return ApiResponse::success(
                'Medication created successfully',
                new MedicineResource($medication),
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            Log::error('Error creating medication: ' . $e->getMessage());
            return ApiResponse::error(
                'Error creating medication',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Get a specific medication
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function frequencies()
    {
      return ApiResponse::success(
        'Medication frequencies retrieved successfully',
        MedicineSchedule::select('id', 'name')->get()
      );
    }

    /**
     * Delete a medication
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->medicationService->delete($id);
            return ApiResponse::success(
                'Medication deleted successfully'
            );
        } catch (\Exception $e) {
            Log::error('Error deleting medication: ' . $e->getMessage());
            return ApiResponse::error(
                'Error deleting medication',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Get medication types
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function types()
    {
        try {
            $types = $this->medicationService->types();
            return ApiResponse::success(
                'Medication types retrieved successfully',
                $types
            );
        } catch (\Exception $e) {
            Log::error('Error retrieving medication types: ' . $e->getMessage());
            return ApiResponse::error(
                'Error retrieving medication types',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Get medication units
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function units()
    {
        try {
            $units = $this->medicationService->units();
            return ApiResponse::success(
                'Medication units retrieved successfully',
                $units
            );
        } catch (\Exception $e) {
            Log::error('Error retrieving medication units: ' . $e->getMessage());
            return ApiResponse::error(
                'Error retrieving medication units',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}