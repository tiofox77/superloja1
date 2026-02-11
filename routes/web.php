<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Categories\CategoryManager;
use App\Livewire\Admin\Products\ProductManager;
use App\Livewire\Admin\Brands\BrandManager;
use App\Livewire\Admin\Dashboard\AdminDashboard;
use App\Livewire\Admin\Dashboard\DashboardSpa;
use App\Livewire\Admin\Products\ProductsSpa;
use App\Livewire\Admin\Orders\OrdersSpa;
use App\Livewire\Admin\Settings\SettingsSpa;
use App\Livewire\Admin\Users\UsersSpa;
use App\Livewire\Admin\Categories\CategoriesSpa;
use App\Livewire\Admin\Brands\BrandsSpa;
use App\Livewire\Admin\Catalog\CatalogSpa;
use App\Livewire\Admin\Auctions\AuctionsSpa;
use App\Livewire\Admin\ProductRequests\ProductRequestsSpa;
use App\Livewire\Admin\Sms\SmsSpa;
use App\Livewire\Admin\Pos\PosSpa;
use App\Livewire\Admin\Auctions\AuctionManager;
use App\Livewire\Admin\ProductRequests\ProductRequestManager;
use App\Livewire\Admin\Users\UserManager;
use App\Livewire\Admin\Catalog\CatalogGenerator;
use App\Livewire\Admin\Orders\OrderManager;
use App\Livewire\Admin\Pos\PosSystem;
use App\Livewire\Admin\Products\ImporterSpa;
use App\Livewire\Admin\System\UpdaterSpa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Home page (Livewire SPA)
Route::get('/', App\Livewire\Pages\HomePage::class)->name('home');

// Test page for modal and notifications
Route::get('/test-modal', function () {
    return view('test-modal');
})->name('test-modal');

// Main pages
Route::get('/categorias', App\Livewire\Pages\HealthWellness::class)->name('categories');

Route::get('/produtos', \App\Livewire\Pages\ProductsPage::class)->name('products');

// Rota para produto individual (Livewire SPA)
Route::get('/produto/{id}', App\Livewire\Pages\ProductShow::class)->name('product.show');

// Ofertas (Livewire SPA)
Route::get('/ofertas', App\Livewire\Pages\OffersPage::class)->name('offers');

// Marcas (Livewire SPA)
Route::get('/marcas', App\Livewire\Pages\BrandsPage::class)->name('brands');

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

// Leilões (Livewire SPA)
Route::get('/leiloes', App\Livewire\Pages\AuctionsPage::class)->name('auctions');

Route::get('/solicitar-produto-old', function () {
    return view('request-product');
})->name('request.product.old');

// Temporary route for isolated Livewire upload testing
Route::get('/test-upload', function () {
    return view('test-upload');
})->name('test.upload');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard SPA (New)
    Route::get('/', DashboardSpa::class)->name('dashboard');
    
    // Dashboard Legacy
    Route::get('/dashboard-old', AdminDashboard::class)->name('dashboard.old');
    
    // Categories Management (Livewire SPA)
    Route::get('/categories', CategoriesSpa::class)->name('categories.index');
    Route::get('/categories-old', CategoryManager::class)->name('categories.old');
    
    // Products Management (Livewire SPA)
    // IMPORTANTE: Rotas específicas devem vir ANTES das rotas com parâmetros
    Route::get('/products/import', ImporterSpa::class)->name('products.import');
    Route::get('/products/import-old', App\Livewire\Admin\Products\ProductImporter::class)->name('products.import.old');
    Route::get('/products/export/pdf', [App\Http\Controllers\Admin\ProductExportController::class, 'exportPdf'])->name('products.export-pdf');
    Route::get('/products/export/csv', [App\Http\Controllers\Admin\ProductExportController::class, 'exportCsv'])->name('products.export-csv');
    Route::get('/products', ProductsSpa::class)->name('products.index');
    Route::get('/products-old', ProductManager::class)->name('products.old');
    // Create/Edit via modal - sem rotas separadas
    
    // Brands Management (Livewire SPA)
    Route::get('/brands', BrandsSpa::class)->name('brands.index');
    Route::get('/brands-old', BrandManager::class)->name('brands.old');
    
    // Auctions Management (Livewire SPA)
    Route::get('/auctions', AuctionsSpa::class)->name('auctions.index');
    Route::get('/auctions-old', AuctionManager::class)->name('auctions.old');
    
    // Product Requests Management (Livewire SPA)
    Route::get('/product-requests', ProductRequestsSpa::class)->name('product-requests.index');
    Route::get('/product-requests-old', ProductRequestManager::class)->name('product-requests.old');
    
    // Users Management (Livewire SPA)
    Route::get('/users', UsersSpa::class)->name('users.index');
    Route::get('/users-old', UserManager::class)->name('users.old');
    
    // Catalog Generator (Livewire SPA)
    Route::get('/catalog', CatalogSpa::class)->name('catalog.index');
    Route::get('/catalog-old', CatalogGenerator::class)->name('catalog.old');
    
    // Orders Management (Livewire SPA)
    Route::get('/orders', OrdersSpa::class)->name('orders.index');
    Route::get('/orders/create', PosSystem::class)->name('orders.create'); // Redireciona para PDV
    Route::get('/orders-old', OrderManager::class)->name('orders.old');
    
    // Order Export Routes
    Route::get('/orders/export/pdf', [App\Http\Controllers\Admin\OrderExportController::class, 'exportPdf'])->name('orders.export-pdf');
    Route::get('/orders/export/csv', [App\Http\Controllers\Admin\OrderExportController::class, 'exportCsv'])->name('orders.export-csv');
    
    // SMS Management (Livewire SPA)
    Route::get('/sms', SmsSpa::class)->name('sms.index');
    Route::get('/sms-old', App\Livewire\Admin\Sms\SmsManager::class)->name('sms.old');
    
    // Settings Management (Livewire SPA)
    Route::get('/settings', SettingsSpa::class)->name('settings.index');
    Route::get('/settings-old', App\Livewire\Admin\Settings\SettingsManager::class)->name('settings.old');
    
    // System Updater (Livewire SPA)
    Route::get('/system/update', UpdaterSpa::class)->name('system.update');
    Route::get('/system/update-old', App\Livewire\Admin\System\SystemUpdater::class)->name('system.update.old');
    
    // Order Payment Proof Routes
    Route::get('/orders/{order}/proof/download', [App\Http\Controllers\Admin\OrderProofController::class, 'download'])->name('orders.download-proof');
    Route::get('/orders/{order}/proof/view', [App\Http\Controllers\Admin\OrderProofController::class, 'view'])->name('orders.view-proof');
    
    // POS System (Livewire SPA)
    Route::get('/pos', PosSpa::class)->name('pos.index');
    Route::get('/pos-old', PosSystem::class)->name('pos.old');
    
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
