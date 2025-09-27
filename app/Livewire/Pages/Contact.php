<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class Contact extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email',
        'phone' => 'required|string|min:9',
        'subject' => 'required|string|min:5',
        'message' => 'required|string|min:10',
    ];

    protected $messages = [
        'name.required' => 'O nome é obrigatório.',
        'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
        'email.required' => 'O email é obrigatório.',
        'email.email' => 'Por favor, insira um email válido.',
        'phone.required' => 'O telefone é obrigatório.',
        'phone.min' => 'O telefone deve ter pelo menos 9 dígitos.',
        'subject.required' => 'O assunto é obrigatório.',
        'subject.min' => 'O assunto deve ter pelo menos 5 caracteres.',
        'message.required' => 'A mensagem é obrigatória.',
        'message.min' => 'A mensagem deve ter pelo menos 10 caracteres.',
    ];

    public function submitContact()
    {
        $this->validate();

        try {
            // Aqui você pode implementar o envio de email
            // Por enquanto, vamos simular o envio
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Mensagem enviada com sucesso! Entraremos em contacto em breve.'
            ]);

            // Reset form
            $this->reset(['name', 'email', 'phone', 'subject', 'message']);

        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao enviar mensagem. Tente novamente.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pages.contact')->layout('layouts.app', [
            'title' => 'Contacto - SuperLoja Angola'
        ]);
    }
}
