<?php

namespace App\Http\Resources;

use App\Enums\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $byStatus = [];
        foreach (TicketStatus::cases() as $status) {
            $byStatus[$status->value] = $this->resource[$status->value] ?? 0;
        }
        
        return [
            'total' => $this->resource['total'],
            'by_status' => $byStatus,
            'period' => $this->resource['period'],
        ];
    }
}
