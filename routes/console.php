<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Publicar posts agendados automaticamente a cada minuto
Schedule::command('ai:publish-posts')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();

// Analisar produtos automaticamente 1x por dia (2h da madrugada)
Schedule::command('ai:analyze-products')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->runInBackground();

// Criar posts automaticamente de 3 em 3 horas
Schedule::command('ai:auto-create-posts')
    ->cron('0 */3 * * *')  // A cada 3 horas (0h, 3h, 6h, 9h, 12h, 15h, 18h, 21h)
    ->withoutOverlapping()
    ->runInBackground();

// Calcular métricas da IA de 4 em 4 horas
Schedule::command('ai:calculate-metrics')
    ->cron('0 */4 * * *')  // A cada 4 horas (0h, 4h, 8h, 12h, 16h, 20h)
    ->withoutOverlapping()
    ->runInBackground();
