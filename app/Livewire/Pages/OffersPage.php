<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Ofertas - SuperLoja')]
class OffersPage extends Component
{
    public function render()
    {
        return view('livewire.pages.offers')
            ->layout('layouts.app');
    }
}
