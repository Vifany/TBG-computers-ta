<?php

namespace App\Types;

enum AddressType: string
{

    case TELEGRAM = 'tg';
    case EMAIL = 'email';

    public function description(): string
    {
        return match ($this) {
            self::TELEGRAM => 'Telegram ID',
            self::EMAIL => 'Email address',
        };
    }
}
