<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBloodSugerRequest;
use App\Services\Config\BsRecordService;
use Illuminate\Http\Request;

/**
 * Controller for handling Blood Sugar related API endpoints
 */
class BloodSugarController extends Controller
{
    /**
     * Constructor
     * 
     * @param BsRecordService $bsRecordService Service for blood sugar record operations
     */
    public function __construct(
        private BsRecordService $bsRecordService
    ) {
    }

    /**
     * Get paginated list of blood sugar records
     * 
     * @param Request $request The incoming request
     * @return \Illuminate\Http\Response
     */
    public function index($profileId)
    {
        return ApiResponse::response(
            true,
            'Blood sugar records fetched successfully',
            $this->bsRecordService->list($profileId),
            null,
            200
        );
    }

    /**
     * Store a new blood sugar record
     * 
     * @param StoreBloodSugerRequest $request The validated request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBloodSugerRequest $request)
    {
        return ApiResponse::response(
            true,
            'Blood sugar record created successfully',
            $this->bsRecordService->create($request->validated()),
            null,
            200
        );
    }

    public function destroy($profile_id, $id)
    {
        return ApiResponse::response(
            true,
            'Blood sugar record deleted successfully',
            $this->bsRecordService->delete($id),
            null,
            200
        );
    }

    public function exportToCsv(Request $request)
    {
        return $this->bsRecordService->exportToCsv($request->ids);
    }
}
