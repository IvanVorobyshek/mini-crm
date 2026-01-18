<?php

namespace App\Enums;

enum TicketStatus: string
{
    case NEW = 'new';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
