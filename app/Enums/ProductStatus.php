<?php

namespace App\Enums;

enum ProductStatus: int
{
    case Draft = 1;
    case InReview = 2;
    case Compliant = 3;
    case Incompliant = 4;
    case Rejected = 5;
}
