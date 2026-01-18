<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => UserRole::ADMIN->value]);
        Role::create(['name' => UserRole::MANAGER->value]);
    }
}
