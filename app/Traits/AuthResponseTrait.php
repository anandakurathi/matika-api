<?php

namespace App\Traits;

use App\Models\User;
use Hashids\Hashids;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Auth Response Trait
 *
 * Used for common response for Auth
 */
trait AuthResponseTrait
{
    /**
     * Response for Success case token
     *
     * @param User|null $user
     * @param string $message
     * @param int $code
     * @return array{'message': string, 'user': array, 'token': string, 'code': int}
     */
    public function respondedWithToken(?User $user, string $message = '', int $code = ResponseAlias::HTTP_OK): array
    {
        $hashids = new Hashids(env('HASH_KEY'), 16);
        $hashId = $hashids->encode($user->id);
        $token = $user->createToken($hashId)->plainTextToken;

        $user = $user->toArray();
        $user['id'] = $hashId;

        return [
            'message' => $message,
            'user' => $user,
            'token' => $token,
            'code' => $code
        ];
    }

    /**
     * Response for Error
     *
     * @param string $message
     * @param int $code
     * @return array{'message': string, 'code': int}
     */
    public function respondWithError(string $message = '', int $code = ResponseAlias::HTTP_BAD_REQUEST): array
    {
        return [
            'message' => $message,
            'code' => $code
        ];
    }
}
