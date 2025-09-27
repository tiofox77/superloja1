<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use App\Models\Auction;
use App\Models\Product;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        // Estatísticas do usuário
        $stats = [
            'orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pending')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'delivered')->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('payment_status', 'paid')->sum('total_amount'),
        ];
        
        // Pedidos recentes
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Leilões ativos (se houver)
        $activeAuctions = Auction::where('status', 'active')
            ->where('end_time', '>', now())
            ->with('product')
            ->orderBy('end_time', 'asc')
            ->limit(3)
            ->get();

        return view('livewire.user.dashboard', compact('stats', 'recentOrders', 'activeAuctions'))
            ->layout('layouts.app')
            ->title('Minha Conta - SuperLoja');
    }
}
