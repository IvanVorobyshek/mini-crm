<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Exceptions\CustomerNotFoundException;
use App\Exceptions\RateLimitExceededException;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\TicketRepositoryInterface;
use App\Services\CustomerService;
use Illuminate\Database\Eloquent\Collection;

class TicketService
{
    public function __construct(
        private readonly TicketRepositoryInterface $ticketRepository,
        private readonly CustomerRepositoryInterface $customerRepository,
        private readonly CustomerService $customerService,
    ) {}

    public function createTicket(array $data): Ticket
    {
        $customer = $this->customerRepository->findByPhone($data['phone']);

        if (!$customer) {
            throw new CustomerNotFoundException($data['phone']);
        }

        if (!$this->customerService->canCreateTicket($customer)) {
            throw new RateLimitExceededException('You can only submit one ticket per 24 hours');
        }

        $ticket = $this->ticketRepository->create([
            'customer_id' => $customer->id,
            'subject' => $data['subject'],
            'description' => $data['description'],
            'status' => 'new',
        ]);

        if (!empty($data['files'])) {
            foreach ($data['files'] as $file) {
                $ticket->addMedia($file)->toMediaCollection('attachments');
            }
        }

        return $ticket;
    }

    public function updateTicketStatus(int $ticketId, TicketStatus $status): bool
    {
        $ticket = $this->ticketRepository->find($ticketId);
        
        if (!$ticket) {
            return false;
        }

        $result = $this->ticketRepository->updateStatus($ticket, $status);

        if ($result && in_array($status, ['in_progress', 'completed'])) {
            $ticket->update(['manager_responded_at' => now()]);
        }

        return $result;
    }
}