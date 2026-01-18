<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function findByPhone(string $phone): ?Customer
    {
        return Customer::where('phone', $phone)->first();
    }

    public function findByEmail(string $email): ?Customer
    {
        return Customer::where('email', $email)->first();
    }

    public function hasRecentTicket(string $phone, int $hours = 24): bool
    {
        $customer = $this->findByPhone($phone);

        if (!$customer) {
            return false;
        }

        return $customer->tickets()->where('created_at', '>=', now()->subHours($hours))->exists();
    }
}