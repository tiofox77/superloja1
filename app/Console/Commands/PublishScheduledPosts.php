<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SocialMediaAgentService;

class PublishScheduledPosts extends Command
{
    protected $signature = 'ai:publish-posts';

    protected $description = 'Publicar posts agendados no Facebook e Instagram';

    public function handle(SocialMediaAgentService $socialMediaAgent): int
    {
        $this->info('📱 Verificando posts agendados...');

        $published = $socialMediaAgent->publishPendingPosts();

        if ($published > 0) {
            $this->info("✅ {$published} post(s) publicado(s) com sucesso!");
        } else {
            $this->info("ℹ️ Nenhum post pendente para publicar.");
        }

        return self::SUCCESS;
    }
}
