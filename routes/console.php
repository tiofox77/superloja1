<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Publicar posts agendados automaticamente a cada minuto
Schedule::command('ai:publish-posts')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground()
    ->before(function () {
        Log::channel('cron')->info('🚀 Iniciando: ai:publish-posts');
    })
    ->after(function () {
        Log::channel('cron')->info('✅ Finalizado: ai:publish-posts');
    })
    ->onFailure(function () {
        Log::channel('cron')->error('❌ FALHOU: ai:publish-posts');
    });

// Analisar produtos automaticamente 1x por dia (2h da madrugada)
Schedule::command('ai:analyze-products')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->before(function () {
        Log::channel('cron')->info('🚀 Iniciando: ai:analyze-products');
    })
    ->after(function () {
        Log::channel('cron')->info('✅ Finalizado: ai:analyze-products');
    })
    ->onFailure(function () {
        Log::channel('cron')->error('❌ FALHOU: ai:analyze-products');
    });

// Criar posts automaticamente - FACEBOOK (horas pares: 0h, 6h, 12h, 18h)
Schedule::command('ai:auto-create-posts --platform=facebook')
    ->cron('0 */6 * * *')
    ->withoutOverlapping()
    ->runInBackground()
    ->before(function () {
        Log::channel('cron')->info('🚀 Iniciando: ai:auto-create-posts (Facebook)');
    })
    ->after(function () {
        Log::channel('cron')->info('✅ Finalizado: ai:auto-create-posts (Facebook)');
    })
    ->onFailure(function () {
        Log::channel('cron')->error('❌ FALHOU: ai:auto-create-posts (Facebook)');
    });

// Criar posts automaticamente - INSTAGRAM (horas ímpares: 3h, 9h, 15h, 21h)
Schedule::command('ai:auto-create-posts --platform=instagram')
    ->cron('0 3-21/6 * * *')
    ->withoutOverlapping()
    ->runInBackground()
    ->before(function () {
        Log::channel('cron')->info('🚀 Iniciando: ai:auto-create-posts (Instagram)');
    })
    ->after(function () {
        Log::channel('cron')->info('✅ Finalizado: ai:auto-create-posts (Instagram)');
    })
    ->onFailure(function () {
        Log::channel('cron')->error('❌ FALHOU: ai:auto-create-posts (Instagram)');
    });

// Criar CARROSSEL de produtos - FACEBOOK (diariamente ao meio-dia)
Schedule::command('ai:auto-create-carousels --count=1 --products=8 --platform=facebook')
    ->dailyAt('12:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->before(function () {
        Log::channel('cron')->info('🚀 Iniciando: ai:auto-create-carousels (Facebook)');
    })
    ->after(function () {
        Log::channel('cron')->info('✅ Finalizado: ai:auto-create-carousels (Facebook)');
    })
    ->onFailure(function () {
        Log::channel('cron')->error('❌ FALHOU: ai:auto-create-carousels (Facebook)');
    });

// Criar CARROSSEL de produtos - INSTAGRAM (diariamente às 19h)
Schedule::command('ai:auto-create-carousels --count=1 --products=8 --platform=instagram')
    ->dailyAt('19:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->before(function () {
        Log::channel('cron')->info('🚀 Iniciando: ai:auto-create-carousels (Instagram)');
    })
    ->after(function () {
        Log::channel('cron')->info('✅ Finalizado: ai:auto-create-carousels (Instagram)');
    })
    ->onFailure(function () {
        Log::channel('cron')->error('❌ FALHOU: ai:auto-create-carousels (Instagram)');
    });

// Calcular métricas da IA de 4 em 4 horas
Schedule::command('ai:calculate-metrics')
    ->cron('0 */4 * * *')  // A cada 4 horas (0h, 4h, 8h, 12h, 16h, 20h)
    ->withoutOverlapping()
    ->runInBackground()
    ->before(function () {
        Log::channel('cron')->info('🚀 Iniciando: ai:calculate-metrics');
    })
    ->after(function () {
        Log::channel('cron')->info('✅ Finalizado: ai:calculate-metrics');
    })
    ->onFailure(function () {
        Log::channel('cron')->error('❌ FALHOU: ai:calculate-metrics');
    });
