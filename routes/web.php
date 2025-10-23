<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Categories\CategoryManager;
use App\Livewire\Admin\Products\ProductManager;
use App\Livewire\Admin\Brands\BrandManager;
use App\Livewire\Admin\Dashboard\AdminDashboard;
use App\Livewire\Admin\Auctions\AuctionManager;
use App\Livewire\Admin\ProductRequests\ProductRequestManager;
use App\Livewire\Admin\Users\UserManager;
use App\Livewire\Admin\Catalog\CatalogGenerator;
use App\Livewire\Admin\SocialMedia\SocialMediaManager;
use App\Livewire\Admin\Orders\OrderManager;
use App\Livewire\Admin\Pos\PosSystem;
use App\Livewire\Admin\SocialMedia\SocialMediaConfig;
use App\Livewire\Admin\SocialMedia\BannerGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Home page
Route::get('/', function () {
    $stats = [
        'products' => \App\Models\Product::where('is_active', true)->count(),
        'categories' => \App\Models\Category::where('is_active', true)->count(),
        'brands' => \App\Models\Brand::where('is_active', true)->count(),
    ];
    
    return view('home', compact('stats'));
})->name('home');

// Test page for modal and notifications
Route::get('/test-modal', function () {
    return view('test-modal');
})->name('test-modal');

// Main pages - Redirected to Health & Wellness
Route::get('/categorias', function () {
    // Buscar categoria "Saúde e Bem-estar" e suas subcategorias
    $healthCategory = \App\Models\Category::with(['children' => function($query) {
        $query->where('is_active', true)->orderBy('name');
    }])->where('name', 'Saúde e Bem-estar')
      ->where('is_active', true)
      ->first();
    
    return view('health-wellness', compact('healthCategory'));
})->name('categories');

Route::get('/produtos', \App\Livewire\Pages\ProductsPage::class)->name('products');

// Rota para produto individual
Route::get('/produto/{id}', function ($id) {
    $product = \App\Models\Product::with(['category', 'brand'])->findOrFail($id);
    return view('product-detail', compact('product'));
})->name('product.show');

Route::get('/ofertas', function () {
    $offers = \App\Models\Product::with(['category', 'brand'])
        ->where('is_active', true)
        ->where(function ($query) {
            $query->whereNotNull('sale_price')
                  ->where('sale_price', '>', 0);
        })
        ->orWhere('is_featured', true)
        ->paginate(12);
    
    return view('offers', compact('offers'));
})->name('offers');

Route::get('/marcas', function () {
    $brands = \App\Models\Brand::with(['products' => function ($query) {
            $query->where('is_active', true);
        }])
        ->withCount(['products as products_count' => function ($query) {
            $query->where('is_active', true);
        }])
        ->get();
    
    return view('brands', compact('brands'));
})->name('brands');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Additional pages
Route::get('/health-wellness', App\Livewire\Pages\HealthWellness::class)->name('health.wellness');
Route::get('/saude-bem-estar', App\Livewire\Pages\HealthWellness::class)->name('health.wellness.pt');

// Rota temporária para testar notificações
Route::get('/test-notifications', function () {
    if (auth()->check()) {
        \App\Services\NotificationService::orderStatusUpdated(auth()->id(), 'ORD001', 'shipped', 1);
        \App\Services\NotificationService::productRequestSubmitted(auth()->id(), 'iPhone 15 Pro', 1);
        \App\Services\NotificationService::auctionStatusUpdated(auth()->id(), 'Leilão Eletrônicos', 'won', 1);
        return 'Notificações de teste criadas! Recarregue a página para ver.';
    }
    return 'Você precisa estar logado para testar as notificações.';
})->name('test.notifications');

