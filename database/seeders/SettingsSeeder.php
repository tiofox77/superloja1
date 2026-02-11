<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ==============================
            // GERAL
            // ==============================
            [
                'key' => 'app_name',
                'value' => 'SuperLoja',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Nome da Aplicação',
                'description' => 'Nome principal da loja exibido no header, footer e título das páginas',
            ],
            [
                'key' => 'app_description',
                'value' => 'O maior e-commerce de Angola. Produtos de qualidade, entregas rápidas e os melhores preços do mercado. Conectando você aos melhores produtos do país.',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Descrição da Aplicação',
                'description' => 'Descrição curta da loja usada no footer e áreas institucionais',
            ],
            [
                'key' => 'app_url',
                'value' => 'https://superloja.vip',
                'type' => 'string',
                'group' => 'general',
                'label' => 'URL do Site',
                'description' => 'Endereço principal do site',
            ],
            [
                'key' => 'currency',
                'value' => 'AOA',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Moeda',
                'description' => 'Código da moeda padrão (AOA = Kwanza)',
            ],
            [
                'key' => 'currency_symbol',
                'value' => 'Kz',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Símbolo da Moeda',
                'description' => 'Símbolo exibido nos preços',
            ],
            [
                'key' => 'locale',
                'value' => 'pt_AO',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Idioma/Locale',
                'description' => 'Idioma principal da loja',
            ],
            [
                'key' => 'timezone',
                'value' => 'Africa/Luanda',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Fuso Horário',
                'description' => 'Fuso horário do servidor',
            ],

            // ==============================
            // SEO
            // ==============================
            [
                'key' => 'meta_title',
                'value' => 'SuperLoja Angola - As Melhores Ofertas Online de Angola',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Título SEO',
                'description' => 'Título exibido nos resultados do Google (máx. 60 caracteres)',
            ],
            [
                'key' => 'meta_description',
                'value' => 'SuperLoja é a maior loja online de Angola. Encontre eletrônicos, moda, casa e decoração, saúde e bem-estar com entregas rápidas em Luanda e todo o país.',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Meta Descrição',
                'description' => 'Descrição exibida nos resultados do Google (máx. 160 caracteres)',
            ],
            [
                'key' => 'meta_keywords',
                'value' => 'loja online angola, compras online luanda, eletrônicos angola, moda angola, superloja, e-commerce angola, produtos angola, entregas luanda, loja virtual angola, comprar online angola',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Palavras-chave',
                'description' => 'Palavras-chave separadas por vírgula para motores de busca',
            ],
            [
                'key' => 'google_analytics',
                'value' => '',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Google Analytics ID',
                'description' => 'ID de medição do Google Analytics 4 (ex: G-XXXXXXXXXX)',
            ],
            [
                'key' => 'facebook_pixel',
                'value' => '',
                'type' => 'string',
                'group' => 'seo',
                'label' => 'Facebook Pixel ID',
                'description' => 'ID do Pixel do Facebook/Meta para rastreamento de conversões',
            ],

            // ==============================
            // APARÊNCIA
            // ==============================
            [
                'key' => 'primary_color',
                'value' => '#FF8C00',
                'type' => 'string',
                'group' => 'appearance',
                'label' => 'Cor Primária',
                'description' => 'Cor principal da marca (laranja SuperLoja)',
            ],
            [
                'key' => 'secondary_color',
                'value' => '#8B1E5C',
                'type' => 'string',
                'group' => 'appearance',
                'label' => 'Cor Secundária',
                'description' => 'Cor secundária da marca',
            ],

            // ==============================
            // CONTACTO
            // ==============================
            [
                'key' => 'contact_phone',
                'value' => '+244 939 729 902',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Telefone Principal',
                'description' => 'Número de telefone exibido no site',
            ],
            [
                'key' => 'contact_email',
                'value' => 'contato@superloja.vip',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Email de Contacto',
                'description' => 'Email principal de contacto',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '+244939729902',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'WhatsApp',
                'description' => 'Número do WhatsApp com código do país (sem espaços)',
            ],
            [
                'key' => 'address',
                'value' => 'Kilamba J13, Luanda, Angola',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Endereço',
                'description' => 'Endereço físico da empresa',
            ],

            // ==============================
            // REDES SOCIAIS
            // ==============================
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/superloja.vip',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Link da página do Facebook',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/superloja.vip',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Link do perfil do Instagram',
            ],
            [
                'key' => 'twitter_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'Twitter/X URL',
                'description' => 'Link do perfil no Twitter/X',
            ],
            [
                'key' => 'youtube_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'YouTube URL',
                'description' => 'Link do canal do YouTube',
            ],
            [
                'key' => 'linkedin_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'Link do perfil no LinkedIn',
            ],
            [
                'key' => 'tiktok_url',
                'value' => '',
                'type' => 'string',
                'group' => 'social',
                'label' => 'TikTok URL',
                'description' => 'Link do perfil no TikTok',
            ],

            // ==============================
            // LOJA
            // ==============================
            [
                'key' => 'store_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'store',
                'label' => 'Loja Ativa',
                'description' => 'Ativar ou desativar a loja para clientes',
            ],
            [
                'key' => 'min_order_value',
                'value' => '1000',
                'type' => 'number',
                'group' => 'store',
                'label' => 'Valor Mínimo do Pedido',
                'description' => 'Valor mínimo em Kz para realizar um pedido',
            ],
            [
                'key' => 'delivery_fee',
                'value' => '1500',
                'type' => 'number',
                'group' => 'store',
                'label' => 'Taxa de Entrega Padrão',
                'description' => 'Taxa de entrega padrão em Kz',
            ],
            [
                'key' => 'free_delivery_min',
                'value' => '25000',
                'type' => 'number',
                'group' => 'store',
                'label' => 'Entrega Grátis a Partir de',
                'description' => 'Valor mínimo em Kz para entrega gratuita',
            ],
            [
                'key' => 'delivery_time',
                'value' => '1-3 dias úteis',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Tempo de Entrega',
                'description' => 'Prazo estimado de entrega exibido ao cliente',
            ],
            [
                'key' => 'delivery_areas',
                'value' => 'Luanda, Viana, Cacuaco, Kilamba, Talatona, Benfica',
                'type' => 'string',
                'group' => 'store',
                'label' => 'Áreas de Entrega',
                'description' => 'Áreas cobertas pelo serviço de entrega',
            ],
            [
                'key' => 'max_products_per_page',
                'value' => '24',
                'type' => 'number',
                'group' => 'store',
                'label' => 'Produtos por Página',
                'description' => 'Número máximo de produtos exibidos por página na listagem',
            ],
            [
                'key' => 'allow_guest_checkout',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'store',
                'label' => 'Checkout como Visitante',
                'description' => 'Permitir compra sem criar conta',
            ],
            [
                'key' => 'stock_alert_threshold',
                'value' => '5',
                'type' => 'number',
                'group' => 'store',
                'label' => 'Alerta de Stock Baixo',
                'description' => 'Quantidade mínima para alerta de stock baixo',
            ],

            // ==============================
            // API
            // ==============================
            [
                'key' => 'api_token',
                'value' => 'Popadic17',
                'type' => 'string',
                'group' => 'api',
                'label' => 'Token da API',
                'description' => 'Token de autenticação para acesso à API REST',
            ],
            [
                'key' => 'api_rate_limit',
                'value' => '60',
                'type' => 'number',
                'group' => 'api',
                'label' => 'Rate Limit da API',
                'description' => 'Número máximo de requisições por minuto',
            ],
            [
                'key' => 'update_token',
                'value' => 'SuperlojaUpdate2024!',
                'type' => 'string',
                'group' => 'api',
                'label' => 'Token de Update do Sistema',
                'description' => 'Token de segurança para a API de updates (X-Update-Token)',
            ],

            // ==============================
            // SMS (Unimtx)
            // ==============================
            [
                'key' => 'sms_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'sms',
                'label' => 'SMS Ativado',
                'description' => 'Ativar ou desativar envio de SMS',
            ],
            [
                'key' => 'unimtx_access_key',
                'value' => '',
                'type' => 'string',
                'group' => 'sms',
                'label' => 'Unimtx Access Key',
                'description' => 'Chave de acesso da API Unimtx',
                'is_encrypted' => true,
            ],
            [
                'key' => 'unimtx_signature',
                'value' => 'SUPERLOJA',
                'type' => 'string',
                'group' => 'sms',
                'label' => 'Unimtx Signature',
                'description' => 'Nome do remetente aprovado na Unimtx',
            ],

            // ==============================
            // EMAIL
            // ==============================
            [
                'key' => 'mail_from_name',
                'value' => 'SuperLoja Angola',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Nome do Remetente',
                'description' => 'Nome exibido nos emails enviados',
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'noreply@superloja.vip',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Email do Remetente',
                'description' => 'Endereço de email do remetente',
            ],

            // ==============================
            // NOTIFICAÇÕES
            // ==============================
            [
                'key' => 'notify_new_order',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Notificar Novo Pedido',
                'description' => 'Enviar notificação ao admin quando houver novo pedido',
            ],
            [
                'key' => 'notify_low_stock',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Notificar Stock Baixo',
                'description' => 'Enviar notificação quando o stock estiver baixo',
            ],
            [
                'key' => 'notify_new_user',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Notificar Novo Utilizador',
                'description' => 'Enviar notificação quando um novo utilizador se registar',
            ],
        ];

        foreach ($settings as $setting) {
            $isEncrypted = $setting['is_encrypted'] ?? false;

            // Só insere se a chave ainda não existir (não sobrescreve dados existentes)
            if (!Setting::has($setting['key'])) {
                Setting::set(
                    $setting['key'],
                    $setting['value'],
                    $setting['type'],
                    $setting['group'],
                    $setting['label'],
                    $setting['description'],
                    $isEncrypted
                );
            }
        }

        $this->command->info('✅ Settings preenchidas com sucesso! (' . count($settings) . ' configurações)');
    }
}
