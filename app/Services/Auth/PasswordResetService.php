<?php

namespace App\Services\Auth;

use App\Events\PasswordResetCode as PasswordResetCodeEvent;
use App\Helpers\Encryption;
use App\Models\PasswordResetCodes;
use App\Repositories\Auth\PasswordRestRepository;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PasswordResetService
{

    protected PasswordRestRepository $passwordResetRepository;
    public function __construct(PasswordRestRepository $passwordResetRepository){
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * @throws RandomException
     */
    public function sendPasswordResetCode($request): array
    {
        // Delete all old code that user send before.
        PasswordResetCodes::where('email', $request['email'])->delete();

        // Generate random code
        $codes = $this->generateCode();
        $request['code'] = $codes['encrypted'];

        // Create a new code
        $this->passwordResetRepository->insertResetCode($request);

        //for email override the code
        $request['code'] = $codes['code'];
        event(new PasswordResetCodeEvent((object) $request));

        return [
            'code' => ResponseAlias::HTTP_CREATED,
            'message' => __('passwords.code.sent'),
        ];
    }

    /**
     * @throws RandomException
     */
    public function generateCode(): array
    {
        // Generate random code
        $code = random_int(100000, 999999);
        return [
            'code' => $code,
            'encrypted' => Encryption::encrypt($code)
        ];
    }

}
