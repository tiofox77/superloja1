<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImageProcessorService;
use App\Models\Product;

class TestImageProcessor extends Command
{
    protected $signature = 'test:image-processor {product_id?}';
    protected $description = 'Testar processamento de imagem de produto';

    public function handle(ImageProcessorService $imageProcessor): int
    {
        $productId = $this->argument('product_id');

        // Se não forneceu ID, pegar primeiro produto com imagem
        if (!$productId) {
            $product = Product::whereNotNull('featured_image')->first();
            
            if (!$product) {
                $this->error('❌ Nenhum produto com imagem encontrado!');
                return self::FAILURE;
            }
        } else {
            $product = Product::find($productId);
            
            if (!$product) {
                $this->error('❌ Produto não encontrado!');
                return self::FAILURE;
            }
        }

        $this->info("🎨 Processando imagem do produto: {$product->name}");
        $this->newLine();

        // Processar imagem
        $processedPath = $imageProcessor->processProductImage(
            $product->featured_image, // Passar apenas o path relativo
            [
                'product_name' => $product->name,
                'price' => $product->is_on_sale ? $product->sale_price : $product->price,
                'add_logo' => true,
                'add_border' => true,
                'add_watermark' => true,
            ]
        );

        if (!$processedPath) {
            $this->error('❌ Falha ao processar imagem!');
            $this->error('Verifique os logs para mais detalhes.');
            return self::FAILURE;
        }

        $this->info('✅ Imagem processada com sucesso!');
        $this->newLine();
        
        $this->table(
            ['Informação', 'Valor'],
            [
                ['Produto ID', $product->id],
                ['Nome', $product->name],
                ['Preço', number_format($product->is_on_sale ? $product->sale_price : $product->price, 2, ',', '.') . ' Kz'],
                ['Imagem Original', $product->featured_image],
                ['Imagem Processada', $processedPath],
                ['URL Processada', url('storage/' . $processedPath)],
            ]
        );

        $this->newLine();
        $this->info('🌐 Acesse a imagem em:');
        $this->line(url('storage/' . $processedPath));
        $this->newLine();
        $this->info('💡 Copie o link acima e cole no navegador para ver o resultado!');

        return self::SUCCESS;
    }
}
