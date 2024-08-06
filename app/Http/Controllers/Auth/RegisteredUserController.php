<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Services\Auth\UserRegistrationService;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    /**
     * @var UserRegistrationService
     */
    protected UserRegistrationService $userRegistrationService;
    public function __construct(UserRegistrationService $userRegistrationService)
    {
        $this->userRegistrationService = $userRegistrationService;
    }

    public function store(RegistrationRequest $request): JsonResponse|Exception
    {
        // Validate input using RegisterUserRequest
        $validatedData = $request->validated();

        $response = $this->userRegistrationService->register($validatedData);

        return ApiResponse::success($response, $response['code'], $response['code']);
    }
}
