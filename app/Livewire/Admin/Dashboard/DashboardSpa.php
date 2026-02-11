<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Dashboard;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Carbon\Carbon;

#[Layout('components.admin.layouts.app')]
#[Title('Dashboard')]
class DashboardSpa extends Component
{
    public function render()
    {
        // Stats - with try-catch for safety
        try {
            $salesToday = Order::whereDate('created_at', today())->sum('total_amount') ?? 0;
            $salesYesterday = Order::whereDate('created_at', today()->subDay())->sum('total_amount') ?? 0;
            $ordersToday = Order::whereDate('created_at', today())->count();
            $ordersYesterday = Order::whereDate('created_at', today()->subDay())->count();
        } catch (\Exception $e) {
            $salesToday = 0;
            $salesYesterday = 0;
            $ordersToday = 0;
            $ordersYesterday = 0;
        }
        
        $salesTrend = $salesYesterday > 0 ? (($salesToday - $salesYesterday) / $salesYesterday * 100) : 0;
        $ordersTrend = $ordersYesterday > 0 ? (($ordersToday - $ordersYesterday) / $ordersYesterday * 100) : 0;
        
        // Chart data - Last 7 days
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            try {
                $chartData[] = Order::whereDate('created_at', $date)->sum('total_amount') ?? 0;
            } catch (\Exception $e) {
                $chartData[] = 0;
            }
        }
        
        // Recent activities
        $recentActivities = collect();
        
        // Add recent orders
        try {
            $recentOrders = Order::latest()->take(3)->get();
            foreach ($recentOrders as $order) {
                $recentActivities->push([
                    'type' => 'order',
                    'icon' => 'shopping-cart',
                    'title' => "Novo pedido #{$order->id}",
                    'time' => $order->created_at->diffForHumans(),
                ]);
            }
        } catch (\Exception $e) {
            // Ignore order errors
        }
        
        // Add recent products
        try {
            $recentProducts = Product::latest()->take(2)->get();
            foreach ($recentProducts as $product) {
                $recentActivities->push([
                    'type' => 'product',
                    'icon' => 'package',
                    'title' => "Produto: {$product->name}",
                    'time' => $product->created_at->diffForHumans(),
                ]);
            }
        } catch (\Exception $e) {
            // Ignore product errors
        }
        
        $recentActivities = $recentActivities->sortByDesc('time')->take(5);
        
        // Pending orders
        try {
            $pendingOrders = Order::where('status', 'pending')->latest()->take(5)->get();
        } catch (\Exception $e) {
            $pendingOrders = collect();
        }
        
        // Low stock products
        try {
            $lowStockProducts = Product::where('stock_quantity', '<=', 10)
                                       ->where('stock_quantity', '>', 0)
                                       ->orderBy('stock_quantity')
                                       ->take(5)
                                       ->get();
        } catch (\Exception $e) {
            $lowStockProducts = collect();
        }
        
        return view('livewire.admin.dashboard.index', [
            'salesToday' => $salesToday,
            'salesTrend' => $salesTrend >= 0 ? 'up' : 'down',
            'salesTrendValue' => abs(round($salesTrend, 1)) . '%',
            
            'ordersCount' => $ordersToday,
            'ordersTrend' => $ordersTrend >= 0 ? 'up' : 'down',
            'ordersTrendValue' => abs(round($ordersTrend, 1)) . '%',
            
            'productsCount' => Product::where('is_active', true)->count(),
            'customersCount' => User::where('role', 'customer')->count(),
            
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            
            'recentActivities' => $recentActivities,
            'pendingOrders' => $pendingOrders,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}
