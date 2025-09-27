<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin principal
        User::create([
            'name' => 'SuperLoja Admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@superloja.ao',
            'phone' => '+244 900 000 001',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
            'city' => 'Luanda',
            'province' => 'Luanda',
            'country' => 'Angola'
        ]);

        // Manager de exemplo
        User::create([
            'name' => 'João Silva',
            'first_name' => 'João',
            'last_name' => 'Silva',
            'email' => 'manager@superloja.ao',
            'phone' => '+244 900 000 002',
            'password' => Hash::make('manager123'),
            'role' => 'manager',
            'is_active' => true,
            'email_verified_at' => now(),
            'city' => 'Luanda',
            'province' => 'Luanda',
            'country' => 'Angola'
        ]);

        // Cliente de teste
        User::create([
            'name' => 'Maria Santos',
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'email' => 'cliente@exemplo.ao',
            'phone' => '+244 900 000 003',
            'password' => Hash::make('cliente123'),
            'role' => 'customer',
            'is_active' => true,
            'email_verified_at' => now(),
            'newsletter_subscribed' => true,
            'city' => 'Benguela',
            'province' => 'Benguela',
            'country' => 'Angola'
        ]);
    }
}
