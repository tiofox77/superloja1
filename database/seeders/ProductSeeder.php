<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();

        if ($categories->isEmpty() || $brands->isEmpty()) {
            $this->command->error('É necessário ter categorias e marcas antes de criar produtos. Execute primeiro CategorySeeder e BrandSeeder.');
            return;
        }

        $products = [
            // Eletrônicos
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'O mais avançado iPhone com chip A17 Pro, sistema de câmera Pro com zoom óptico 5x, e estrutura em titânio. Tela Super Retina XDR de 6,7 polegadas com ProMotion.',
                'short_description' => 'iPhone 15 Pro Max com 256GB, câmera Pro e chip A17 Pro',
                'price' => 1299000.00, // 1.299.000 AOA
                'sale_price' => 1199000.00,
                'cost_price' => 950000.00,
                'stock_quantity' => 25,
                'condition' => 'new',
                'is_featured' => true,
                'weight' => 221.00,
                'attributes' => [
                    'cor' => 'Titânio Natural',
                    'armazenamento' => '256GB',
                    'tela' => '6.7"',
                    'sistema' => 'iOS 17'
                ],
                'specifications' => [
                    'processador' => 'Apple A17 Pro',
                    'memoria_ram' => '8GB',
                    'camera_principal' => '48MP',
                    'bateria' => '4441mAh',
                    'conectividade' => '5G, Wi-Fi 6E, Bluetooth 5.3'
                ],
                'meta_keywords' => 'iphone, apple, smartphone, 5g, camera pro'
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Smartphone premium com S Pen integrada, câmera de 200MP com zoom óptico 10x, tela Dynamic AMOLED 2X de 6,8 polegadas e processador Snapdragon 8 Gen 3.',
                'short_description' => 'Galaxy S24 Ultra com S Pen, câmera 200MP e 512GB',
                'price' => 1150000.00,
                'sale_price' => 1050000.00,
                'cost_price' => 850000.00,
                'stock_quantity' => 18,
                'condition' => 'new',
                'is_featured' => true,
                'weight' => 232.00,
                'attributes' => [
                    'cor' => 'Preto Titânio',
                    'armazenamento' => '512GB',
                    'tela' => '6.8"',
                    'sistema' => 'Android 14'
                ],
                'specifications' => [
                    'processador' => 'Snapdragon 8 Gen 3',
                    'memoria_ram' => '12GB',
                    'camera_principal' => '200MP',
                    'bateria' => '5000mAh',
                    'conectividade' => '5G, Wi-Fi 7, Bluetooth 5.3'
                ]
            ],
            [
                'name' => 'MacBook Air M3',
                'description' => 'Laptop ultrafino com chip M3 da Apple, tela Liquid Retina de 13,6 polegadas, até 18 horas de bateria e design em alumínio reciclado.',
                'short_description' => 'MacBook Air M3 com 16GB RAM e 512GB SSD',
                'price' => 1450000.00,
                'cost_price' => 1200000.00,
                'stock_quantity' => 12,
                'condition' => 'new',
                'is_featured' => true,
                'weight' => 1240.00,
                'length' => 30.41,
                'width' => 21.50,
                'height' => 1.13,
                'attributes' => [
                    'cor' => 'Meia-noite',
                    'processador' => 'Apple M3',
                    'memoria' => '16GB',
                    'armazenamento' => '512GB SSD',
                    'tela' => '13.6" Liquid Retina'
                ],
                'specifications' => [
                    'processador' => 'Apple M3 8-core CPU',
                    'gpu' => '10-core GPU',
                    'memoria_ram' => '16GB',
                    'armazenamento' => '512GB SSD',
                    'conectividade' => 'Wi-Fi 6E, Bluetooth 5.3, 2x Thunderbolt'
                ]
            ],

            // Eletrodomésticos
            [
                'name' => 'Geladeira Frost Free Duplex 400L',
                'description' => 'Geladeira frost free com tecnologia inverter, controle de temperatura digital, gavetas para frutas e verduras, e design moderno em inox.',
                'short_description' => 'Geladeira 400L frost free com tecnologia inverter',
                'price' => 285000.00,
                'sale_price' => 265000.00,
                'cost_price' => 210000.00,
                'stock_quantity' => 8,
                'condition' => 'new',
                'weight' => 65000.00,
                'length' => 59.50,
                'width' => 66.00,
                'height' => 171.00,
                'attributes' => [
                    'cor' => 'Inox',
                    'capacidade' => '400L',
                    'tipo' => 'Duplex',
                    'tecnologia' => 'Frost Free'
                ],
                'specifications' => [
                    'consumo_energia' => 'Classe A',
                    'voltagem' => '220V',
                    'freezer' => '100L',
                    'refrigerador' => '300L',
                    'garantia' => '3 anos'
                ]
            ],
            [
                'name' => 'Máquina de Lavar 12kg Automática',
                'description' => 'Máquina de lavar automática com 12 programas de lavagem, função turbo, painel digital e sistema de economia de água e energia.',
                'short_description' => 'Máquina de lavar 12kg com 12 programas automáticos',
                'price' => 195000.00,
                'cost_price' => 155000.00,
                'stock_quantity' => 6,
                'condition' => 'new',
                'weight' => 58000.00,
                'attributes' => [
                    'capacidade' => '12kg',
                    'tipo' => 'Automática',
                    'cor' => 'Branco',
                    'programas' => '12'
                ]
            ],

            // Móveis
            [
                'name' => 'Sofá 3 Lugares Reclinável',
                'description' => 'Sofá confortável de 3 lugares com sistema de reclinação, estofado em couro sintético de alta qualidade, estrutura em madeira maciça.',
                'short_description' => 'Sofá 3 lugares reclinável em couro sintético',
                'price' => 165000.00,
                'sale_price' => 145000.00,
                'cost_price' => 110000.00,
                'stock_quantity' => 4,
                'condition' => 'new',
                'weight' => 85000.00,
                'length' => 200.00,
                'width' => 90.00,
                'height' => 95.00,
                'attributes' => [
                    'cor' => 'Marrom',
                    'material' => 'Couro Sintético',
                    'lugares' => '3',
                    'reclinavel' => 'Sim'
                ]
            ],
            [
                'name' => 'Mesa de Jantar 6 Lugares',
                'description' => 'Mesa de jantar em madeira MDF com acabamento em laminado, tampo resistente a riscos e manchas, acompanha 6 cadeiras estofadas.',
                'short_description' => 'Mesa de jantar completa para 6 pessoas com cadeiras',
                'price' => 125000.00,
                'cost_price' => 95000.00,
                'stock_quantity' => 3,
                'condition' => 'new',
                'weight' => 75000.00,
                'attributes' => [
                    'material' => 'MDF Laminado',
                    'lugares' => '6',
                    'cor' => 'Carvalho',
                    'inclui_cadeiras' => 'Sim'
                ]
            ],

            // Roupas e Acessórios
            [
                'name' => 'Tênis Esportivo Running Pro',
                'description' => 'Tênis para corrida com tecnologia de amortecimento avançado, cabedal respirável em mesh, solado antiderrapante e design ergonômico.',
                'short_description' => 'Tênis esportivo para corrida com amortecimento avançado',
                'price' => 35000.00,
                'sale_price' => 29000.00,
                'cost_price' => 22000.00,
                'stock_quantity' => 45,
                'condition' => 'new',
                'weight' => 650.00,
                'attributes' => [
                    'cor' => 'Preto/Branco',
                    'tamanho' => '42',
                    'genero' => 'Unissex',
                    'tipo' => 'Running'
                ],
                'specifications' => [
                    'material_cabedal' => 'Mesh respirável',
                    'solado' => 'Borracha antiderrapante',
                    'amortecimento' => 'EVA dupla densidade',
                    'indicado_para' => 'Corrida, caminhada'
                ]
            ],
            [
                'name' => 'Relógio Smartwatch Fitness',
                'description' => 'Smartwatch com monitor cardíaco, GPS integrado, resistente à água, mais de 100 modalidades esportivas e bateria de 7 dias.',
                'short_description' => 'Smartwatch com GPS, monitor cardíaco e 7 dias de bateria',
                'price' => 85000.00,
                'sale_price' => 75000.00,
                'cost_price' => 55000.00,
                'stock_quantity' => 22,
                'condition' => 'new',
                'is_featured' => true,
                'weight' => 45.00,
                'attributes' => [
                    'cor' => 'Preto',
                    'tela' => '1.43" AMOLED',
                    'conectividade' => 'Bluetooth 5.2',
                    'resistencia' => 'IP68'
                ]
            ],

            // Livros e Educação
            [
                'name' => 'Curso Completo de Programação Python',
                'description' => 'Curso online completo de Python do básico ao avançado, incluindo projetos práticos, certificado de conclusão e suporte por 1 ano.',
                'short_description' => 'Curso online de Python com certificado e suporte',
                'price' => 45000.00,
                'sale_price' => 35000.00,
                'cost_price' => 15000.00,
                'stock_quantity' => 999,
                'condition' => 'new',
                'is_digital' => true,
                'attributes' => [
                    'duracao' => '40 horas',
                    'nivel' => 'Básico ao Avançado',
                    'idioma' => 'Português',
                    'certificado' => 'Sim'
                ]
            ],

            // Produtos Usados/Recondicionados
            [
                'name' => 'PlayStation 5 Recondicionado',
                'description' => 'Console PlayStation 5 recondicionado em perfeito estado, testado e com garantia de 6 meses. Inclui controle DualSense e todos os cabos.',
                'short_description' => 'PS5 recondicionado com garantia de 6 meses',
                'price' => 425000.00,
                'sale_price' => 395000.00,
                'cost_price' => 320000.00,
                'stock_quantity' => 5,
                'condition' => 'refurbished',
                'condition_notes' => 'Recondicionado pela fabricante, testado e aprovado. Pequenos sinais de uso na parte externa.',
                'weight' => 4200.00,
                'attributes' => [
                    'cor' => 'Branco',
                    'armazenamento' => '825GB SSD',
                    'resolucao' => '4K',
                    'garantia' => '6 meses'
                ]
            ],
            [
                'name' => 'Bicicleta Mountain Bike Usada',
                'description' => 'Bicicleta mountain bike aro 29, quadro de alumínio, 21 marchas Shimano, freios a disco. Em bom estado de conservação.',
                'short_description' => 'Mountain bike aro 29 com 21 marchas em bom estado',
                'price' => 85000.00,
                'cost_price' => 65000.00,
                'stock_quantity' => 2,
                'condition' => 'used',
                'condition_notes' => 'Bicicleta em bom estado, com pequenos riscos no quadro. Revisada recentemente.',
                'weight' => 15000.00,
                'attributes' => [
                    'aro' => '29',
                    'marchas' => '21',
                    'quadro' => 'Alumínio',
                    'freios' => 'Disco'
                ]
            ]
        ];

        foreach ($products as $productData) {
            // Seleciona categoria e marca aleatórias
            $category = $categories->random();
            $brand = $brands->random();

            // Gera SKU único
            $sku = strtoupper(substr($brand->name, 0, 3) . '-' . substr($productData['name'], 0, 3) . '-' . rand(1000, 9999));
            
            // Gera slug único
            $slug = Str::slug($productData['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            Product::create([
                'name' => $productData['name'],
                'slug' => $slug,
                'description' => $productData['description'],
                'short_description' => $productData['short_description'],
                'sku' => $sku,
                'barcode' => isset($productData['barcode']) ? $productData['barcode'] : null,
                'price' => $productData['price'],
                'sale_price' => $productData['sale_price'] ?? null,
                'cost_price' => $productData['cost_price'],
                'stock_quantity' => $productData['stock_quantity'],
                'low_stock_threshold' => 5,
                'manage_stock' => true,
                'stock_status' => $productData['stock_quantity'] > 0 ? 'in_stock' : 'out_of_stock',
                'weight' => $productData['weight'] ?? null,
                'length' => $productData['length'] ?? null,
                'width' => $productData['width'] ?? null,
                'height' => $productData['height'] ?? null,
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'is_active' => true,
                'is_featured' => $productData['is_featured'] ?? false,
                'is_digital' => $productData['is_digital'] ?? false,
                'is_virtual' => false,
                'condition' => $productData['condition'],
                'condition_notes' => $productData['condition_notes'] ?? null,
                'meta_title' => $productData['name'] . ' - SuperLoja',
                'meta_description' => $productData['short_description'],
                'meta_keywords' => $productData['meta_keywords'] ?? null,
                'images' => null, // Pode ser adicionado posteriormente
                'featured_image' => null,
                'attributes' => json_encode($productData['attributes']),
                'specifications' => json_encode($productData['specifications'] ?? []),
                'rating_average' => rand(35, 50) / 10, // Rating entre 3.5 e 5.0
                'rating_count' => rand(5, 150),
                'view_count' => rand(10, 500),
                'order_count' => rand(0, 25),
            ]);
        }

        $this->command->info('Produtos criados com sucesso!');
        $this->command->info('Total de produtos: ' . count($products));
    }
}
