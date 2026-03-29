<?php

namespace App\Enums;

enum SubscriptionStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
    case CANCELLED = 2; // Cancelled but still valid until ends_at
    case EXPIRED = 3;   // Past the ends_at date

    public function label(): string
    {
        return match($this) {
            self::INACTIVE => 'Inactive',
            self::ACTIVE => 'Active',
            self::CANCELLED => 'Cancelled',
            self::EXPIRED => 'Expired',
        };
    }
}
