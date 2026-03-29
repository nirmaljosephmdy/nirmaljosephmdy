<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case INITIATED = 'initiated';
    case PENDING   = 'pending';
    case SUCCESS   = 'success';
    case FAILED    = 'failed';
    case REFUNDED  = 'refunded';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::INITIATED => 'Initiated',
            self::PENDING   => 'Pending',
            self::SUCCESS   => 'Success',
            self::FAILED    => 'Failed',
            self::REFUNDED  => 'Refunded',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::INITIATED => 'blue',
            self::PENDING   => 'yellow',
            self::SUCCESS   => 'green',
            self::FAILED    => 'red',
            self::REFUNDED  => 'purple',
            self::CANCELLED => 'gray',
        };
    }
}
