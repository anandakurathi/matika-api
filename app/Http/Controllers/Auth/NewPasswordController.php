<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Services\Auth\NewPasswordService;
use Illuminate\Http\JsonResponse;

class NewPasswordController extends Controller
{
    protected NewPasswordService $newPasswordService;
    public function __construct(NewPasswordService $newPasswordService){
        $this->newPasswordService = $newPasswordService;
    }
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordRequest $request): JsonResponse
    {
        // Validate input using RegisterUserRequest
        $validatedData = $request->validated();

        $response = $this->newPasswordService->newPassword($validatedData);


        return response()->json($response, $response['code']);
    }
}
