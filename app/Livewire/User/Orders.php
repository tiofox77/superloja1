<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class Orders extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user.orders', compact('orders'))
            ->layout('layouts.app')
            ->title('Meus Pedidos - SuperLoja');
    }
}
