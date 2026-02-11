<?php

require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\ImageProcessorService;
use App\Models\Product;

echo "=== TESTE DE PROCESSAMENTO DE IMAGEM ===\n\n";

// Buscar um produto com imagem
$product = Product::whereNotNull('featured_image')->first();

if (!$product) {
    echo "❌ Nenhum produto com imagem encontrado!\n";
    echo "Por favor, adicione um produto com imagem primeiro.\n";
    exit(1);
}

echo "✅ Produto encontrado: {$product->name}\n";
echo "📸 Imagem: {$product->featured_image}\n";
echo "💰 Preço: " . number_format($product->price, 2, ',', '.') . " Kz\n\n";

// Verificar se a imagem existe
$imagePaths = [
    storage_path('app/public/' . str_replace('storage/', '', $product->featured_image)),
    public_path('storage/' . str_replace('/storage/', '', $product->featured_image)),
    public_path($product->featured_image),
];

$imageFound = false;
$imagePath = null;

foreach ($imagePaths as $path) {
    if (file_exists($path)) {
        $imageFound = true;
        $imagePath = $path;
        echo "✅ Imagem encontrada em: $path\n\n";
        break;
    }
}

if (!$imageFound) {
    echo "❌ Imagem não encontrada em nenhum dos caminhos:\n";
    foreach ($imagePaths as $path) {
        echo "  - $path\n";
    }
    exit(1);
}

// Verificar fontes
echo "📝 Verificando fontes...\n";
$fontBold = storage_path('fonts/Poppins-Bold.ttf');
$fontRegular = storage_path('fonts/Poppins-Regular.ttf');

if (file_exists($fontBold)) {
    echo "✅ Poppins-Bold.ttf encontrada\n";
} else {
    echo "⚠️  Poppins-Bold.ttf NÃO encontrada\n";
}

if (file_exists($fontRegular)) {
    echo "✅ Poppins-Regular.ttf encontrada\n";
} else {
    echo "⚠️  Poppins-Regular.ttf NÃO encontrada\n";
}

// Verificar logo
echo "\n🖼️  Verificando logo da aplicação...\n";
$siteLogo = \App\Models\Setting::get('site_logo');
if ($siteLogo) {
    echo "✅ Logo configurado: $siteLogo\n";
    
    $logoPaths = [
        public_path('storage/' . str_replace('/storage/', '', $siteLogo)),
        storage_path('app/public/' . str_replace(['storage/', '/storage/'], '', $siteLogo)),
        public_path($siteLogo),
    ];
    
    $logoFound = false;
    foreach ($logoPaths as $path) {
        if (file_exists($path)) {
            echo "✅ Logo encontrado em: $path\n";
            $logoFound = true;
            break;
        }
    }
    
    if (!$logoFound) {
        echo "⚠️  Logo não encontrado nos caminhos verificados\n";
        echo "   Será usado texto estilizado como fallback\n";
    }
} else {
    echo "ℹ️  Nenhum logo configurado\n";
    echo "   Será usado o nome da aplicação: " . \App\Models\Setting::get('app_name', 'SuperLoja') . "\n";
}

echo "\n🎨 Processando imagem...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Processar imagem
$processor = new ImageProcessorService();

$options = [
    'product_name' => $product->name,
    'price' => $product->price,
    'add_logo' => true,
    'add_border' => true,
    'add_watermark' => true,
];

try {
    $processedPath = $processor->processProductImage($product->featured_image, $options);
    
    if ($processedPath) {
        echo "✅ SUCESSO! Imagem processada!\n\n";
        echo "📁 Salva em: $processedPath\n";
        echo "🌐 URL: " . url('storage/' . $processedPath) . "\n\n";
        
        $fullPath = storage_path('app/public/' . $processedPath);
        if (file_exists($fullPath)) {
            $fileSize = filesize($fullPath);
            $fileSizeKB = round($fileSize / 1024, 2);
            echo "📊 Tamanho: {$fileSizeKB} KB\n";
            
            list($width, $height) = getimagesize($fullPath);
            echo "📐 Dimensões: {$width}x{$height}px\n\n";
            
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            echo "🎉 TESTE CONCLUÍDO COM SUCESSO!\n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
            
            echo "👀 Para visualizar a imagem, abra no navegador:\n";
            echo "   " . url('storage/' . $processedPath) . "\n\n";
            
            echo "💡 Copie e cole a URL acima no navegador para visualizar.\n";
        }
    } else {
        echo "❌ ERRO: Falha ao processar imagem\n";
        echo "Verifique os logs em storage/logs/laravel.log\n";
        exit(1);
    }
    
} catch (\Exception $e) {
    echo "❌ ERRO: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
