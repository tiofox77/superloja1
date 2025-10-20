<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AiKnowledgeBase;

class AiKnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        $knowledge = [
            // FAQs
            [
                'category' => 'faq',
                'question' => 'Como funciona a entrega?',
                'answer' => "🚚 Fazemos entregas em Luanda e outras províncias!\n\n" .
                           "Prazos estimados:\n" .
                           "• Luanda: 1-2 dias úteis\n" .
                           "• Outras províncias: 3-5 dias úteis\n\n" .
                           "📱 Entre em contato: https://wa.me/244939729902",
                'keywords' => ['entrega', 'envio', 'frete', 'delivery', 'transportadora'],
            ],
            [
                'category' => 'faq',
                'question' => 'Quais formas de pagamento aceitam?',
                'answer' => "💳 Formas de pagamento aceitas:\n\n" .
                           "• Transferência bancária\n" .
                           "• Pagamento na entrega\n" .
                           "• TPA (em lojas físicas)\n\n" .
                           "Para mais detalhes:\n" .
                           "📱 WhatsApp: https://wa.me/244939729902",
                'keywords' => ['pagamento', 'pagar', 'transferência', 'dinheiro', 'cartão'],
            ],
            [
                'category' => 'faq',
                'question' => 'Vocês têm loja física?',
                'answer' => "🏪 Sim! Temos loja física em Luanda.\n\n" .
                           "Horário de funcionamento:\n" .
                           "• Segunda a Sexta: 8h às 18h\n" .
                           "• Sábado: 9h às 14h\n\n" .
                           "Para endereço e mais informações:\n" .
                           "📱 WhatsApp: https://wa.me/244939729902",
                'keywords' => ['loja física', 'endereço', 'localização', 'onde fica'],
            ],
            [
                'category' => 'faq',
                'question' => 'Qual o prazo de garantia?',
                'answer' => "✅ Garantia dos produtos:\n\n" .
                           "• Eletrônicos: 12 meses\n" .
                           "• Outros produtos: 90 dias\n" .
                           "• Garantia do fabricante pode variar\n\n" .
                           "Para mais informações:\n" .
                           "📱 WhatsApp: https://wa.me/244939729902",
                'keywords' => ['garantia', 'troca', 'devolução', 'defeito'],
            ],

            // Informações de Produto
            [
                'category' => 'product_info',
                'question' => 'Quais produtos vocês vendem?',
                'answer' => "🛒 Temos grande variedade de produtos:\n\n" .
                           "📱 **Tecnologia:**\n" .
                           "• Smartphones, Laptops, Tablets\n" .
                           "• Acessórios eletrônicos\n\n" .
                           "💊 **Saúde e Bem-estar:**\n" .
                           "• Vitaminas e Suplementos\n" .
                           "• Produtos de higiene\n\n" .
                           "🧼 **Limpeza:**\n" .
                           "• Detergentes e produtos de limpeza\n\n" .
                           "Veja tudo em: https://superloja.vip",
                'keywords' => ['produtos', 'vende', 'tem', 'disponível', 'estoque'],
            ],
            [
                'category' => 'product_info',
                'question' => 'Como consultar preços?',
                'answer' => "💰 Para consultar preços específicos:\n\n" .
                           "1️⃣ Acesse nosso site: https://superloja.vip\n" .
                           "2️⃣ Ou fale direto conosco:\n" .
                           "📱 WhatsApp: https://wa.me/244939729902\n\n" .
                           "Me diga qual produto você procura e posso ajudar! 😊",
                'keywords' => ['preço', 'valor', 'custo', 'quanto custa'],
            ],

            // Políticas
            [
                'category' => 'policy',
                'question' => 'Posso trocar um produto?',
                'answer' => "🔄 Política de trocas:\n\n" .
                           "✅ Troca em até 7 dias (produto lacrado)\n" .
                           "✅ Defeito de fábrica: troca imediata\n" .
                           "📦 Produto deve estar na embalagem original\n\n" .
                           "Para solicitar troca:\n" .
                           "📱 WhatsApp: https://wa.me/244939729902",
                'keywords' => ['trocar', 'troca', 'devolução', 'devolver'],
            ],
        ];

        foreach ($knowledge as $item) {
            AiKnowledgeBase::create($item);
        }

        $this->command->info('✅ Conhecimento base criado com sucesso!');
    }
}
