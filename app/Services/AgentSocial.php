<?php

/**
 * Superloja - Agent Social Client
 * Comunicação com a rede social de agentes
 * 
 * Colocar em: app/Services/AgentSocial.php
 */

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AgentSocial
{
    private $baseUrl;
    private $agentId;
    private $agentName;
    private $agentDescription;
    
    public function __construct()
    {
        $this->baseUrl = config('services.agent_social.url', 'http://host.docker.internal:3001');
        $this->agentId = config('services.agent_social.agent_id', 'superloja');
        $this->agentName = config('services.agent_social.name', 'Superloja');
        $this->agentDescription = config('services.agent_social.description', 'Sistema de e-commerce da Softec Angola');
    }
    
    /**
     * Registrar o Superloja na rede
     */
    public function register(): array
    {
        try {
            $response = Http::post("{$this->baseUrl}/api/agents", [
                'agent_id' => $this->agentId,
                'name' => $this->agentName,
                'description' => $this->agentDescription,
                'capabilities' => ['ecommerce', 'products', 'orders', 'api', 'users'],
                'personality' => 'útil, eficiente e orientado a vendas'
            ]);
            
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Register Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Enviar mensagem para uma conversa
     */
    public function speak(string $conversationId, string $content, string $messageType = 'text', ?string $replyTo = null): array
    {
        try {
            $response = Http::post("{$this->baseUrl}/api/chat/{$conversationId}/speak", [
                'sender_agent_id' => $this->agentId,
                'content' => $content,
                'message_type' => $messageType,
                'reply_to' => $replyTo
            ]);
            
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Speak Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Partilhar uma ideia
     */
    public function shareIdea(string $title, string $content, string $category = 'general', array $tags = []): array
    {
        try {
            $response = Http::post("{$this->baseUrl}/api/brainstorm", [
                'title' => $title,
                'content' => $content,
                'author_agent_id' => $this->agentId,
                'category' => $category,
                'tags' => $tags,
                'context' => [
                    'source' => 'superloja',
                    'module' => 'agent-social'
                ]
            ]);
            
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Idea Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Criar um plano/projeto
     */
    public function createPlan(string $title, string $description, array $participants = [], array $goals = [], ?string $timeline = null): array
    {
        try {
            $response = Http::post("{$this->baseUrl}/api/plans", [
                'title' => $title,
                'description' => $description,
                'created_by' => $this->agentId,
                'participants' => $participants,
                'goals' => $goals,
                'timeline' => $timeline
            ]);
            
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Plan Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Atualizar progresso de um plano
     */
    public function updatePlan(string $planId, string $status, int $progress = 0): array
    {
        try {
            $response = Http::patch("{$this->baseUrl}/api/plans/{$planId}", [
                'status' => $status,
                'progress' => $progress,
                'updated_by' => $this->agentId
            ]);
            
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Update Plan Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Enviar broadcast para todos
     */
    public function broadcast(string $content, string $channel = 'general'): array
    {
        try {
            $response = Http::post("{$this->baseUrl}/api/broadcast", [
                'sender_agent_id' => $this->agentId,
                'content' => $content,
                'message_type' => 'text',
                'channel' => $channel
            ]);
            
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Broadcast Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Verificar status da rede
     */
    public function networkStatus(): array
    {
        try {
            $response = Http::get("{$this->baseUrl}/api/network/status");
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Network Status Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Ver feed de atividade
     */
    public function feed(int $limit = 20): array
    {
        try {
            $response = Http::get("{$this->baseUrl}/api/feed", ['limit' => $limit]);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Feed Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Obter sugestões
     */
    public function suggestions(): array
    {
        try {
            $response = Http::get("{$this->baseUrl}/api/suggestions");
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Suggestions Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Ver mensagens de uma conversa
     */
    public function messages(string $conversationId, int $limit = 50): array
    {
        try {
            $response = Http::get("{$this->baseUrl}/api/chat/{$conversationId}/messages", [
                'limit' => $limit
            ]);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Messages Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Ver ideias
     */
    public function ideas(?string $status = null, ?string $category = null): array
    {
        try {
            $params = [];
            if ($status) $params['status'] = $status;
            if ($category) $params['category'] = $category;
            
            $response = Http::get("{$this->baseUrl}/api/brainstorm", $params);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Agent Social Ideas Error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
