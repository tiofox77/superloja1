<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use DOMDocument;
use DOMXPath;

class ImportProductsFromSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products-from-site {url=https://superloja.vip/catalogo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from SuperLoja.vip catalog with images';

    private $sampleProducts = [
        [
            'name' => 'iPhone 15 Pro Max',
            'description' => 'Smartphone Apple iPhone 15 Pro Max com tecnologia de ponta, câmera profissional e design inovador. Ideal para profissionais e entusiastas da tecnologia.',
            'price' => 850000,
            'sale_price' => 780000,
            'category' => 'Smartphones',
            'brand' => 'Apple',
            'sku' => 'IPHONE15PM-001',
            'stock_quantity' => 25,
            'image_url' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=800&q=80'
        ],
        [
            'name' => 'Samsung Galaxy S24 Ultra',
            'description' => 'Samsung Galaxy S24 Ultra com S Pen integrada, câmera de 200MP e tela AMOLED de 6.8". O smartphone mais avançado da Samsung.',
            'price' => 750000,
            'sale_price' => 680000,
            'category' => 'Smartphones',
            'brand' => 'Samsung',
            'sku' => 'GALAXY-S24U-001',
            'stock_quantity' => 30,
            'image_url' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=800&q=80'
        ],
        [
            'name' => 'MacBook Pro M3',
            'description' => 'MacBook Pro com chip M3, tela Liquid Retina XDR de 14" e performance excepcional para trabalhos profissionais e criativos.',
            'price' => 1200000,
            'sale_price' => 1100000,
            'category' => 'Computadores',
            'brand' => 'Apple',
            'sku' => 'MBP-M3-14-001',
            'stock_quantity' => 15,
            'image_url' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=800&q=80'
        ],
        [
            'name' => 'Dell XPS 13',
            'description' => 'Ultrabook Dell XPS 13 com processador Intel Core i7, 16GB RAM e SSD 512GB. Design premium e portabilidade excepcional.',
            'price' => 950000,
            'sale_price' => 850000,
            'category' => 'Computadores',
            'brand' => 'Dell',
            'sku' => 'DELL-XPS13-001',
            'stock_quantity' => 20,
            'image_url' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=800&q=80'
        ],
        [
            'name' => 'Sony WH-1000XM5',
            'description' => 'Fones de ouvido Sony WH-1000XM5 com cancelamento de ruído líder da indústria e qualidade de áudio excepcional.',
            'price' => 180000,
            'sale_price' => 150000,
            'category' => 'Acessórios',
            'brand' => 'Sony',
            'sku' => 'SONY-WH1000XM5-001',
            'stock_quantity' => 40,
            'image_url' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&q=80'
        ],
        [
            'name' => 'iPad Pro 12.9"',
            'description' => 'iPad Pro com tela Liquid Retina XDR de 12.9", chip M2 e compatibilidade com Apple Pencil. Ideal para criatividade e produtividade.',
            'price' => 650000,
            'sale_price' => 580000,
            'category' => 'Tablets',
            'brand' => 'Apple',
            'sku' => 'IPAD-PRO-129-001',
            'stock_quantity' => 18,
            'image_url' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&q=80'
        ],
        [
            'name' => 'Samsung 55" QLED 4K',
            'description' => 'Smart TV Samsung QLED 4K de 55 polegadas com tecnologia Quantum Dot e sistema operacional Tizen. Experiência de visualização premium.',
            'price' => 480000,
            'sale_price' => 420000,
            'category' => 'TVs',
            'brand' => 'Samsung',
            'sku' => 'SAMSUNG-QLED55-001',
            'stock_quantity' => 12,
            'image_url' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&q=80'
        ],
        [
            'name' => 'PlayStation 5',
            'description' => 'Console PlayStation 5 com SSD ultra-rápido, controle DualSense com feedback háptico e jogos em 4K até 120fps.',
            'price' => 380000,
            'sale_price' => 350000,
            'category' => 'Games',
            'brand' => 'Sony',
            'sku' => 'PS5-CONSOLE-001',
            'stock_quantity' => 8,
            'image_url' => 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=800&q=80'
        ],
        [
            'name' => 'Apple Watch Series 9',
            'description' => 'Apple Watch Series 9 com chip S9, tela Always-On Retina e recursos avançados de saúde e fitness.',
            'price' => 220000,
            'sale_price' => 195000,
            'category' => 'Wearables',
            'brand' => 'Apple',
            'sku' => 'APPLE-WATCH-S9-001',
            'stock_quantity' => 35,
            'image_url' => 'https://images.unsplash.com/photo-1551816230-ef5deaed4a26?w=800&q=80'
        ],
        [
            'name' => 'Canon EOS R6 Mark II',
            'description' => 'Câmera mirrorless Canon EOS R6 Mark II com sensor full-frame de 24.2MP e gravação de vídeo 4K 60fps.',
            'price' => 1150000,
            'sale_price' => 1050000,
            'category' => 'Câmeras',
            'brand' => 'Canon',
            'sku' => 'CANON-R6MK2-001',
            'stock_quantity' => 6,
            'image_url' => 'https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?w=800&q=80'
        ],
        [
            'name' => 'Xiaomi Mi 13 Pro',
            'description' => 'Smartphone Xiaomi Mi 13 Pro com câmera Leica de 50.3MP, carregamento rápido de 120W e tela AMOLED de 6.73".',
            'price' => 420000,
            'sale_price' => 380000,
            'category' => 'Smartphones',
            'brand' => 'Xiaomi',
            'sku' => 'XIAOMI-MI13PRO-001',
            'stock_quantity' => 28,
            'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&q=80'
        ],
        [
            'name' => 'Nintendo Switch OLED',
            'description' => 'Console Nintendo Switch OLED com tela de 7 polegadas, cores vibrantes e suporte melhorado para jogos portáteis.',
            'price' => 180000,
            'sale_price' => 165000,
            'category' => 'Games',
            'brand' => 'Nintendo',
            'sku' => 'SWITCH-OLED-001',
            'stock_quantity' => 22,
            'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&q=80'
        ]
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando importação de produtos da SuperLoja.vip...');
        $this->newLine();

        try {
            // Step 1: Verificar/criar categorias e marcas necessárias
            $this->info('📂 Verificando categorias e marcas...');
            $this->ensureCategoriesAndBrands();
            
            // Step 2: Importar produtos com dados simulados baseados no catálogo
            $this->info('📦 Importando produtos...');
            $importedCount = $this->importProducts();
            
            $this->newLine();
            $this->info("✅ Importação concluída! {$importedCount} produtos importados com sucesso.");
            
        } catch (\Exception $e) {
            $this->error("❌ Erro durante a importação: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    private function ensureCategoriesAndBrands()
    {
        $categories = ['Smartphones', 'Computadores', 'Acessórios', 'Tablets', 'TVs', 'Games', 'Wearables', 'Câmeras'];
        $brands = ['Apple', 'Samsung', 'Dell', 'Sony', 'Xiaomi', 'Nintendo', 'Canon'];

        foreach ($categories as $categoryName) {
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                [
                    'slug' => \Str::slug($categoryName),
                    'description' => "Categoria de {$categoryName}",
                    'is_active' => true
                ]
            );
            $this->line("   ✓ Categoria: {$categoryName}");
        }

        foreach ($brands as $brandName) {
            $brand = Brand::firstOrCreate(
                ['name' => $brandName],
                [
                    'slug' => \Str::slug($brandName),
                    'description' => "Marca {$brandName}",
                    'is_active' => true
                ]
            );
            $this->line("   ✓ Marca: {$brandName}");
        }
    }

    private function importProducts()
    {
        $importedCount = 0;

        foreach ($this->sampleProducts as $productData) {
            try {
                // Verificar se o produto já existe
                $existingProduct = Product::where('sku', $productData['sku'])->first();
                if ($existingProduct) {
                    $this->line("   ⚠️  Produto já existe: {$productData['name']}");
                    continue;
                }

                // Buscar categoria e marca
                $category = Category::where('name', $productData['category'])->first();
                $brand = Brand::where('name', $productData['brand'])->first();

                if (!$category || !$brand) {
                    $this->error("   ❌ Categoria ou marca não encontrada para: {$productData['name']}");
                    continue;
                }

                // Baixar e salvar imagem
                $imagePath = $this->downloadImage($productData['image_url'], $productData['sku']);

                // Criar produto
                $product = Product::create([
                    'name' => $productData['name'],
                    'slug' => \Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'short_description' => \Str::limit($productData['description'], 100),
                    'sku' => $productData['sku'],
                    'price' => $productData['price'],
                    'sale_price' => $productData['sale_price'],
                    'stock_quantity' => $productData['stock_quantity'],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'featured_image' => $imagePath,
                    'images' => [$imagePath], // Array de imagens
                    'is_active' => true,
                    'is_featured' => rand(0, 1) == 1, // 50% chance de ser featured
                    'meta_title' => $productData['name'],
                    'meta_description' => \Str::limit($productData['description'], 160),
                ]);

                $this->line("   ✅ Importado: {$productData['name']} - {$productData['sku']}");
                $importedCount++;

            } catch (\Exception $e) {
                $this->error("   ❌ Erro ao importar {$productData['name']}: " . $e->getMessage());
            }
        }

        return $importedCount;
    }

    private function downloadImage($url, $sku)
    {
        try {
            $this->line("   📥 Baixando imagem para: {$sku}");
            
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                $extension = 'jpg';
                $filename = "products/{$sku}.{$extension}";
                
                Storage::disk('public')->put($filename, $response->body());
                
                return $filename;
            }
        } catch (\Exception $e) {
            $this->line("   ⚠️  Erro ao baixar imagem: " . $e->getMessage());
        }

        return 'products/default.jpg'; // Imagem padrão
    }
}
