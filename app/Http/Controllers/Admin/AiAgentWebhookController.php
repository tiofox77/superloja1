<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SocialMediaAgentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AiAgentWebhookController extends Controller
{
    private SocialMediaAgentService $socialMediaAgent;

    public function __construct(SocialMediaAgentService $socialMediaAgent)
    {
        $this->socialMediaAgent = $socialMediaAgent;
    }

    /**
     * Webhook do Facebook Messenger
     */
    public function facebookWebhook(Request $request)
    {
        // Verificação do webhook (Facebook exige isso na configuração)
        if ($request->has('hub_mode') && $request->get('hub_mode') === 'subscribe') {
            $token = $request->get('hub_verify_token');
            $challenge = $request->get('hub_challenge');

            Log::info('Facebook Webhook - Verificacao', [
                'token_recebido' => $token,
                'challenge' => $challenge,
                'mode' => $request->get('hub_mode')
            ]);

            // Token de verificação (buscar do banco de dados)
            $storedToken = \App\Models\SystemConfig::get('facebook_verify_token');
            
            Log::info('Facebook Webhook - Token armazenado', [
                'stored_token' => $storedToken ? 'configurado' : 'vazio',
                'match' => $token === $storedToken
            ]);
            
            if ($token === $storedToken) {
                // Retornar APENAS o challenge (texto puro, sem headers HTML)
                return response($challenge, 200)
                    ->header('Content-Type', 'text/plain');
            }

            Log::error('Facebook Webhook - Token invalido', [
                'token_recebido' => $token,
                'token_esperado_existe' => !empty($storedToken)
            ]);

            return response('Token inválido', 403)
                ->header('Content-Type', 'text/plain');
        }

        // Processar mensagens recebidas
        try {
            $data = $request->all();
            Log::info('Facebook Webhook recebido', $data);

            $this->socialMediaAgent->processWebhook($data, 'facebook');

            return response()->json(['status' => 'ok'], 200);
        } catch (\Exception $e) {
            Log::error('Erro no webhook Facebook: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao processar'], 500);
        }
    }

    /**
     * Webhook do Instagram
     */
    public function instagramWebhook(Request $request)
    {
        // Verificação do webhook
        if ($request->has('hub_mode') && $request->get('hub_mode') === 'subscribe') {
            $token = $request->get('hub_verify_token');
            $challenge = $request->get('hub_challenge');

            Log::info('Instagram Webhook - Verificacao', [
                'token_recebido' => $token,
                'challenge' => $challenge,
                'mode' => $request->get('hub_mode')
            ]);

            // Token de verificação (buscar do banco de dados)
            $storedToken = \App\Models\SystemConfig::get('instagram_verify_token');
            
            Log::info('Instagram Webhook - Token armazenado', [
                'stored_token' => $storedToken ? 'configurado' : 'vazio',
                'match' => $token === $storedToken
            ]);
            
            if ($token === $storedToken) {
                // Retornar APENAS o challenge (texto puro, sem headers HTML)
                return response($challenge, 200)
                    ->header('Content-Type', 'text/plain');
            }

            Log::error('Instagram Webhook - Token invalido', [
                'token_recebido' => $token,
                'token_esperado_existe' => !empty($storedToken)
            ]);

            return response('Token inválido', 403)
                ->header('Content-Type', 'text/plain');
        }

        // Processar mensagens recebidas
        try {
            $data = $request->all();
            Log::info('Instagram Webhook recebido', $data);

            $this->socialMediaAgent->processWebhook($data, 'instagram');

            return response()->json(['status' => 'ok'], 200);
        } catch (\Exception $e) {
            Log::error('Erro no webhook Instagram: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao processar'], 500);
        }
    }
}
