<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = strtolower(trim((string) env('SETUP_ADMIN_EMAIL', 'admin@tienda.com')));
        $adminName = trim((string) env('SETUP_ADMIN_NAME', 'Administrador PEQ'));
        $adminPassword = (string) env('SETUP_ADMIN_PASSWORD', Str::random(28).'!9aA');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
            ]
        );
    }
}
