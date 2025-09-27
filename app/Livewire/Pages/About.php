<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class About extends Component
{
    public function render()
    {
        return view('livewire.pages.about')->layout('layouts.app', [
            'title' => 'Sobre Nós - SuperLoja Angola'
        ]);
    }
}
