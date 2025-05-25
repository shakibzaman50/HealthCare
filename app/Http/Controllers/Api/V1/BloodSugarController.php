<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\BloodSugar\StoreBloodSugarRequest;
use App\Services\Api\BloodSugarService;
use Illuminate\Http\Request;

/**
 * Controller for handling Blood Sugar related API endpoints
 */
class BloodSugarController extends Controller
{
    /**
     * Constructor
     * 
     * @param BloodSugarService $bloodSugarService Service for blood sugar record operations
     */
    public function __construct(
        private BloodSugarService $bloodSugarService
    ) {
    }

    /**
     * Get paginated list of blood sugar records
     * 
     * @param int $profileId The profile ID to fetch records for
     * @return \Illuminate\Http\Response JSON response with blood sugar records
     */
    public function index($profileId)
    {
        return ApiResponse::response(
            true,
            'Blood sugar records fetched successfully',
            $this->bloodSugarService->list($profileId),
            null,
            200
        );
    }

    /**
     * Store a new blood sugar record
     * 
     * @param StoreBsRecordRequest $request The validated request containing blood sugar data
     * @return \Illuminate\Http\Response JSON response with created record
     */
    public function store(StoreBloodSugarRequest $request)
    {
        return ApiResponse::response(
            true,
            'Blood sugar record created successfully',
            $this->bloodSugarService->create($request->validated()),
            null,
            200
        );
    }

    /**
     * Get statistics for blood sugar records
     * 
     * @param int $profileId The profile ID to get statistics for
     * @return \Illuminate\Http\Response JSON response with blood sugar statistics
     */
    public function getStatistics($profileId)
    {
        return ApiResponse::response(
            true,
            'Blood sugar statistics fetched successfully',
            $this->bloodSugarService->getStatistics($profileId),
        );
    }
    
    /**
     * Delete a blood sugar record
     * 
     * @param int $profile_id The profile ID the record belongs to
     * @param int $id The ID of the record to delete
     * @return \Illuminate\Http\Response JSON response indicating success
     */
    public function destroy($profile_id, $id)
    {
        return ApiResponse::response(
            true,
            'Blood sugar record deleted successfully',
            $this->bloodSugarService->delete($id),
            null,
            200
        );
    }

    /**
     * Export blood sugar records to CSV or PDF
     * 
     * @param Request $request Request containing export parameters
     * @return mixed CSV/PDF file download response
     * 
     * @throws \Illuminate\Validation\ValidationException When validation fails
     */
    public function exportToCsv(Request $request)
    {
        $validated = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date', 
            'file' => 'required|in:1,2',
        ],[
            'file.in' => 'The file field must be either pdf or csv.',
        ]);
        return $this->bloodSugarService->export($validated);
    }
}
