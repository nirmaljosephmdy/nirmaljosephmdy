<?php

namespace App\Enums;

enum DocumentStatus: int
{
    case Pending = 1;
    case Accepted = 2;
    case Rejected = 3;
}
