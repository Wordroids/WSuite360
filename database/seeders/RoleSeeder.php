<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'project_manager',
            'developer',
            'employee',
            'guest',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
