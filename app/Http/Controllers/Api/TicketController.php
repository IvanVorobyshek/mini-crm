<?php

namespace App\Http\Controllers\Api;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use Exception;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function __construct(
        private readonly TicketService $ticketService,
    ) {}

    public function store(CreateTicketRequest $request): JsonResponse
    {
        try {
            $ticket = $this->ticketService->createTicket($request->validated());

            return (new TicketResource($ticket))
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create ticket',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    public function updateStatus(int $id, UpdateTicketStatusRequest $request): JsonResponse
    {
        try {
            $status = TicketStatus::from($request->validated()['status']);

            $result = $this->ticketService->updateTicketStatus($id, $status);

            if (!$result) {
                return response()->json(['message' => 'Ticket not found'], 404);
            }

            return response()->json(['message' => 'Status updated successfully']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update status',
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}
