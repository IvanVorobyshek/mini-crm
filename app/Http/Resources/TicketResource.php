<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer' => [
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
                'email' => $this->customer->email,
            ],
            'subject' => $this->subject,
            'description' => $this->description,
            'status' => $this->status->value,
            'manager_responded_at' => $this->manager_responded_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'files' => $this->getMedia('attachments')->map(fn($media) => [
                'id' => $media->id,
                'name' => $media->file_name,
                'url' => $media->getUrl(),
                'size' => $media->size,
            ]),
        ];
    }
}
