<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAdminPasswordSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@superloja.vip')->first();

        if ($admin) {
            $admin->update([
                'password' => Hash::make('Admin2017'),
            ]);

            $this->command->info('✅ Senha do admin@superloja.vip atualizada para: Admin2017');
        } else {
            // Criar admin se não existir
            User::create([
                'name' => 'Administrador',
                'first_name' => 'Admin',
                'last_name' => 'SuperLoja',
                'email' => 'admin@superloja.vip',
                'password' => Hash::make('Admin2017'),
                'role' => 'admin',
                'is_admin' => true,
                'is_active' => true,
                'phone' => '+244 939 729 902',
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin criado com email: admin@superloja.vip e senha: Admin2017');
        }
    }
}
