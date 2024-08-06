<?php

namespace App\Repositories\Auth;

use App\Models\User;

class LoginRepository
{
    protected User $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function checkUser($email): User|null
    {
        return $this->userModel->where('email', $email)->first();
    }

}
