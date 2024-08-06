<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    protected LoginService $loginService;
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $response = $this->loginService->login($request);

        return response()->json($response, $response['code']);
    }
}
