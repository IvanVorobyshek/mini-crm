<?php

namespace Database\Seeders;

use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\TicketSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
