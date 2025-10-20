<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Agent Configuration
    |--------------------------------------------------------------------------
    |
    | Configurações do AI Agent para SuperLoja Angola
    |
    */

    'enabled' => env('AI_AGENT_ENABLED', true),

    'capabilities' => [
        'product_search',
        'product_recommendations',
        'sales_analytics',
        'performance_insights',
        'auto_posting',
        'chat_responses',
    ],

    'analysis' => [
        'frequency' => env('AI_ANALYSIS_FREQUENCY', 'daily'), // daily, weekly
        'hot_product_threshold' => 10, // mínimo de vendas para ser "hot"
        'cold_product_threshold' => 2, // máximo de vendas para ser "cold"
        'min_conversion_rate' => 1.0, // taxa mínima de conversão (%)
    ],

    'auto_posting' => [
        'enabled' => env('AI_AUTO_POST_ENABLED', false),
        'frequency' => 'twice_daily', // once_daily, twice_daily, weekly
        'platforms' => ['facebook', 'instagram'],
        'default_hashtags' => [
            'SuperLojaAngola',
            'Angola',
            'Luanda',
            'ComprasOnline',
        ],
    ],

    'chat' => [
        'auto_response_enabled' => true,
        'response_delay_seconds' => 2, // simular digitação
        'fallback_message' => 'Obrigado pela sua mensagem! Nossa equipe responderá em breve. 😊',
    ],

    'facebook' => [
        // Configurações movidas para o banco de dados (tabela system_configs)
        // Acesse /admin/ai-agent/settings → Configurações Sistema
    ],

    'instagram' => [
        // Configurações movidas para o banco de dados (tabela system_configs)
        // Acesse /admin/ai-agent/settings → Configurações Sistema
    ],

];
