<?php

namespace App\Enums;

enum Status: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Deleted = 'deleted'; // This cannot be activated again
}
