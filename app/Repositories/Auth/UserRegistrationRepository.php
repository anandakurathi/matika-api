<?php

namespace App\Repositories\Auth;

use App\Models\User;

class UserRegistrationRepository
{

    protected User $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    /*
     * Check Email Unique or not
     * @return Boolean
     */
    public function isEmailUnique(string $email): bool
    {
        return !!$this->userModel->where('email', $email)->doesntExist();
    }

    /*
     * Create User
     * @return User|NULL
     */
    public function createUser(array $userData): User|null
    {
        return $this->userModel->create($userData);
    }

}
