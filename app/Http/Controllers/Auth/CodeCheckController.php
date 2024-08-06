<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CodeCheckRequest;
use App\Services\Auth\CodeCheckerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CodeCheckController extends Controller
{
    protected CodeCheckerService $codeCheckService;

    public function __construct(CodeCheckerService $codeCheckerService)
    {
        $this->codeCheckService = $codeCheckerService;
    }

    public function __invoke(CodeCheckRequest $request): JsonResponse
    {
        // Validate input using RegisterUserRequest
        $validatedData = $request->validated();

        $response = $this->codeCheckService->check($validatedData);

        return response()->json($response, $response['code']);

    }
}
