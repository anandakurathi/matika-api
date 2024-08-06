<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(config('app.frontend_url').'/email/verify/success');
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => __('auth.verify.success'),
            'code' => ResponseAlias::HTTP_CREATED
        ]);
    }
}