// Rota temporária para verificar produtos importados
Route::get('/check-products', function () {
    try {
        $total = \App\Models\Product::count();
        $recent = \App\Models\Product::with(['category', 'brand'])->latest()->take(10)->get();
        
        $html = "<!DOCTYPE html><html><head><title>Produtos Importados</title>";
        $html .= "<style>body{font-family:Arial;margin:20px;} li{margin:10px 0;padding:10px;border:1px solid #ddd;border-radius:8px;}</style></head><body>";
        $html .= "<h1>✅ Produtos Importados da SuperLoja.vip</h1>";
        $html .= "<p><strong>📊 Total de produtos:</strong> {$total}</p>";
        $html .= "<h2>📦 Produtos Recentes:</h2><ul style='list-style:none;padding:0;'>";
        
        foreach ($recent as $product) {
            // Tratamento seguro dos preços
            $priceValue = is_numeric($product->price) ? (float)$product->price : 0;
            $salePriceValue = $product->sale_price && is_numeric($product->sale_price) ? (float)$product->sale_price : null;
            
            $price = number_format($priceValue, 2, ',', '.');
            $salePrice = $salePriceValue ? number_format($salePriceValue, 2, ',', '.') : 'N/A';
            
            $category = $product->category ? $product->category->name : 'Sem categoria';
            $brand = $product->brand ? $product->brand->name : 'Sem marca';
            
            // Card do produto
            $html .= "<li style='background:#f9f9f9;'>";
            
            // Imagem do produto
            if ($product->featured_image) {
                $imageUrl = asset('storage/' . $product->featured_image);
                $html .= "<img src='{$imageUrl}' alt='{$product->name}' style='width:120px;height:120px;object-fit:cover;border-radius:8px;float:left;margin-right:15px;'>";
            }
            
            $html .= "<div>";
            $html .= "<h3 style='margin:0 0 5px 0;color:#333;'>{$product->name}</h3>";
            $html .= "<p style='margin:2px 0;color:#666;'><strong>SKU:</strong> {$product->sku}</p>";
            $html .= "<p style='margin:2px 0;color:#666;'><strong>Categoria:</strong> {$category} | <strong>Marca:</strong> {$brand}</p>";
            
            // Preços com destaque
            if ($salePriceValue && $salePriceValue < $priceValue) {
                $html .= "<p style='margin:5px 0;'>";
                $html .= "<span style='text-decoration:line-through;color:#999;'>{$price} Kz</span> ";
                $html .= "<span style='color:#e74c3c;font-weight:bold;font-size:1.1em;'>{$salePrice} Kz</span>";
                $html .= "</p>";
            } else {
                $html .= "<p style='margin:5px 0;color:#2c3e50;font-weight:bold;font-size:1.1em;'>{$price} Kz</p>";
            }
            
            $html .= "<p style='margin:2px 0;color:#27ae60;'><strong>Stock:</strong> {$product->stock_quantity} unidades</p>";
            
            // Status
            $featuredBadge = $product->is_featured ? "<span style='background:#f39c12;color:white;padding:2px 6px;border-radius:4px;font-size:0.8em;'>⭐ Featured</span>" : "";
            $activeBadge = $product->is_active ? "<span style='background:#27ae60;color:white;padding:2px 6px;border-radius:4px;font-size:0.8em;'>✅ Ativo</span>" : "<span style='background:#e74c3c;color:white;padding:2px 6px;border-radius:4px;font-size:0.8em;'>❌ Inativo</span>";
            
            $html .= "<p style='margin:5px 0;'>{$activeBadge} {$featuredBadge}</p>";
            $html .= "</div>";
            $html .= "<div style='clear:both;'></div>";
            $html .= "</li>";
        }
        
        $html .= "</ul>";
        
        // Estatísticas por categoria
        $categoriesStats = \App\Models\Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(*) as total')
            ->groupBy('categories.name')
            ->get();
            
        $html .= "<h2>📈 Estatísticas por Categoria:</h2><ul>";
        foreach ($categoriesStats as $stat) {
            $html .= "<li><strong>{$stat->name}:</strong> {$stat->total} produtos</li>";
        }
        $html .= "</ul>";
        
        $html .= "</body></html>";
        return $html;
        
    } catch (\Exception $e) {
        return "<h1>❌ Erro</h1><p>Erro ao carregar produtos: " . $e->getMessage() . "</p>";
    }
})->name('check.products');

Route::get('/leiloes', function () {
    $auctions = \App\Models\Auction::with(['product'])
        ->where('status', 'active')
        ->where('end_time', '>', now())
        ->paginate(12);
    
    return view('auctions', compact('auctions'));
})->name('auctions');

Route::get('/solicitar-produto', function () {
    return view('request-product');
})->name('request.product');

