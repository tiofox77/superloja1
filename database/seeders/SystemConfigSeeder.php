<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemConfig;

class SystemConfigSeeder extends Seeder
{
    public function run(): void
    {
        // AI Agent Configuration
        SystemConfig::set('ai_agent_enabled', true, [
            'group' => 'ai_agent',
            'label' => 'AI Agent Habilitado',
            'description' => 'Ativar ou desativar o AI Agent',
            'type' => 'boolean',
        ]);

        SystemConfig::set('ai_analysis_frequency', 'daily', [
            'group' => 'ai_agent',
            'label' => 'Frequência de Análise',
            'description' => 'Com que frequência analisar produtos (daily, weekly)',
            'type' => 'string',
        ]);

        SystemConfig::set('ai_auto_post_enabled', false, [
            'group' => 'ai_agent',
            'label' => 'Posts Automáticos Habilitados',
            'description' => 'Ativar postagem automática nas redes sociais',
            'type' => 'boolean',
        ]);

        // Facebook Integration
        SystemConfig::set('facebook_app_id', '', [
            'group' => 'facebook',
            'label' => 'Facebook App ID',
            'description' => 'ID do aplicativo Facebook',
            'type' => 'string',
        ]);

        SystemConfig::set('facebook_app_secret', '', [
            'group' => 'facebook',
            'label' => 'Facebook App Secret',
            'description' => 'Secret do aplicativo Facebook',
            'type' => 'string',
            'is_encrypted' => true,
        ]);

        SystemConfig::set('facebook_access_token', '', [
            'group' => 'facebook',
            'label' => 'Facebook Access Token',
            'description' => 'Token de acesso da página do Facebook',
            'type' => 'string',
            'is_encrypted' => true,
        ]);

        SystemConfig::set('facebook_page_id', '', [
            'group' => 'facebook',
            'label' => 'Facebook Page ID',
            'description' => 'ID da página do Facebook',
            'type' => 'string',
        ]);

        SystemConfig::set('facebook_verify_token', '', [
            'group' => 'facebook',
            'label' => 'Facebook Verify Token',
            'description' => 'Token de verificação para webhooks',
            'type' => 'string',
            'is_encrypted' => true,
        ]);

        // Instagram Integration
        SystemConfig::set('instagram_business_account_id', '', [
            'group' => 'instagram',
            'label' => 'Instagram Business Account ID',
            'description' => 'ID da conta business do Instagram',
            'type' => 'string',
        ]);

        SystemConfig::set('instagram_access_token', '', [
            'group' => 'instagram',
            'label' => 'Instagram Access Token',
            'description' => 'Token de acesso do Instagram',
            'type' => 'string',
            'is_encrypted' => true,
        ]);

        SystemConfig::set('instagram_verify_token', '', [
            'group' => 'instagram',
            'label' => 'Instagram Verify Token',
            'description' => 'Token de verificação para webhooks',
            'type' => 'string',
            'is_encrypted' => true,
        ]);

        // AI Provider Configuration
        SystemConfig::set('ai_provider', 'openai', [
            'group' => 'ai',
            'label' => 'AI Provider',
            'description' => 'Provider de IA (openai ou claude)',
            'type' => 'string',
        ]);

        SystemConfig::set('openai_api_key', '', [
            'group' => 'ai',
            'label' => 'OpenAI API Key',
            'description' => 'Chave de API da OpenAI',
            'type' => 'string',
            'is_encrypted' => true,
        ]);

        SystemConfig::set('openai_model', 'gpt-4o-mini', [
            'group' => 'ai',
            'label' => 'OpenAI Model',
            'description' => 'Modelo da OpenAI a usar',
            'type' => 'string',
        ]);

        SystemConfig::set('claude_api_key', '', [
            'group' => 'ai',
            'label' => 'Claude API Key',
            'description' => 'Chave de API da Anthropic Claude',
            'type' => 'string',
            'is_encrypted' => true,
        ]);

        SystemConfig::set('claude_model', 'claude-3-5-sonnet-20241022', [
            'group' => 'ai',
            'label' => 'Claude Model',
            'description' => 'Modelo do Claude a usar',
            'type' => 'string',
        ]);
    }
}
