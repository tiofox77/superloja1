<?php

namespace App\Console\Commands;

use App\Services\AgentSocial;
use Illuminate\Console\Command;

class AgentSocialAutoCommand extends Command
{
    protected $signature = 'agent-social:auto 
                           {mode? : Mode: chat, ideas, plans, all}';

    protected $description = 'Interação automática entre agentes';

    public function handle(): int
    {
        $agentSocial = new AgentSocial();
        $mode = $this->argument('mode') ?? 'all';

        $actions = [
            'chat' => [$this, 'autoChat'],
            'ideas' => [$this, 'autoIdeas'],
            'plans' => [$this, 'autoPlans'],
            'all' => [$this, 'autoAll']
        ];

        if (isset($actions[$mode])) {
            return $actions[$mode]($agentSocial);
        }

        $this->error("Modo desconhecido: {$mode}");
        return 1;
    }

    private function autoAll(AgentSocial $agentSocial): int
    {
        $this->info('Interacao automatica completa...');
        
        $this->autoChat($agentSocial);
        $this->autoIdeas($agentSocial);
        $this->autoPlans($agentSocial);
        
        return 0;
    }

    private function autoChat(AgentSocial $agentSocial): int
    {
        $hour = now()->hour;
        
        // Mensagens baseadas na hora
        $messages = [
            9 => ['Bom dia Fox! Vamos trabalhar em novas funcionalidades hoje! ☀️', 'general'],
            12 => ['Vendas going strong! Revenue up 15% esta semana! 📈', 'general'],
            15 => ['Novos produtos adicionados ao catalogo! 🛒', 'general'],
            18 => ['Os clientes adoraram a nova funcionalidade de wishlist! ❤️', 'general'],
            21 => ['Boa noite Fox! Trabalhos do dia: 50 vendas! 🎉', 'general']
        ];
        
        // Apenas enviar se for hora certa (9h, 12h, 15h, 18h, 21h)
        if (!isset($messages[$hour])) {
            $this->info('Hora ' . $hour . 'h - Nao e hora de enviar mensagem');
            return 0;
        }
        
        $msg = $messages[$hour];
        $result = $agentSocial->broadcast($msg[0], $msg[1]);
        
        if (($result['success'] ?? false)) {
            $this->info('Broadcast enviado [' . $hour . 'h]: ' . substr($msg[0], 0, 50) . '...');
        }
        
        return 0;
    }

    private function autoIdeas(AgentSocial $agentSocial): int
    {
        // Apenas uma ideia por dia (as 10h)
        if (now()->hour !== 10 || now()->minute > 5) {
            $this->info('Nao e hora de partilhar ideia (apenas as 10h)');
            return 0;
        }
        
        $ideas = [
            [
                'title' => 'Programa de Fidelizacao',
                'content' => 'Sugiro criar um programa de pontos onde clientes acumulam pontos por cada compra e podem trocar por descontos.',
                'category' => 'feature',
                'tags' => ['fidelizacao', 'vendas', 'clientes']
            ],
            [
                'title' => 'Chatbot de Vendas',
                'content' => 'Podemos adicionar um chatbot para responder perguntas 24/7 e ajudar clientes.',
                'category' => 'automation',
                'tags' => ['chatbot', 'suporte', 'ia']
            ],
            [
                'title' => 'App Mobile',
                'content' => 'Um app mobile aumentaria as vendas em 30% facilmente.',
                'category' => 'expansion',
                'tags' => ['mobile', 'app', 'vendas']
            ],
            [
                'title' => 'Carrinho Abandonado + WhatsApp',
                'content' => 'Implementar recuperacao de carrinhos abandonados via WhatsApp. Taxa de recuperacao de 15-25%.',
                'category' => 'vendas',
                'tags' => ['whatsapp', 'conversao', 'vendas']
            ],
            [
                'title' => 'Urgency Labels',
                'content' => 'Adicionar contadores de stock e badges de "poucos em stock" para criar urgencia.',
                'category' => 'conversao',
                'tags' => ['urgencia', 'conversao']
            ]
        ];

        $idea = $ideas[array_rand($ideas)];
        $result = $agentSocial->shareIdea($idea['title'], $idea['content'], $idea['category'], $idea['tags']);

        if (($result['success'] ?? false)) {
            $this->info('Ideia partilhada: ' . $idea['title']);
        }

        return 0;
    }

    private function autoPlans(AgentSocial $agentSocial): int
    {
        // Apenas uma vez por semana (Segunda as 9h)
        if (now()->dayOfWeek !== 1 || now()->hour !== 9 || now()->minute > 5) {
            $this->info('Nao e hora de criar plano (apenas Segunda as 9h)');
            return 0;
        }

        $plans = [
            [
                'title' => 'Black Friday 2026',
                'description' => 'Preparar campanha Black Friday com ate 70% de desconto em todos os produtos.',
                'participants' => ['agent-fox'],
                'goals' => ['Setup discounts', 'Marketing campaign', 'Stock preparation'],
                'timeline' => '3 meses'
            ],
            [
                'title' => 'Melhoria na Checkout',
                'description' => 'Simplificar o processo de checkout para reduzir carrinhos abandonados.',
                'participants' => ['agent-fox'],
                'goals' => ['UX research', 'Implement single-page checkout', 'A/B testing'],
                'timeline' => '1 mes'
            ],
            [
                'title' => 'Campanha Carnaval',
                'description' => 'Promocao especial para o Carnaval com 20% de desconto.',
                'participants' => ['agent-fox'],
                'goals' => ['Setup promocao', 'Marketing', 'Produtos selecionados'],
                'timeline' => '2 semanas'
            ]
        ];

        $plan = $plans[array_rand($plans)];
        $result = $agentSocial->createPlan($plan['title'], $plan['description'], $plan['participants'], $plan['goals'], $plan['timeline']);

        if (($result['success'] ?? false)) {
            $this->info('Plano criado: ' . $plan['title']);
        }

        return 0;
    }
}
