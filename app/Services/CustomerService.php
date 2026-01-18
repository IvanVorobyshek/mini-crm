<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
    ) {}

    public function canCreateTicket(Customer $customer): bool
    {
        return !$this->customerRepository->hasRecentTicket($customer, 24);
    }
}