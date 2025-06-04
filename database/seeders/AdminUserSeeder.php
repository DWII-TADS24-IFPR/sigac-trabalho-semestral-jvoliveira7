<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'administrador1@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin1234'),
                'is_admin' => true,
            ]
        );
    }
}
