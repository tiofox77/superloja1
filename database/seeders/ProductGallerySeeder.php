<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Galeria de imagens por produto e cores
        $productGalleries = [
            // iPhone 15 Pro Max
            'iPhone' => [
                'Titânio Natural' => [
                    'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=800&h=800&fit=crop'
                ],
                'Titânio Azul' => [
                    'https://images.unsplash.com/photo-1551816230-ef5deaed4a26?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=800&h=800&fit=crop'
                ],
                'Titânio Branco' => [
                    'https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1520923642038-b4259acecbd7?w=800&h=800&fit=crop'
                ],
                'Titânio Preto' => [
                    'https://images.unsplash.com/photo-1574944985070-8f3ebc6b79d2?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1603891128711-11b4b03bb138?w=800&h=800&fit=crop'
                ]
            ],
            
            // Samsung Galaxy
            'Samsung' => [
                'Preto Titânio' => [
                    'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&h=800&fit=crop'
                ],
                'Cinza Titânio' => [
                    'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=800&h=800&fit=crop'
                ],
                'Violeta Titânio' => [
                    'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=800&h=800&fit=crop'
                ],
                'Amarelo Titânio' => [
                    'https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?w=800&h=800&fit=crop'
                ]
            ],
            
            // MacBook Air
            'MacBook' => [
                'default' => [
                    'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&h=800&fit=crop'
                ]
            ],
            
            // Tênis
            'Tênis' => [
                'Preto/Branco' => [
                    'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=800&h=800&fit=crop'
                ],
                'Azul/Branco' => [
                    'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=800&h=800&fit=crop'
                ],
                'Vermelho/Preto' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&h=800&fit=crop'
                ],
                'Cinza/Verde' => [
                    'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=800&h=800&fit=crop'
                ]
            ],
            
            // Smartwatch
            'Smartwatch' => [
                'Preto' => [
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&h=800&fit=crop',
                    'https://images.unsplash.com/photo-1434494878577-86c23bcb06b9?w=800&h=800&fit=crop'
                ],
                'Prata' => [
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=800&h=800&fit=crop'
                ],
                'Dourado' => [
                    'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=800&h=800&fit=crop'
                ]
            ]
        ];

        $products = Product::with('variants')->get();
        
        foreach ($products as $product) {
            $this->command->info("Processando galeria para: {$product->name}");
            
            // Encontrar configuração de galeria baseada no nome do produto
            $galleryConfig = null;
            foreach ($productGalleries as $keyword => $config) {
                if (Str::contains($product->name, $keyword)) {
                    $galleryConfig = $config;
                    break;
                }
            }
            
            if (!$galleryConfig) {
                // Galeria padrão se não encontrar específica
                $galleryConfig = [
                    'default' => [
                        'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=800&fit=crop',
                        'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&h=800&fit=crop'
                    ]
                ];
            }
            
            $productImages = [];
            $variantImages = [];
            
            // Obter variantes de cor para este produto
            $colorVariants = $product->variants->where('name', 'Cor')->pluck('value')->toArray();
            
            foreach ($galleryConfig as $variantColor => $imageUrls) {
                $variantImagesList = [];
                
                foreach ($imageUrls as $index => $imageUrl) {
                    try {
                        $imageData = $this->downloadImage($imageUrl);
                        if ($imageData) {
                            $filename = 'products/' . Str::slug($product->name) . '-' . Str::slug($variantColor) . '-' . ($index + 1) . '.jpg';
                            
                            // Salvar no storage
                            if (Storage::disk('public')->put($filename, $imageData)) {
                                $variantImagesList[] = $filename;
                                
                                // Primeira imagem como featured se for default ou primeira cor
                                if (($variantColor === 'default' || $index === 0) && $index === 0) {
                                    $product->update(['featured_image' => $filename]);
                                }
                                
                                $this->command->info("  - Imagem " . ($index + 1) . " baixada para {$variantColor}");
                            }
                        }
                    } catch (\Exception $e) {
                        $this->command->warn("  - Erro ao baixar imagem " . ($index + 1) . " para {$variantColor}: {$e->getMessage()}");
                    }
                }
                
                if (!empty($variantImagesList)) {
                    if ($variantColor === 'default') {
                        $productImages = array_merge($productImages, $variantImagesList);
                    } else {
                        $variantImages[$variantColor] = $variantImagesList;
                    }
                }
            }
            
            // Atualizar produto com galeria de imagens
            $flattenedVariantImages = [];
            foreach ($variantImages as $images) {
                $flattenedVariantImages = array_merge($flattenedVariantImages, $images);
            }
            $allImages = array_merge($productImages, $flattenedVariantImages);
            
            if (!empty($allImages)) {
                $product->update([
                    'images' => json_encode($allImages),
                    'variant_images' => !empty($variantImages) ? json_encode($variantImages) : null
                ]);
            }
        }
        
        $this->command->info('Galeria de imagens criada com sucesso!');
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
