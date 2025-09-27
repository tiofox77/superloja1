<?php

declare(strict_types=1);

namespace App\Livewire\Layout;

use Livewire\Component;

class Navbar extends Component
{
    public string $search = '';
    public bool $mobileMenuOpen = false;

    protected $listeners = [
        'cart-updated' => '$refresh'
    ];

    public function updatedSearch(): void
    {
        if (strlen($this->search) >= 2) {
            $this->dispatch('search-updated', search: $this->search);
        }
    }

    public function toggleMobileMenu(): void
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }

    public function toggleFavorites(): void
    {
        $this->dispatch('show-notification', message: 'Página de favoritos em breve!', type: 'success');
    }

    public function render()
    {
        return view('livewire.layout.navbar');
    }
}
