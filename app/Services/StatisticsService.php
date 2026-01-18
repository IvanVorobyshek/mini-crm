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
        return [];
    }

    public function getWeeklyStatistics(): array
    {
        return [];
    }

    public function getMonthlyStatistics(): array
    {
        return [];
    }
}