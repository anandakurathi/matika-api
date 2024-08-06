<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));
        if (! hash_equals((string) $user->getKey(), (string) $request->route('id'))) {
            return redirect()->intended(
                config('app.frontend_url').'/email/verify/failed'
            );
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            return redirect()->intended(
                config('app.frontend_url').'/email/verify/failed'
            );
        }
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(
                config('app.frontend_url').'/email/verify/already-success'
            );
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user())); // @phpstan-ignore-line
        }

        return redirect()->intended(
            config('app.frontend_url').'/email/verify/success'
        );
    }
}
