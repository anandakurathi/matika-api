<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected PasswordResetService $passwordResetService;
    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function __invoke(ForgotPasswordRequest $request)
    {
        // Validate input using RegisterUserRequest
        $validatedData = $request->validated();

        $response = $this->passwordResetService->sendPasswordResetCode($validatedData);

        return response()->json($response, $response['code']);
    }
}
