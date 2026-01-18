<?php

namespace App\Repositories;

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

    public function updateStatus(Ticket $ticket, string $status): bool
    {
        return $ticket->update(['status' => $status]);
    }

    public function getFiltered(array $filters): Collection
    {
        return Ticket::with('customer')->where($filters)->get();
    }

    public function getByDateRange(DateTime $startDate, DateTime $endDate): Collection
    {
        return Ticket::with('customer')->whereBetween('created_at', [$startDate, $endDate])->get();
    }

    public function countByStatus(string $status): int
    {
        return Ticket::where('status', $status)->count();
    }
}