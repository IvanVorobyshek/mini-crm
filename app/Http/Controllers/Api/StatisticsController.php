<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatisticsResource;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __construct(
        private StatisticsService $statisticsService
    ) {}

    public function index(Request $request): StatisticsResource
    {
        $period = $request->query('period', 'day');

        $statistics = match ($period) {
            'week' => $this->statisticsService->getWeeklyStatistics(),
            'month' => $this->statisticsService->getMonthlyStatistics(),
            default => $this->statisticsService->getDailyStatistics(),
        };

        return new StatisticsResource($statistics);
    }
}