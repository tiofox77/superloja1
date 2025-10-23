<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AiCustomerContext;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Str;

class CheckoutService
{
    /**
     * Iniciar processo de checkout
     */
    public function startCheckout(AiCustomerContext $context, ?string $customerName): string
    {
        $purchaseHistory = $context->purchase_history ?? [];
        $cart = $purchaseHistory['cart'] ?? [];
        
        if (empty($cart)) {
            $name = $customerName ? " $customerName" : '';
            return "Seu carrinho está vazio{$name}! 🛍️\n\n" .
                   "Adicione produtos antes de finalizar o pedido.\n" .
                   "Digite 'produtos' ou 'ver produtos'!";
        }
        
        $total = 0;
        $totalItems = 0;
        foreach ($cart as $item) {
            $quantity = $item['quantity'] ?? 1;
            $price = $item['price'] ?? 0;
            $total += $quantity * $price;
            $totalItems += $quantity;
        }
        
        $totalFormatted = number_format((float)$total, 2, ',', '.');
        
        $purchaseHistory['checkout_step'] = 'awaiting_name';
        $purchaseHistory['checkout_started_at'] = now()->toIso8601String();
        $purchaseHistory['checkout_data'] = [];
        $context->update(['purchase_history' => $purchaseHistory]);
        
        $name = $customerName ? " $customerName" : '';
        return "✅ Ótimo{$name}! Vamos finalizar seu pedido! 🎉\n\n" .
               "📦 Total de itens: {$totalItems}\n" .
               "💰 Total: {$totalFormatted} Kz\n\n" .
               "━━━━━━━━━━━━━━━━\n\n" .
               "Para concluir, preciso de alguns dados:\n\n" .
               "👤 **Passo 1/3:** Qual é o seu nome completo?";
    }

    /**
     * Processar dados do checkout
     */
    public function processCheckoutStep(AiCustomerContext $context, string $message, ?string $customerName): string
    {
        $purchaseHistory = $context->purchase_history ?? [];
        $checkoutStep = $purchaseHistory['checkout_step'] ?? null;
        $cart = $purchaseHistory['cart'] ?? [];
        
        if (!$checkoutStep || empty($cart)) {
            return "Não há pedido em andamento. Digite 'finalizar' para iniciar!";
        }
        
        // Verificar se usuário quer cancelar ou ver carrinho
        $messageLower = strtolower(trim($message));
        if (preg_match('/(cancelar|desistir|sair|voltar|carrinho|ver\s+carrinho)/i', $messageLower)) {
            return $this->cancelCheckout($context, $customerName);
        }
        
        switch ($checkoutStep) {
            case 'awaiting_name':
                return $this->collectName($context, $message, $purchaseHistory);
            
            case 'awaiting_phone':
                return $this->collectPhone($context, $message, $purchaseHistory);
            
            case 'awaiting_address':
                return $this->collectAddress($context, $message, $purchaseHistory);
            
            default:
                return "Erro no processo. Digite 'finalizar' para tentar novamente.";
        }
    }

    /**
     * Coletar nome
     */
    private function collectName(AiCustomerContext $context, string $message, array $purchaseHistory): string
    {
        $name = trim($message);
        
        if (strlen($name) < 3) {
            return "❌ Nome muito curto.\n\n" .
                   "Por favor, envie seu nome completo.";
        }
        
        $purchaseHistory['checkout_data']['name'] = $name;
        $purchaseHistory['checkout_step'] = 'awaiting_phone';
        $context->update(['purchase_history' => $purchaseHistory]);
        
        return "✅ Nome registrado: {$name}\n\n" .
               "📱 **Passo 2/3:** Qual é o seu número de telefone?\n" .
               "(Exemplo: 244939729902 ou 939729902)";
    }

    /**
     * Coletar telefone
     */
    private function collectPhone(AiCustomerContext $context, string $message, array $purchaseHistory): string
    {
        $phone = preg_replace('/[^0-9]/', '', $message);
        
        if (strlen($phone) < 9) {
            return "❌ Número inválido.\n\n" .
                   "Por favor, envie um número válido.\n" .
                   "(Mínimo 9 dígitos)";
        }
        
        // Adicionar prefixo 244 se não tiver
        if (!str_starts_with($phone, '244') && strlen($phone) === 9) {
            $phone = '244' . $phone;
        }
        
        $purchaseHistory['checkout_data']['phone'] = $phone;
        $purchaseHistory['checkout_step'] = 'awaiting_address';
        $context->update(['purchase_history' => $purchaseHistory]);
        
        return "✅ Telefone registrado: {$phone}\n\n" .
               "📍 **Passo 3/3:** Qual é o seu endereço completo?\n" .
               "(Rua, bairro, cidade - seja específico para entregarmos corretamente)";
    }

