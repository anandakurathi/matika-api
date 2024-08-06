<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
final class Encryption
{
    public static function encrypt($string): string
    {
        return Crypt::encryptString($string);
    }

    public static function decrypt($string): string
    {
        return Crypt::decryptString($string);
    }
}
