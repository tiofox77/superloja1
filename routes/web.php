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
Route::get('/saude-bem-estar', function () {
    // Buscar categoria "Saúde e Bem-estar" e suas subcategorias
    $healthCategory = \App\Models\Category::with(['children' => function($query) {
        $query->where('is_active', true)->orderBy('name');
    }])->where('name', 'Saúde e Bem-estar')
      ->where('is_active', true)
      ->first();
    
    return view('health-wellness', compact('healthCategory'));
})->name('health.wellness');

Route::get('/leiloes', function () {
    $auctions = \App\Models\Auction::with(['product'])
        ->where('status', 'active')
        ->where('end_time', '>', now())
        ->orderBy('end_time', 'asc')
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
    
    // Orders Export Routes
    Route::get('/orders/export/pdf', [App\Http\Controllers\Admin\OrderExportController::class, 'exportPdf'])->name('orders.export-pdf');
    Route::get('/orders/export/csv', [App\Http\Controllers\Admin\OrderExportController::class, 'exportCsv'])->name('orders.export-csv');
    
    // Order Payment Proof Routes
    Route::get('/orders/{order}/proof/download', [App\Http\Controllers\Admin\OrderProofController::class, 'download'])->name('orders.download-proof');
    Route::get('/orders/{order}/proof/view', [App\Http\Controllers\Admin\OrderProofController::class, 'view'])->name('orders.view-proof');
    
    // POS System (Livewire)
    Route::get('/pos', PosSystem::class)->name('pos.index');
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
Auth::routes();

// Dashboard routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('user.dashboard.home');

// Missing routes for footer/header links
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/request/product', function () {
    return view('request-product');
})->name('request.product');

// Checkout Route (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', \App\Livewire\Pages\Checkout::class)->name('checkout');
});

