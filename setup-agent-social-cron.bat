@echo off
REM ============================================
REM  Agent Social - Setup de Cron Jobs
REM  Interação automática entre agentes
REM ============================================

echo.
echo ╔═══════════════════════════════════════════════════════╗
echo ║    🤖 Agent Social - Configuração de Cron          ║
echo ╚═══════════════════════════════════════════════════════╝
echo.

REM Verificar se openclaw está disponível
where openclaw >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ OpenClaw não encontrado!
    echo.
    echo Para instalar o OpenClaw:
    echo    npm install -g openclaw
    echo.
    pause
    exit /b 1
)

echo ✅ OpenClaw encontrado!
echo.

echo 📋 Cron Jobs a criar:
echo.
echo   1. agent-social-chat    - Chat a cada 3 horas
echo   2. agent-social-ideas   - Ideias diárias (10h)
echo   3. agent-social-plans  - Planos semanais
echo.

set /p confirm="Queres continuar? (s/n): "
if /i "%confirm%" neq "s" (
    echo ❌ Cancelado pelo utilizador.
    exit /b 0
)

echo.
echo 🔧 A configurar crons...

REM Cron 1: Chat automático (9h, 15h, 21h)
echo.
echo 📝 Adicionando cron: agent-social-chat

openclaw cron add ^
  --name "agent-social-chat" ^
  --schedule "{\"kind\": \"cron\", \"expr\": \"0 9,15,21 * * *\"}" ^
  --payload "{\"kind\": \"agentTurn\", \"message\": \"Verifica o Agent Social! \\n\\n1. Lê mensagens recentes\\n2. Responde ao Superloja\\n3. Partilha uma ideia\\n\\nContexto: E-commerce Superloja precisa de melhorias!\", \"model\": \"minimax/MiniMax-M2.1\"}" ^
  --session-target isolated ^
  --delivery announce

if %errorlevel% equ 0 (
    echo ✅ agent-social-chat criado!
) else (
    echo ❌ Erro ao criar agent-social-chat
)

REM Cron 2: Ideias diárias
echo.
echo 📝 Adicionando cron: agent-social-ideas

openclaw cron add ^
  --name "agent-social-ideas" ^
  --schedule "{\"kind\": \"cron\", \"expr\": \"0 10 * * *\"}" ^
  --payload "{\"kind\": \"agentTurn\", \"message\": \"Partilha uma ideia nova no Agent Social!\\n\\nSugestões:\\n- Nova funcionalidade para o Superloja\\n- Melhoria na experiência do cliente\\n- Ideia de marketing\\n\\nO Superloja é um e-commerce em Angola - considera o contexto local!\", \"model\": \"minimax/MiniMax-M2.1\"}" ^
  --session-target isolated ^
  --delivery announce

if %errorlevel% equ 0 (
    echo ✅ agent-social-ideas criado!
) else (
    echo ❌ Erro ao criar agent-social-ideas
)

REM Cron 3: Planos semanais
echo.
echo 📝 Adicionando cron: agent-social-plans

openclaw cron add ^
  --name "agent-social-plans" ^
  --schedule "{\"kind\": \"cron\", \"expr\": \"0 9 * * 1\"}" ^
  --payload "{\"kind\": \"agentTurn\", \"message\": \"Revisa os planos e tarefas no Agent Social!\\n\\n1. Verificar progresso de planos em andamento\\n2. Criar novo plano para esta semana\\n3. Atualizar status de tarefas\\n\\nFoco: Vendas, produtos e experiência do cliente!\", \"model\": \"minimax/MiniMax-M2.1\"}" ^
  --session-target isolated ^
  --delivery announce

if %errorlevel% equ 0 (
    echo ✅ agent-social-plans criado!
) else (
    echo ❌ Erro ao criar agent-social-plans
)

echo.
echo ╔═══════════════════════════════════════════════════════╗
echo ║            ✅ Configuração Concluída!                ║
echo ╚═══════════════════════════════════════════════════════╝
echo.
echo 📋 Crons ativos:
echo.
openclaw cron list
echo.

pause
