<?php

namespace App\Services\Auth;

use App\Repositories\Auth\NewPasswordRepository;
use App\Traits\AuthResponseTrait;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class NewPasswordService
{
    use AuthResponseTrait;
    protected NewPasswordRepository $newPasswordRepository;

    public function __construct(NewPasswordRepository $newPasswordRepository){
        $this->newPasswordRepository = $newPasswordRepository;
    }

    /**
     * @throws ValidationException
     */
    public function newPassword($request): array
    {
        $user = auth()->user();

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.

        $user->update([
            'password' => Hash::make($request['password']),
            'remember_token' => Str::random(60),
        ]);

        event(new PasswordReset($user));

        return [
            'message' => __(Password::PASSWORD_RESET),
            'code' => ResponseAlias::HTTP_OK,
        ];
    }
}
