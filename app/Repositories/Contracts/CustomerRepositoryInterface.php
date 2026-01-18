<?php

namespace App\Repositories\Contracts;

use App\Models\Customer;

interface CustomerRepositoryInterface
{
    public function findByPhone(string $phone): ?Customer;
    public function findByEmail(string $email): ?Customer;
    public function hasRecentTicket(Customer $customer, int $hours = 24): bool;
    // other methods (like create, delete, etc.) are not needed for this task
}