<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LogoutController extends Controller
{
    /**
     * Destroy an authenticated session.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = request()->user();
        $tokenId = Str::before(request()->bearerToken(), '|');
        $user->tokens()->where('id', $tokenId)->delete();

        return response()->json([
            'message' => __('auth.logout'),
            'code' => ResponseAlias::HTTP_OK,
        ]);
    }
}
