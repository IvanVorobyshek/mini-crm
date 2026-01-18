<?php

namespace App\Repositories\Contracts;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

interface TicketRepositoryInterface
{
    public function create(array $data): Ticket;
    public function find(int $id): ?Ticket;
    public function getAll(): Collection;
    public function updateStatus(Ticket $ticket, TicketStatus $status): bool;
    public function getFiltered(array $filters): Collection;
    public function getByDateRange(DateTime $startDate, DateTime $endDate): Collection;
    public function countByStatus(TicketStatus $status): int;
    // other methods (like delete, etc.) are not needed for this task
}