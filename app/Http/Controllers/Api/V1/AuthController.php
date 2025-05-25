<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\GuestLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\Api\Authentication\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\FlareClient\Api;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request)
    {
        try {
            $response = $this->authService->register($request->validated());

            return $response['success']
                ? ApiResponse::response(
                    true,
                    $response['message'],
                    [
                        'user' => new UserResource($response['user']),
                        'token' => $response['token'],
                    ]
                )
                : ApiResponse::serverError($response['error']);
        } catch (\Exception $e) {
            Log::error('Auth API Register Error: ' . $e->getMessage());
            return ApiResponse::serverError($e->getMessage());
        }
    }
    public function login(LoginRequest $request)
    {
        try {
            $response = $this->authService->login($request);

            return ApiResponse::response(
                $response['code'] === 200,
                $response['message'],
                [
                    'user'  => $response['user'] ? new UserResource($response['user']) : null,
                    'token' => $response['token'],
                ],
                $response['error'] ?? null,
                $response['code'] ?? 200
            );
        } catch (\Exception $e) {
            Log::error('Auth API Login Error: ' . $e->getMessage());
            return ApiResponse::serverError($e->getMessage());
        }
    }


    public function logout()
    {
        try {
            return $this->authService->authLogout()
                ? ApiResponse::response(true, 'Logout successful')
                : ApiResponse::serverError('Logout failed');
        } catch (\Exception $e) {
            Log::error('Auth API Logout Error: ' . $e->getMessage());
            return ApiResponse::serverError($e->getMessage());
        }
    }
}
