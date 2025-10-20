<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\AiSentimentAnalysis;
use App\Models\AiKnowledgeBase;
use App\Models\AiPerformanceMetrics;
use Carbon\Carbon;

class CalculateAiMetrics extends Command
{
    protected $signature = 'ai:calculate-metrics {--date= : Data para calcular métricas (Y-m-d)} {--hours=4 : Período em horas}';
    protected $description = 'Calcular métricas de performance da IA';

    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        
        if ($this->option('date')) {
            $startDate = Carbon::parse($this->option('date'));
            $endDate = $startDate->copy()->addDay();
            $metricDate = $startDate->toDateString();
        } else {
            // Últimas X horas
            $endDate = now();
            $startDate = $endDate->copy()->subHours($hours);
            $metricDate = now()->toDateString();
        }

        $this->info("📊 Calculando métricas das últimas {$hours}h ({$startDate->format('d/m/Y H:i')} até {$endDate->format('d/m/Y H:i')})");

        // Total de conversas no período
        $totalConversations = AiConversation::whereBetween('created_at', [$startDate, $endDate])->count();

        // Mensagens do período
        $messages = AiMessage::whereBetween('created_at', [$startDate, $endDate])->get();
        $outgoingMessages = $messages->where('direction', 'outgoing')->count();
        
        // Análises de sentimento
        $sentiments = AiSentimentAnalysis::whereBetween('created_at', [$startDate, $endDate])->get();
        $positiveCount = $sentiments->where('sentiment', 'positive')->count();
        $negativeCount = $sentiments->where('sentiment', 'negative')->count();

        // Uso de conhecimento
        $knowledgeUsage = AiKnowledgeBase::sum('times_used');
        $knowledgeSuccess = AiKnowledgeBase::sum('times_successful');

        // Calcular taxa de sucesso
        $responseSuccessRate = $outgoingMessages > 0
            ? ($knowledgeSuccess / max($outgoingMessages, 1)) * 100
            : 0;

        // Top perguntas (simplificado)
        $topQuestions = AiKnowledgeBase::orderByDesc('times_used')
            ->limit(5)
            ->pluck('question')
            ->toArray();

        // Satisfação do cliente (baseado em sentimentos)
        $totalSentiments = $sentiments->count();
        $customerSatisfaction = $totalSentiments > 0
            ? (($positiveCount / $totalSentiments) * 5)
            : 0;

        // Criar ou atualizar métricas
        $metrics = AiPerformanceMetrics::updateOrCreate(
            ['metric_date' => $metricDate],
            [
                'total_conversations' => $totalConversations,
                'successful_responses' => $knowledgeSuccess,
                'failed_responses' => $outgoingMessages - $knowledgeSuccess,
                'response_success_rate' => round($responseSuccessRate, 2),
                'conversions' => 0, // Será atualizado quando integrar com vendas
                'conversion_rate' => 0,
                'avg_response_time_seconds' => 2.5, // Placeholder
                'human_interventions' => $sentiments->where('needs_human_attention', true)->count(),
                'top_questions' => $topQuestions,
                'top_products' => [],
                'customer_satisfaction_score' => round($customerSatisfaction, 2),
            ]
        );

        $this->newLine();
        $this->info("✅ Métricas calculadas com sucesso!");
        $this->newLine();

        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Conversas', $totalConversations],
                ['Respostas Enviadas', $outgoingMessages],
                ['Taxa de Sucesso', number_format($responseSuccessRate, 1) . '%'],
                ['Satisfação do Cliente', number_format($customerSatisfaction, 2) . '/5'],
                ['Intervenções Humanas', $metrics->human_interventions],
            ]
        );

        return self::SUCCESS;
    }
}
