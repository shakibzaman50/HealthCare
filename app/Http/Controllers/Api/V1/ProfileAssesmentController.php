<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\ProfileAssessmentRequest;
use App\Http\Resources\Profile\ProfileAssessmentResource;
use App\Services\Api\Profile\ProfileAssessmentService;
use Illuminate\Http\JsonResponse;

class ProfileAssesmentController extends Controller
{
    protected $profileAssessmentService;

    public function __construct(ProfileAssessmentService $profileAssessmentService)
    {
        $this->profileAssessmentService = $profileAssessmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileAssessmentRequest $request, int $profileId): JsonResponse
    {
        $assessment = $this->profileAssessmentService->createOrUpdate($profileId, $request->validated());

        return ApiResponse::response(
            true,
            'Profile assessment saved successfully',
            new ProfileAssessmentResource($assessment),
            null,
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $profileId): JsonResponse
    {
        $assessment = $this->profileAssessmentService->getByProfileId($profileId);

        if (!$assessment) {
            return ApiResponse::response(
                false,
                'Profile assessment not found',
                null,
                null,
                404
            );
        }

        return ApiResponse::response(
            true,
            'Profile assessment retrieved successfully',
            new ProfileAssessmentResource($assessment),
            null,
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
