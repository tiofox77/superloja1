<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Dashboard;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Carbon\Carbon;

class AdminDashboard extends Component
{
    public $dateFilter = '30'; // Last 30 days by default
    public $selectedPeriod = 'Este Mês';

    public function render()
    {
        // Calculate date range based on filter
        $startDate = $this->getStartDate();
        $endDate = now();

        // General Statistics
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
            'total_users' => User::where('role', 'customer')->count(),
            'total_orders' => 0, // Order::count(), - Will be implemented when Order model is ready
            'pending_orders' => 0, // Order::where('status', 'pending')->count(),
            'low_stock_products' => Product::where('stock_quantity', '<=', 10)->count(),
        ];

        // Recent Activities
        $recentProducts = Product::with(['category', 'brand'])
            ->latest()
            ->take(5)
            ->get();

        $recentOrders = collect(); // Order::with('user')->latest()->take(5)->get();

        // Charts Data (for future implementation)
        $salesData = $this->getSalesData($startDate, $endDate);
        $topCategories = $this->getTopCategories();
        $topProducts = $this->getTopProducts();

        return view('livewire.admin.dashboard.admin-dashboard', [
            'stats' => $stats,
            'recentProducts' => $recentProducts,
            'recentOrders' => $recentOrders,
            'salesData' => $salesData,
            'topCategories' => $topCategories,
            'topProducts' => $topProducts,
        ])->layout('components.layouts.admin', [
            'title' => 'Dashboard Admin',
            'pageTitle' => 'Dashboard'
        ]);
    }

    public function setDateFilter($days): void
    {
        $this->dateFilter = $days;
        
        match($days) {
            '7' => $this->selectedPeriod = 'Últimos 7 Dias',
            '30' => $this->selectedPeriod = 'Este Mês',
            '90' => $this->selectedPeriod = 'Últimos 3 Meses',
            '365' => $this->selectedPeriod = 'Este Ano',
            default => $this->selectedPeriod = 'Período Personalizado'
        };
    }

    private function getStartDate(): Carbon
    {
        return match($this->dateFilter) {
            '7' => now()->subDays(7),
            '30' => now()->subDays(30),
            '90' => now()->subDays(90),
            '365' => now()->subYear(),
            default => now()->subDays(30)
        };
    }

    private function getSalesData($startDate, $endDate): array
    {
        // This would be implemented when orders system is ready
        return [
            'total_sales' => 0,
            'total_revenue' => 0,
            'average_order' => 0,
            'conversion_rate' => 0,
        ];
    }

    private function getTopCategories(): array
    {
        return Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get()
            ->toArray();
    }

    private function getTopProducts(): array
    {
        return Product::with(['category', 'brand'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->toArray();
    }

    public function refreshData(): void
    {
        $this->dispatch('dataRefreshed');
        session()->flash('success', 'Dados atualizados!');
    }
}
