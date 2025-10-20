<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ReturnPolicy extends Component
{
    public function render()
    {
        return view('livewire.pages.return-policy')
            ->layout('layouts.app')
            ->title('Política de Devolução - SuperLoja Angola');
    }
}
