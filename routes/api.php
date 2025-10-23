<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Webhooks públicos (sem autenticação)
Route::prefix('webhooks')->name('webhooks.')->group(function () {
    Route::match(['get', 'post'], '/facebook', [App\Http\Controllers\Admin\AiAgentWebhookController::class, 'facebookWebhook'])->name('facebook');
    Route::match(['get', 'post'], '/instagram', [App\Http\Controllers\Admin\AiAgentWebhookController::class, 'instagramWebhook'])->name('instagram');
    
    // Rota de teste para verificar configuração
    Route::get('/test', function () {
        $fbToken = \App\Models\SystemConfig::get('facebook_verify_token');
        $igToken = \App\Models\SystemConfig::get('instagram_verify_token');
        
        return response()->json([
            'status' => 'ok',
            'facebook_webhook' => url('api/webhooks/facebook'),
            'instagram_webhook' => url('api/webhooks/instagram'),
            'facebook_token_configured' => !empty($fbToken),
            'instagram_token_configured' => !empty($igToken),
            'info' => 'Use GET com ?hub.mode=subscribe&hub.verify_token=SEU_TOKEN&hub.challenge=12345 para testar',
        ]);
    })->name('test');
});

// Cron Triggers via API (para n8n, Zapier, etc)
Route::prefix('cron')->name('cron.')->group(function () {
    Route::match(['get', 'post'], '/trigger-posts', [App\Http\Controllers\Api\CronTriggerController::class, 'triggerPosts'])->name('trigger-posts');
    Route::match(['get', 'post'], '/trigger-analysis', [App\Http\Controllers\Api\CronTriggerController::class, 'triggerAnalysis'])->name('trigger-analysis');
    Route::match(['get', 'post'], '/trigger-create-posts', [App\Http\Controllers\Api\CronTriggerController::class, 'triggerCreatePosts'])->name('trigger-create-posts');
    Route::match(['get', 'post'], '/trigger-create-carousels', [App\Http\Controllers\Api\CronTriggerController::class, 'triggerCreateCarousels'])->name('trigger-create-carousels');
    Route::get('/status', [App\Http\Controllers\Api\CronTriggerController::class, 'status'])->name('status');
});
