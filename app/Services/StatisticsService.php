<?php

namespace App\Services;

use App\Repositories\Contracts\TicketRepositoryInterface;

class StatisticsService
{
    public function __construct(
        private readonly TicketRepositoryInterface $ticketRepository,
    ) {}

    public function getDailyStatistics(): array
    {
        return [
            'total' => 0,
            'period' => 'day',
        ];
    }

    public function getWeeklyStatistics(): array
    {
        return [
            'total' => 0,
            'period' => 'week',
        ];
    }

    public function getMonthlyStatistics(): array
    {
        return [
            'total' => 0,
            'period' => 'month',
        ];
    }
}