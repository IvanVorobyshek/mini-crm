<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'subject' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => TicketStatus::NEW,
            'manager_responded_at' => null,
        ];
    }
}
