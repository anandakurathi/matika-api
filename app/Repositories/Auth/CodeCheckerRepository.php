<?php

namespace App\Repositories\Auth;

use App\Models\PasswordResetCodes;
use App\Models\User;

class CodeCheckerRepository
{
    public function getCodeByEmail(string $email)
    {
        return PasswordResetCodes::where('email', $email)->first();
    }

    public function getUserByEmail(string $email)
    {
        return User::firstWhere('email', $email);
    }

    public function updatePassword(User $user, $password): bool
    {
        return $user->update(['password' => $password]);
    }

    public function deleteCode($email): ?bool
    {
        return PasswordResetCodes::where('email', $email)->delete();
    }

}