// Temporary route for isolated Livewire upload testing
Route::get('/test-upload', function () {
    return view('test-upload');
})->name('test.upload');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard (Livewire)
    Route::get('/', AdminDashboard::class)->name('dashboard');
    
    // Categories Management (Livewire)
    Route::get('/categories', CategoryManager::class)->name('categories.index');
    
    // Products Management (Livewire)
    Route::get('/products', ProductManager::class)->name('products.index');
    
    // Products Import
    Route::get('/products/import', App\Livewire\Admin\Products\ProductImporter::class)->name('products.import');
    
    // Products Export Routes
    Route::get('/products/export/pdf', [App\Http\Controllers\Admin\ProductExportController::class, 'exportPdf'])->name('products.export-pdf');
    Route::get('/products/export/csv', [App\Http\Controllers\Admin\ProductExportController::class, 'exportCsv'])->name('products.export-csv');
    
    // Brands Management (Livewire)
    Route::get('/brands', BrandManager::class)->name('brands.index');
    
    // Auctions Management (Livewire)
    Route::get('/auctions', AuctionManager::class)->name('auctions.index');
    
    // Product Requests Management (Livewire)
    Route::get('/product-requests', ProductRequestManager::class)->name('product-requests.index');
    
    // Users Management (Livewire)
    Route::get('/users', UserManager::class)->name('users.index');
    
    // Catalog Generator (Livewire)
    Route::get('/catalog', CatalogGenerator::class)->name('catalog.index');
    
    // Social Media Management (Livewire)
    Route::get('/social-media', SocialMediaManager::class)->name('social-media.index');
    Route::get('/social-media/config', SocialMediaConfig::class)->name('social-media.config');
    Route::get('/social-media/banners', BannerGenerator::class)->name('social-media.banners');
    
    // Orders Management (Livewire)
    Route::get('/orders', OrderManager::class)->name('orders.index');
    
    // Order Export Routes
    Route::get('/orders/export/pdf', [App\Http\Controllers\Admin\OrderExportController::class, 'exportPdf'])->name('orders.export-pdf');
    Route::get('/orders/export/csv', [App\Http\Controllers\Admin\OrderExportController::class, 'exportCsv'])->name('orders.export-csv');
    
    // SMS Management (Livewire)
    Route::get('/sms', App\Livewire\Admin\Sms\SmsManager::class)->name('sms.index');
    
    // Settings Management (Livewire)
    Route::get('/settings', App\Livewire\Admin\Settings\SettingsManager::class)->name('settings.index');
    
    // System Updater (Livewire)
    Route::get('/system/update', App\Livewire\Admin\System\SystemUpdater::class)->name('system.update');
    
    // Order Payment Proof Routes
    Route::get('/orders/{order}/proof/download', [App\Http\Controllers\Admin\OrderProofController::class, 'download'])->name('orders.download-proof');
    Route::get('/orders/{order}/proof/view', [App\Http\Controllers\Admin\OrderProofController::class, 'view'])->name('orders.view-proof');
    
    // POS System (Livewire)
    Route::get('/pos', App\Livewire\Admin\Pos\PosSystem::class)->name('pos.index');
    
    // AI Agent Routes
    Route::prefix('ai-agent')->name('ai-agent.')->group(function () {
        Route::get('/', App\Livewire\Admin\AiAgent\AgentDashboard::class)->name('dashboard');
        Route::get('/insights', App\Livewire\Admin\AiAgent\ProductInsights::class)->name('insights');
        Route::get('/conversations', App\Livewire\Admin\AiAgent\ConversationManager::class)->name('conversations');
        Route::get('/posts', App\Livewire\Admin\AiAgent\PostScheduler::class)->name('posts');
        Route::get('/carousels', App\Livewire\Admin\AiAgent\CarouselManager::class)->name('carousels');
        Route::get('/knowledge', App\Livewire\Admin\AiAgent\KnowledgeCenter::class)->name('knowledge');
        Route::get('/diagnostic-logs', App\Livewire\Admin\AiAgent\DiagnosticLogs::class)->name('diagnostic-logs');
        Route::get('/notifications', App\Livewire\Admin\AiAgent\NotificationChannels::class)->name('notifications');
        Route::get('/settings', App\Livewire\Admin\AiAgent\AgentSettings::class)->name('settings');
    });
});

// User/Customer Dashboard Routes
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // User Dashboard
    Route::get('/', \App\Livewire\User\Dashboard::class)->name('dashboard');
    
    // User Profile
    Route::get('/profile', \App\Livewire\User\Profile::class)->name('profile');
    
    // User Orders
    Route::get('/orders', \App\Livewire\User\Orders::class)->name('orders');
    
    // User Wishlist
    Route::get('/wishlist', \App\Livewire\User\Wishlist::class)->name('wishlist');
});

// Cart API Routes
Route::prefix('api/cart')->group(function () {
    Route::get('/items', [App\Http\Controllers\Api\CartController::class, 'getItems']);
    Route::post('/update', [App\Http\Controllers\Api\CartController::class, 'updateCart']);
    Route::post('/add', [App\Http\Controllers\Api\CartController::class, 'addItem']);
    Route::delete('/remove', [App\Http\Controllers\Api\CartController::class, 'removeItem']);
    Route::delete('/clear', [App\Http\Controllers\Api\CartController::class, 'clearCart']);
});

// Laravel Auth Routes (adicionadas pelo Laravel UI)

// Explicit logout route to support POST logout from header/menu
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');
// Dashboard routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('user.home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('user.dashboard.home');

// Missing routes for footer/header links
// Contact page
Route::get('/contacto', \App\Livewire\Pages\Contact::class)->name('contact');

// About page
Route::get('/sobre', \App\Livewire\Pages\About::class)->name('about');

// FAQ page
Route::get('/faq', \App\Livewire\Pages\Faq::class)->name('faq');

// Privacy Policy page
Route::get('/politica-privacidade', \App\Livewire\Pages\PrivacyPolicy::class)->name('privacy-policy');

// Terms of Service page
Route::get('/termos-uso', \App\Livewire\Pages\TermsOfService::class)->name('terms-of-service');

// Return Policy page
Route::get('/politica-devolucao', \App\Livewire\Pages\ReturnPolicy::class)->name('return-policy');

// Product Request page
Route::get('/solicitar-produto', \App\Livewire\Pages\ProductRequest::class)->name('product-request');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', \App\Livewire\Pages\Checkout::class)->name('checkout');
});

// Include authentication routes
require __DIR__.'/auth.php';
