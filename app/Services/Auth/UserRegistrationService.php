<?php

namespace App\Services\Auth;

use App\Repositories\Auth\UserRegistrationRepository;
use App\Traits\AuthResponseTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

use function Psy\debug;

class UserRegistrationService
{
    use AuthResponseTrait;
    protected UserRegistrationRepository $userRegistrationRepository;

    public function __construct(UserRegistrationRepository $userRegistrationRepository)
    {
        $this->userRegistrationRepository = $userRegistrationRepository;
    }

    /**
     * @param $user
     * @return array
     */
    public function register($user): array
    {
        if ($this->userRegistrationRepository->isEmailUnique($user['email'])) {
            $user['password'] = Hash::make($user['password']);
            $user = $this->userRegistrationRepository->createUser($user);
            if ($user) {
                // trigger new use registration event
                event(new Registered($user));

                // mark user logged in
                // Auth::login($user);

                return $this->respondedWithToken($user, __('auth.register.success'), ResponseAlias::HTTP_CREATED);
            }

            return $this->respondWithError(__('auth.register.failure'));
        }

        // Handel duplicate case
        return $this->respondWithError(__('auth.register.duplicate'));
    }
}
