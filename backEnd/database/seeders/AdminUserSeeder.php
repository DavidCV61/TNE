<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::create([
            'name'     => 'Bruce Wayne',
            'email'    => 'batman@email.com',
            'password' => Hash::make('batman1234'),
            'role_id'  => $adminRole->id,
        ]);
    }
}
