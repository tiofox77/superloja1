<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $product_name = '';
    public $product_description = '';
    public $product_category = '';
    public $preferred_price = '';
    public $quantity = '';
    public $urgency = '';
    public $additional_info = '';

    public function mount()
    {
        // Se o usuário estiver logado, preencher dados automaticamente
        if (Auth::check()) {
            $user = Auth::user();
            
            // Preencher nome - usar first_name + last_name se disponível, senão usar name
            if (!empty($user->first_name) && !empty($user->last_name)) {
                $this->name = $user->first_name . ' ' . $user->last_name;
            } elseif (!empty($user->name)) {
                $this->name = $user->name;
            }
            
            // Preencher email
            $this->email = $user->email;
            
            // Preencher telefone se disponível
            if (!empty($user->phone)) {
                $this->phone = $user->phone;
            }
        }
    }

    protected $rules = [
        'name' => 'required|min:2|max:100',
        'email' => 'required|email|max:255',
        'phone' => 'required|min:9|max:15',
        'product_name' => 'required|min:3|max:255',
        'product_description' => 'required|min:10|max:1000',
        'product_category' => 'required',
        'preferred_price' => 'nullable|numeric|min:0',
        'quantity' => 'required|integer|min:1',
        'urgency' => 'required',
        'additional_info' => 'nullable|max:500',
    ];

    protected $messages = [
        'name.required' => 'Nome é obrigatório',
        'name.min' => 'Nome deve ter pelo menos 2 caracteres',
        'email.required' => 'Email é obrigatório',
        'email.email' => 'Email deve ser válido',
        'phone.required' => 'Telefone é obrigatório',
        'phone.min' => 'Telefone deve ter pelo menos 9 dígitos',
        'product_name.required' => 'Nome do produto é obrigatório',
        'product_name.min' => 'Nome do produto deve ter pelo menos 3 caracteres',
        'product_description.required' => 'Descrição do produto é obrigatória',
        'product_description.min' => 'Descrição deve ter pelo menos 10 caracteres',
        'product_category.required' => 'Categoria é obrigatória',
        'preferred_price.numeric' => 'Preço deve ser um número',
        'preferred_price.min' => 'Preço deve ser maior que zero',
        'quantity.required' => 'Quantidade é obrigatória',
        'quantity.integer' => 'Quantidade deve ser um número inteiro',
        'quantity.min' => 'Quantidade deve ser pelo menos 1',
        'urgency.required' => 'Urgência é obrigatória',
        'additional_info.max' => 'Informações adicionais não podem exceder 500 caracteres',
    ];

    public function submitRequest()
    {
        $this->validate();

        // Create WhatsApp message
        $whatsappMessage = "🛒 *SOLICITAÇÃO DE PRODUTO*\n\n";
        $whatsappMessage .= "👤 *Cliente:* {$this->name}\n";
        $whatsappMessage .= "📧 *Email:* {$this->email}\n";
        $whatsappMessage .= "📱 *Telefone:* {$this->phone}\n\n";
        $whatsappMessage .= "🏷️ *Produto Solicitado:* {$this->product_name}\n";
        $whatsappMessage .= "📝 *Descrição:* {$this->product_description}\n";
        $whatsappMessage .= "📂 *Categoria:* {$this->product_category}\n";
        $whatsappMessage .= "💰 *Preço Preferido:* " . ($this->preferred_price ? number_format((float)$this->preferred_price, 2, ',', '.') . " AOA" : "Não especificado") . "\n";
        $whatsappMessage .= "📦 *Quantidade:* {$this->quantity}\n";
        $whatsappMessage .= "⏰ *Urgência:* {$this->urgency}\n";
        
        if ($this->additional_info) {
            $whatsappMessage .= "\n💬 *Informações Adicionais:*\n{$this->additional_info}";
        }

        $whatsappUrl = "https://wa.me/244939729902?text=" . urlencode($whatsappMessage);

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Solicitação preparada! Você será redirecionado para o WhatsApp.'
        ]);

        // Reset apenas os campos do produto, mantendo dados do usuário
        $this->reset([
            'product_name',
            'product_description', 
            'product_category',
            'preferred_price',
            'quantity',
            'urgency',
            'additional_info'
        ]);

        // Redirect to WhatsApp
        return redirect()->away($whatsappUrl);
    }

    public function render()
    {
        return view('livewire.pages.product-request')
            ->layout('layouts.app')
            ->title('Solicitar Produto - SuperLoja Angola');
    }
}