    /**
     * Coletar endereço e criar pedido
     */
    private function collectAddress(AiCustomerContext $context, string $message, array $purchaseHistory): string
    {
        $address = trim($message);
        
        if (strlen($address) < 10) {
            return "❌ Endereço muito curto.\n\n" .
                   "Por favor, envie um endereço completo.\n" .
                   "(Rua, bairro, cidade)";
        }
        
        $purchaseHistory['checkout_data']['address'] = $address;
        $context->update(['purchase_history' => $purchaseHistory]);
        
        // Criar pedido
        try {
            $order = $this->createOrder($context, $purchaseHistory);
            
            // Limpar carrinho após criar pedido
            $purchaseHistory['cart'] = [];
            $purchaseHistory['checkout_step'] = null;
            $purchaseHistory['checkout_data'] = [];
            $context->update(['purchase_history' => $purchaseHistory]);
            
            $orderNumber = str_pad((string)$order->id, 6, '0', STR_PAD_LEFT);
            
            return "🎉 *Pedido Confirmado!* 🎉\n\n" .
                   "📋 Número do Pedido: #{$orderNumber}\n" .
                   "💰 Total: " . number_format((float)$order->total_amount, 2, ',', '.') . " Kz\n\n" .
                   "✅ Seu pedido foi registrado com sucesso!\n\n" .
                   "📦 Detalhes:\n" .
                   "👤 Nome: {$order->customer_name}\n" .
                   "📱 Telefone: {$order->customer_phone}\n" .
                   "📍 Endereço: {$address}\n\n" .
                   "━━━━━━━━━━━━━━━━\n\n" .
                   "Nossa equipe entrará em contato em breve!\n\n" .
                   "📱 Dúvidas? WhatsApp: https://wa.me/244939729902\n\n" .
                   "Obrigado por comprar na SuperLoja! 😊";
            
        } catch (\Exception $e) {
            \Log::error('Erro ao criar pedido: ' . $e->getMessage());
            
            // Notificar admin sobre erro
            $customerName = $purchaseHistory['checkout_data']['name'] ?? 'Cliente';
            $customerPhone = $purchaseHistory['checkout_data']['phone'] ?? 'N/A';
            $platform = $context->preferred_platform ?? 'messenger';
            
            \App\Services\NotificationService::createForAdmins(
                'checkout_error',
                '❌ Erro no Checkout - ' . $customerName,
                "Cliente tentou finalizar pedido mas houve erro:\n\n" .
                "👤 Nome: {$customerName}\n" .
                "📱 Telefone: {$customerPhone}\n" .
                "🌐 Plataforma: {$platform}\n\n" .
                "❌ Erro: {$e->getMessage()}\n\n" .
                "⚠️ Entre em contato com o cliente!",
                [
                    'url' => route('admin.ai-agent.conversations'),
                    'customer_name' => $customerName,
                    'customer_phone' => $customerPhone,
                    'platform' => $platform,
                ]
            );
            
            return "❌ Erro ao processar pedido.\n\n" .
                   "Por favor, fale com nossa equipe:\n" .
                   "📱 WhatsApp: https://wa.me/244939729902";
        }
    }

    /**
     * Criar pedido no sistema
     */
    private function createOrder(AiCustomerContext $context, array $purchaseHistory): Order
    {
        $cart = $purchaseHistory['cart'];
        $checkoutData = $purchaseHistory['checkout_data'];
        
        // Criar ou buscar usuário
        $user = $this->createOrUpdateUser($checkoutData, $context);
        
        // Calcular totais
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }
        
        // Preparar endereços
        $shippingAddress = [
            'full_address' => $checkoutData['address'],
            'phone' => $checkoutData['phone'],
        ];
        
        $billingAddress = $shippingAddress; // Mesmo endereço por padrão
        
