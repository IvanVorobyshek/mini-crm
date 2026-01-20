<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TicketRepositoryInterface;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository
    ) {}

    public function index(): View
    {
        $totalTickets = $this->ticketRepository->getAll()->count();
        $newTickets = $this->ticketRepository->countByStatus(TicketStatus::NEW);
        $inProgressTickets = $this->ticketRepository->countByStatus(TicketStatus::PROCESSING);
        $completedTickets = $this->ticketRepository->countByStatus(TicketStatus::COMPLETED);

        return view('admin.dashboard', compact(
            'totalTickets',
            'newTickets',
            'inProgressTickets',
            'completedTickets'
        ));
    }
}