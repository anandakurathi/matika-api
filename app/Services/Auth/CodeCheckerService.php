<?php

namespace App\Services\Auth;

use App\Helpers\Encryption;
use App\Repositories\Auth\CodeCheckerRepository;
use App\Traits\AuthResponseTrait;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CodeCheckerService
{
    use AuthResponseTrait;

    protected CodeCheckerRepository $codeCheckerRepository;

    public function __construct(CodeCheckerRepository $codeCheckerRepository)
    {
        $this->codeCheckerRepository = $codeCheckerRepository;
    }

    public function check($request)
    {
        $checkCode = $this->codeCheckerRepository->getCodeByEmail($request['email']);
        if (!$checkCode) {
            return $this->respondWithError(trans('passwords.invalidCode'));
        }

        $code = Encryption::decrypt($checkCode->code);
        if ($code !== $request['code']) {
            return $this->respondWithError(trans('passwords.invalidCode'));
        }

        // check if it does not expired: the time is one hour
        if ($checkCode->created_at > now()->addHour()) {
            $this->codeCheckerRepository->deleteCode($request['email']);
            return $this->respondWithError(trans('passwords.codeIsExpire'));
        }

        $user = $this->codeCheckerRepository->getUserByEmail($request['email']);

        // old and new password match
        if(Hash::check($request['password'], $user->password)) {
            return $this->respondWithError(trans('passwords.same'));
        }

        $this->codeCheckerRepository->updatePassword($user, $request['password']);

        $this->codeCheckerRepository->deleteCode($request['email']);

        return [
            'message' => trans('passwords.updated'),
            'code' => ResponseAlias::HTTP_OK,
        ];
    }
}
