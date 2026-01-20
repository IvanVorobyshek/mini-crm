<?php

namespace App\Repositories;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepositoryInterface;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository implements TicketRepositoryInterface
{
    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function find(int $id): ?Ticket
    {
        return Ticket::with('customer')->find($id);
    }

    public function getAll(): Collection
    {
        return Ticket::with('customer')->get();
    }

    public function updateStatus(Ticket $ticket, TicketStatus $status): bool
    {
        return $ticket->update(['status' => $status]);
    }

    public function getFiltered(array $filters): Collection
    {
        $query = Ticket::with('customer');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['email'])) {
            $query->whereHas('customer', function($q) use ($filters) {
                $q->where('email', $filters['email']);
            });
        }

        if (!empty($filters['phone'])) {
            $query->whereHas('customer', function($q) use ($filters) {
                $q->where('phone', $filters['phone']);
            });
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getByDateRange(DateTime $startDate, DateTime $endDate): Collection
    {
        return Ticket::with('customer')->whereBetween('created_at', [$startDate, $endDate])->get();
    }

    public function countByStatus(TicketStatus $status): int
    {
        return Ticket::where('status', $status)->count();
    }
}