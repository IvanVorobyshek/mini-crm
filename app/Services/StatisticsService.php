<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Carbon\Carbon;

class StatisticsService
{
    public function getDailyStatistics(): array
    {
        return $this->getStatisticsByScope('today');
    }

    public function getWeeklyStatistics(): array
    {
        return $this->getStatisticsByScope('thisWeek');
    }

    public function getMonthlyStatistics(): array
    {
        return $this->getStatisticsByScope('thisMonth');
    }

    private function getStatisticsByScope(string $scopeName): array
    {
        $query = Ticket::$scopeName();

        $byStatus = [];
        foreach (TicketStatus::cases() as $status) {
            $byStatus[$status->value] = (clone $query)->byStatus($status)->count();
        }

        $period = $this->getPeriodDates($scopeName);

        return [
            'total' => $query->count(),
            ...$byStatus,
            'period' => $period,
        ];
    }

    private function getPeriodDates(string $scopeName): array
    {
        return match($scopeName) {
            'today' => [
                'start' => Carbon::today()->format('Y-m-d H:i:s'),
                'end' => Carbon::tomorrow()->format('Y-m-d H:i:s'),
            ],
            'thisWeek' => [
                'start' => Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
                'end' => Carbon::now()->endOfWeek()->format('Y-m-d H:i:s'),
            ],
            'thisMonth' => [
                'start' => Carbon::now()->startOfMonth()->format('Y-m-d H:i:s'),
                'end' => Carbon::now()->endOfMonth()->format('Y-m-d H:i:s'),
            ],
            default => [],
        };
    }
}