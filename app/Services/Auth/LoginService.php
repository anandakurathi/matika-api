<?php

namespace App\Services\Auth;


use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Auth\LoginRepository;
use App\Traits\AuthResponseTrait;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LoginService
{
    use AuthResponseTrait;

    private LoginRepository $loginRepository;

    public function __construct(LoginRepository $loginRepository)
    {
        $this->loginRepository = $loginRepository;
    }

    /**
     */
    public function login(LoginRequest $request): array
    {
        $user = $this->loginRepository->checkUser($request->email);
        if ($user) {
            // mark user logged in
            // Auth::login($user);

            return $this->respondedWithToken(
                $user,
                __('auth.login.success', ['name' => $user->name]),
                ResponseAlias::HTTP_CREATED
            );
        }

        return $this->respondWithError(__('auth.login.failure'));
    }
}
