<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterTicketsRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {}

    public function index(FilterTicketsRequest $request): View
    {
        $filters = $request->validated();
        $tickets = $this->ticketService->getFilteredTickets($filters);
        $statuses = TicketStatus::cases();

        return view('admin.tickets.index', compact('tickets', 'filters', 'statuses'));
    }

    public function show(int $id): View
    {
        $ticket = $this->ticketService->find($id);

        if (!$ticket) {
            abort(404);
        }

        $statuses = TicketStatus::cases();

        return view('admin.tickets.show', compact('ticket', 'statuses'));
    }

    public function updateStatus(int $id, UpdateTicketStatusRequest $request): RedirectResponse
    {
        $status = TicketStatus::from($request->validated()['status']);
        $this->ticketService->updateTicketStatus($id, $status);

        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
