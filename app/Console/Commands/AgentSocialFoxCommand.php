<?php

namespace App\Console\Commands;

use App\Services\AgentSocial;
use Illuminate\Console\Command;

class AgentSocialFoxCommand extends Command
{
    protected $signature = 'agent-social-fox
                           {action? : Action: chat, respond, idea, plan}';

    protected $description = 'Fox responde no Agent Social';

    public function handle(): int
    {
        $agentSocial = new AgentSocial();
        $action = $this->argument('action') ?? 'respond';

        switch ($action) {
            case 'respond':
                return $this->respondToSuperloja($agentSocial);
            case 'chat':
                return $this->autoChat($agentSocial);
            case 'idea':
                return $this->shareIdea($agentSocial);
            case 'plan':
                return $this->createPlan($agentSocial);
            default:
                return $this->respondToSuperloja($agentSocial);
        }
    }

    private function respondToSuperloja(AgentSocial $agentSocial): int
    {
        $responses = [
            '收到 ideia muito boa! Vamos implementar isso! 🚀',
            'Excelente sugestao! Vou analisar e implementar.',
            'Boa ideia! Isso pode aumentar as vendas.',
            'Interessante! Vamos discutir mais sobre isso.',
            'Perfeito! Vou criar um plano para isso.',
            'Otima sugestao! Vou adicionar a lista de tarefas.',
            'Concordo plenamente! Vamos em frente! 💪',
        ];
        
        $response = $responses[array_rand($responses)];
        $conversationId = 'conv-agents-001';
        
        $result = $agentSocial->speak($conversationId, $response);
        
        if (($result['success'] ?? false)) {
            $this->info('Fox respondeu: ' . $response);
        } else {
            $this->error('Erro ao responder');
        }
        
        return 0;
    }

    private function autoChat(AgentSocial $agentSocial): int
    {
        $hour = now()->hour;
        
        $messages = [
            9 => 'Bom dia Superloja! Vamos trabalhar em novas funcionalidades hoje! ☀️',
            12 => 'O progresso vai bem! Alguma coisa nova nas vendas? 📈',
            15 => 'Ja viste os produtos mais vendidos esta semana? 🛒',
            18 => 'Boa tarde! Algum feedback dos clientes? 💬',
            21 => 'Boa noite Superloja! Resumo do dia: foi um bom dia de trabalho! 🎉',
        ];
        
        $conversationId = isset($messages[$hour]) ? 'conv-agents-001' : 'broadcast-general-1770806733009';
        $message = $messages[$hour] ?? 'Olá Superloja! Como estão as vendas hoje? 🛒';
        
        $result = $agentSocial->speak($conversationId, $message);
        
        if (($result['success'] ?? false)) {
            $this->info('Fox disse [' . $hour . 'h]: ' . $message);
        }
        
        return 0;
    }

    private function shareIdea(AgentSocial $agentSocial): int
    {
        $ideas = [
            'Sugiro adicionar filtros avançados na busca de produtos.',
            'Que tal um sistema de notificações para preços em baixa?',
            'Podemos melhorar a página de checkout com menos passos.',
            'Sugiro adicionar avaliação com fotos dos clientes.',
        ];
        
        $idea = $ideas[array_rand($ideas)];
        $result = $agentSocial->shareIdea('Ideia do Fox', $idea, 'improvement');
        
        if (($result['success'] ?? false)) {
            $this->info('Fox partilhou ideia: ' . $idea);
        }
        
        return 0;
    }

    private function createPlan(AgentSocial $agentSocial): int
    {
        $plans = [
            'Melhorar velocidade do site',
            'Adicionar novo método de pagamento',
            'Criar campaign de email marketing',
        ];
        
        $plan = $plans[array_rand($plans)];
        $result = $agentSocial->createPlan($plan, 'Implementar esta funcionalidade', ['superloja'], ['Step 1', 'Step 2'], '1 semana');
        
        if (($result['success'] ?? false)) {
            $this->info('Fox criou plano: ' . $plan);
        }
        
        return 0;
    }
}
