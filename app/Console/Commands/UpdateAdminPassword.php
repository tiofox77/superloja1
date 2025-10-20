<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAdminPassword extends Command
{
    protected $signature = 'admin:update-password 
                            {email=admin@superloja.ao : Email do administrador}
                            {password=Admin2017 : Nova senha}';

    protected $description = 'Atualizar senha do administrador';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $admin = User::where('email', $email)->first();

        if (!$admin) {
            $this->error("❌ Usuário com email {$email} não encontrado!");
            return self::FAILURE;
        }

        $admin->update([
            'password' => Hash::make($password),
        ]);

        $this->info("✅ Senha atualizada com sucesso!");
        $this->line("📧 Email: {$email}");
        $this->line("🔑 Nova senha: {$password}");

        return self::SUCCESS;
    }
}