        // Criar pedido
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => $subtotal,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'shipping_amount' => 0,
            'total_amount' => $subtotal,
            'customer_name' => $checkoutData['name'] ?? $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $checkoutData['phone'],
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress,
            'payment_method' => 'cash_on_delivery',
            'notes' => 'Pedido via Messenger - ' . $context->preferred_platform,
            'is_pos_sale' => false,
        ]);
        
        // Adicionar itens do pedido
        foreach ($cart as $item) {
            $price = $item['price'] ?? 0;
            $quantity = $item['quantity'] ?? 1;
            $total = $price * $quantity;
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'] ?? 'Produto',
                'quantity' => $quantity,
                'price' => $price,
                'unit_price' => $price,
                'total_price' => $total,
                'subtotal' => $total,
            ]);
        }
        
        // Notificar admin sobre novo pedido
        $customerName = $checkoutData['name'] ?? $user->name;
        
        \Log::info('Tentando notificar admins sobre novo pedido', [
            'order_id' => $order->id,
            'order_number' => str_pad((string)$order->id, 6, '0', STR_PAD_LEFT),
            'customer' => $customerName,
            'total' => $order->total_amount
        ]);
        
        \App\Services\NotificationService::createForAdmins(
            'admin_new_order',
            '🛒 Novo Pedido via Messenger - #' . str_pad((string)$order->id, 6, '0', STR_PAD_LEFT),
            "Pedido criado via Messenger!\n\n" .
            "👤 Cliente: {$customerName}\n" .
            "📱 Telefone: {$checkoutData['phone']}\n" .
            "📍 Endereço: {$checkoutData['address']}\n\n" .
            "💰 Total: " . number_format((float)$order->total_amount, 2, ',', '.') . " Kz\n" .
            "📦 Itens: " . count($cart),
            [
                'url' => route('admin.orders.index'),
                'order_id' => $order->id,
            ]
        );
        
        \Log::info('Notificação de pedido enviada para admins');
        
        return $order;
    }

    /**
     * Criar ou recuperar usuário com dados mínimos
     */
    private function createOrUpdateUser(array $checkoutData, AiCustomerContext $context): User
    {
        // Gerar email baseado no telefone
        $email = 'messenger_' . preg_replace('/[^0-9]/', '', $checkoutData['phone']) . '@superloja.vip';
        
        // Buscar usuário existente por telefone
        $user = User::where('phone', $checkoutData['phone'])->first();
        
        if ($user) {
            // Usuário já existe, apenas retorna sem modificar
            \Log::info('Usuário recuperado para pedido', [
                'user_id' => $user->id,
                'phone' => $checkoutData['phone'],
                'name' => $user->name
            ]);
            
            return $user;
        }
        
        // Verificar se existe usuário com o email gerado
        $user = User::where('email', $email)->first();
        
        if ($user) {
            // Usuário existe com o email, retorna
            \Log::info('Usuário recuperado por email para pedido', [
                'user_id' => $user->id,
                'email' => $email
            ]);
            
            return $user;
        }
        
        // Criar novo usuário
        $newUser = User::create([
            'name' => $checkoutData['name'] ?? $context->customer_name ?? 'Cliente',
            'email' => $email,
            'phone' => $checkoutData['phone'],
            'password' => bcrypt(Str::random(32)), // Senha aleatória
            'email_verified_at' => now(), // Auto-verificado
            'is_active' => true,
        ]);
        
        \Log::info('Novo usuário criado para pedido', [
            'user_id' => $newUser->id,
            'email' => $email,
            'phone' => $checkoutData['phone']
        ]);
        
        return $newUser;
    }

    /**
     * Cancelar checkout e mostrar carrinho
     */
    private function cancelCheckout(AiCustomerContext $context, ?string $customerName): string
    {
        $purchaseHistory = $context->purchase_history ?? [];
        $cart = $purchaseHistory['cart'] ?? [];
        
        // Limpar processo de checkout
        $purchaseHistory['checkout_step'] = null;
        $purchaseHistory['checkout_data'] = [];
        $context->update(['purchase_history' => $purchaseHistory]);
        
        // Mostrar carrinho
        if (empty($cart)) {
            $name = $customerName ? " $customerName" : '';
            return "Checkout cancelado!\n\n" .
                   "Seu carrinho está vazio{$name}! 🛍️\n\n" .
                   "Digite 'produtos' para ver nossos produtos!";
        }
        
        $name = $customerName ? " $customerName" : '';
        $response = "❌ Checkout cancelado!\n\n";
        $response .= "🛍️ *Seu Carrinho*{$name}:\n\n";
        
        $total = 0;
        $totalItems = 0;
        
        foreach ($cart as $item) {
            $quantity = $item['quantity'] ?? 1;
            $price = $item['price'] ?? 0;
            $itemTotal = $quantity * $price;
            $total += $itemTotal;
            $totalItems += $quantity;
            
            $priceFormatted = number_format((float)$price, 2, ',', '.');
            $itemTotalFormatted = number_format((float)$itemTotal, 2, ',', '.');
            
            $response .= "📦 *{$item['product_name']}*\n";
            $response .= "   Quantidade: {$quantity}x\n";
            $response .= "   Preço: {$priceFormatted} Kz cada\n";
            $response .= "   Subtotal: {$itemTotalFormatted} Kz\n\n";
        }
        
        $totalFormatted = number_format((float)$total, 2, ',', '.');
        
        $response .= "━━━━━━━━━━━━━━━━\n";
        $response .= "📊 *Total de itens:* {$totalItems}\n";
        $response .= "💰 *Total:* {$totalFormatted} Kz\n\n";
        $response .= "━━━━━━━━━━━━━━━━\n";
        $response .= "O que deseja fazer agora?\n\n";
        $response .= "✅ Digite 'finalizar' - Concluir pedido\n";
        $response .= "🔍 Digite 'produtos' - Adicionar mais itens\n";
        $response .= "🗑️ Digite 'cancelar' - Limpar carrinho\n";
        $response .= "💬 Fale com equipe: https://wa.me/244939729902";
        
        return $response;
    }

    /**
     * Verificar se está em processo de checkout
     */
    public function isInCheckout(AiCustomerContext $context): bool
    {
        $purchaseHistory = $context->purchase_history ?? [];
        $checkoutStep = $purchaseHistory['checkout_step'] ?? null;
        
        return in_array($checkoutStep, ['awaiting_name', 'awaiting_phone', 'awaiting_address']);
    }
}
