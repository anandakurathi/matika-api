<?php

namespace App\Repositories\Auth;

use App\Models\PasswordResetCodes;

class PasswordRestRepository
{

    public function insertResetCode($data)
    {
        // Create a new code
        return PasswordResetCodes::insert([
            'email' => $data['email'],
            'code' => $data['code'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

}
