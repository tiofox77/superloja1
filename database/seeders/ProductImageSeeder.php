<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Imagens por categoria de produto
        $productImages = [
            // Smartphones
            'iPhone' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=800&h=800&fit=crop',
            'Samsung Galaxy' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=800&h=800&fit=crop',
            
            // Laptops
            'MacBook' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=800&h=800&fit=crop',
            
            // Eletrodomésticos
            'Geladeira' => 'https://images.unsplash.com/photo-1571175443880-49e1d25b2bc5?w=800&h=800&fit=crop',
            'Máquina de Lavar' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=800&h=800&fit=crop',
            
            // Móveis
            'Sofá' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=800&h=800&fit=crop',
            'Mesa de Jantar' => 'https://images.unsplash.com/photo-1549497538-303791108f95?w=800&h=800&fit=crop',
            
            // Roupas e Acessórios
            'Tênis' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&h=800&fit=crop',
            'Smartwatch' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&h=800&fit=crop',
            
            // Cursos
            'Curso' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=800&fit=crop',
            
            // Produtos usados
            'PlayStation' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?w=800&h=800&fit=crop',
            'Bicicleta' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=800&h=800&fit=crop'
        ];

        $products = Product::all();
        
        foreach ($products as $product) {
            // Encontrar imagem baseada no nome do produto
            $imageUrl = null;
            foreach ($productImages as $keyword => $url) {
                if (Str::contains($product->name, $keyword)) {
                    $imageUrl = $url;
                    break;
                }
            }
            
            // Imagem padrão se não encontrar específica
            if (!$imageUrl) {
                $imageUrl = 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=800&fit=crop';
            }
            
            // Baixar e salvar imagem
            try {
                $imageData = $this->downloadImage($imageUrl);
                if ($imageData) {
                    $filename = 'products/' . Str::slug($product->name) . '-' . $product->id . '.jpg';
                    
                    // Salvar no storage
                    if (Storage::disk('public')->put($filename, $imageData)) {
                        // Atualizar produto com o caminho da imagem
                        $product->update([
                            'featured_image' => $filename
                        ]);
                        
                        $this->command->info("Imagem baixada para: {$product->name}");
                    }
                }
            } catch (\Exception $e) {
                $this->command->warn("Erro ao baixar imagem para {$product->name}: {$e->getMessage()}");
            }
        }
        
        $this->command->info('Imagens de produtos atualizadas!');
    }
    
    /**
     * Download image from URL
     */
    private function downloadImage(string $url): ?string
    {
        try {
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                return $response->body();
            }
        } catch (\Exception $e) {
            $this->command->warn("Erro ao baixar imagem: {$e->getMessage()}");
        }
        
        return null;
    }
}
