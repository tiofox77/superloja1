<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Faq extends Component
{
    public $openFaq = [];

    public function toggleFaq($index)
    {
        if (isset($this->openFaq[$index])) {
            unset($this->openFaq[$index]);
        } else {
            $this->openFaq[$index] = true;
        }
    }

    public function render()
    {
        return view('livewire.pages.faq')->layout('layouts.app', [
            'title' => 'Perguntas Frequentes - SuperLoja Angola'
        ]);
    }
}
