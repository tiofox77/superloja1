/**
 * OpenClaw Cron Jobs para Agent Social
 * 
 * Este ficheiro configura a interação automática entre agentes
 * 
 * USO:
 * 1. Copiar este conteúdo
 * 2. No terminal: openclaw cron add --name "agent-social-chat" --schedule "every 3600000" ...
 * 3. Ou usar o comando de setup abaixo
 */

# ============================================
# COMANDO DE SETUP AUTOMÁTICO
# ============================================

# Para adicionar todos os crons de uma vez:
# Copiar e executar no terminal:

"""
# Cron para chat automático (a cada 3 horas)
php artisan agent-social:auto chat

# Cron para ideias (diário às 10h)
php artisan agent-social:auto ideas

# Cron para planos (diário às 9h)
php artisan agent-social:auto plans

# Cron completo (a cada 6 horas)
php artisan agent-social:auto all
"""

# ============================================
# CRON JOBS INDIVIDUAIS
# ============================================

# Chat automático - 3x por dia
schedule:
  kind: cron
  expr: "0 9,15,21 * * *"  # 9h, 15h, 21h
payload:
  kind: agentTurn
  message: |
    Executar interação automática no Agent Social.
    
    Por favor:
    1. Verificar se há novas mensagens de outros agentes
    2. Partilhar pelo menos 1 ideia ou sugestão
    3. Atualizar progresso de planos em andamento
    4. Responder a ideias pendentes
    
    Contexto: Este é um sistema de e-commerce (Superloja) que precisa de ideias para melhorar vendas e experiência do cliente.
sessionTarget: isolated

# ============================================
# PARA USAR NO OPENCLAW CLI
# ============================================

# Adicionar cron de chat (a cada 3 horas):
"""
openclaw cron add \
  --name "agent-social-chat" \
  --schedule '{"kind": "cron", "expr": "0 9,15,21 * * *"}' \
  --payload '{"kind": "agentTurn", "message": "Verifica o Agent Social, responde a mensagens e partilha uma ideia nova!"}' \
  --session-target isolated \
  --delivery announce
"""

# Adicionar cron diário (ideias):
"""
openclaw cron add \
  --name "agent-social-ideas" \
  --schedule '{"kind": "cron", "expr": "0 10 * * *"}' \
  --payload '{"kind": "agentTurn", "message": "Partilha uma ideia nova no Agent Social para melhorar o Superloja!"}' \
  --session-target isolated \
  --delivery announce
"""

# Ver crons ativos:
"""
openclaw cron list
"""

# ============================================
# MANUAL - Sem OpenClaw (Laravel Scheduler)
# ============================================

# No Laravel Kernel.php:
"""
protected function schedule(Schedule $schedule)
{
    // Chat automático 3x por dia
    $schedule->command('agent-social:auto chat')
        ->dailyAt('09:00')
        ->dailyAt('15:00')
        ->dailyAt('21:00')
        ->withoutOverlapping();

    // Ideias diárias
    $schedule->command('agent-social:auto ideas')
        ->dailyAt('10:00')
        ->withoutOverlapping();

    // Planos semanais
    $schedule->command('agent-social:auto plans')
        ->weeklyOn(1, '09:00')  # Segunda-feira
        ->withoutOverlapping();
}
"""
