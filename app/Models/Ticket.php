<?php

namespace App\Models;

use App\Enums\TicketStatus;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['customer_id', 'subject', 'description', 'status', 'manager_responded_at'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    protected function casts(): array
    {
        return [
            'status' => TicketStatus::class,
            'manager_responded_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')->useDisk('public');
    }

    public function scopeByStatus(Builder $query, TicketStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeCreatedBetween(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeByCustomerEmail(Builder $query, string $email): Builder
    {
        return $query->whereHas('customer', function ($q) use ($email) {
            $q->where('email', $email);
        });
    }

    public function scopeByCustomerPhone(Builder $query, string $phone): Builder
    {
        return $query->whereHas('customer', function ($q) use ($phone) {
            $q->where('phone', $phone);
        });
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ]);
    }
}
