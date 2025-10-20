<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HealthWellnessProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar categorias de saúde e bem-estar
        $healthCategory = Category::where('name', 'Saúde e Bem-estar')->first();
        
        if (!$healthCategory) {
            $this->command->error('Categoria "Saúde e Bem-estar" não encontrada. Execute primeiro HealthWellnessCategoriesSeeder.');
            return;
        }

        $subcategories = $healthCategory->children;

        // Criar marcas para produtos de saúde
        $brands = [
            'NaturalLife' => 'Produtos naturais e orgânicos para uma vida saudável',
            'VitaMax' => 'Vitaminas e suplementos de alta qualidade',
            'PureCare' => 'Cuidados pessoais com ingredientes puros',
            'FitPro' => 'Equipamentos profissionais para fitness',
            'BeautyZone' => 'Cosméticos e produtos de beleza',
            'MedHome' => 'Equipamentos médicos para uso doméstico',
            'ZenLife' => 'Produtos para relaxamento e bem-estar',
            'BabyLove' => 'Cuidados especiais para mães e bebés'
        ];

        $createdBrands = [];
        foreach ($brands as $brandName => $brandDescription) {
            $createdBrands[$brandName] = Brand::firstOrCreate([
                'name' => $brandName,
            ], [
                'slug' => Str::slug($brandName),
                'description' => $brandDescription,
                'is_active' => true,
            ]);
        }

        // Produtos por subcategoria
        $productsByCategory = [
            'Vitaminas e Suplementos' => [
                [
                    'name' => 'Vitamina C 1000mg',
                    'description' => 'Suplemento de Vitamina C de alta potência para fortalecer o sistema imunitário. Comprimidos efervescentes com sabor a laranja.',
                    'price' => 2500.00,
                    'compare_price' => 3000.00,
                    'brand' => 'VitaMax',
                    'tags' => 'vitamina, imunidade, suplemento',
                    'specifications' => [
                        'Dosagem' => '1000mg por comprimido',
                        'Quantidade' => '30 comprimidos',
                        'Sabor' => 'Laranja',
                        'Forma' => 'Efervescente'
                    ]
                ],
                [
                    'name' => 'Complexo B Avançado',
                    'description' => 'Complexo completo de vitaminas do grupo B para energia e vitalidade. Fórmula balanceada com B1, B2, B6, B12 e ácido fólico.',
                    'price' => 3200.00,
                    'compare_price' => 3800.00,
                    'brand' => 'VitaMax',
                    'tags' => 'complexo B, energia, vitaminas',
                    'specifications' => [
                        'Quantidade' => '60 cápsulas',
                        'Dosagem diária' => '1 cápsula',
                        'Duração' => '2 meses',
                        'Tipo' => 'Cápsulas vegetais'
                    ]
                ],
                [
                    'name' => 'Ómega 3 Premium',
                    'description' => 'Óleo de peixe purificado rico em EPA e DHA para saúde cardiovascular e cerebral. Sem sabor a peixe.',
                    'price' => 4500.00,
                    'compare_price' => 5200.00,
                    'brand' => 'NaturalLife',
                    'tags' => 'omega 3, coração, cérebro',
                    'specifications' => [
                        'EPA' => '500mg',
                        'DHA' => '300mg',
                        'Quantidade' => '90 cápsulas',
                        'Origem' => 'Óleo de peixe selvagem'
                    ]
                ]
            ],
            'Cuidados Pessoais' => [
                [
                    'name' => 'Gel de Duche Hidratante',
                    'description' => 'Gel de duche com óleo de argan e manteiga de karité. Limpa suavemente mantendo a pele hidratada e macia.',
                    'price' => 1200.00,
                    'compare_price' => 1500.00,
                    'brand' => 'PureCare',
                    'tags' => 'gel duche, hidratante, pele',
                    'specifications' => [
                        'Volume' => '500ml',
                        'Ingredientes principais' => 'Óleo de Argan, Manteiga de Karité',
                        'Tipo de pele' => 'Todos os tipos',
                        'pH' => 'Balanceado'
                    ]
                ],
                [
                    'name' => 'Pasta de Dentes Natural',
                    'description' => 'Pasta de dentes com ingredientes naturais, sem flúor. Com óleo de coco e extracto de hortelã para hálito fresco.',
                    'price' => 800.00,
                    'compare_price' => 1000.00,
                    'brand' => 'NaturalLife',
                    'tags' => 'pasta dentes, natural, hortelã',
                    'specifications' => [
                        'Volume' => '100ml',
                        'Ingredientes' => 'Óleo de coco, Extracto de hortelã',
                        'Tipo' => 'Natural, sem flúor',
                        'Sabor' => 'Hortelã suave'
                    ]
                ]
            ],
            'Beleza e Cosméticos' => [
                [
                    'name' => 'Sérum Anti-idade Vitamina C',
                    'description' => 'Sérum facial com 20% de Vitamina C pura, ácido hialurónico e vitamina E. Reduz rugas e ilumina a pele.',
                    'price' => 6500.00,
                    'compare_price' => 7800.00,
                    'brand' => 'BeautyZone',
                    'tags' => 'sérum, anti-idade, vitamina C',
                    'specifications' => [
                        'Volume' => '30ml',
                        'Concentração Vit. C' => '20%',
                        'Outros ativos' => 'Ácido Hialurónico, Vitamina E',
                        'Tipo de pele' => 'Todos os tipos'
                    ]
                ],
                [
                    'name' => 'Creme Hidratante Facial SPF 30',
                    'description' => 'Creme hidratante com proteção solar SPF 30. Fórmula leve, não oleosa, ideal para uso diário.',
                    'price' => 3800.00,
                    'compare_price' => 4500.00,
                    'brand' => 'BeautyZone',
                    'tags' => 'creme facial, SPF 30, hidratante',
                    'specifications' => [
                        'Volume' => '50ml',
                        'FPS' => '30',
                        'Textura' => 'Leve, não oleosa',
                        'Uso' => 'Diário, manhã'
                    ]
                ]
            ],
            'Equipamentos Médicos' => [
                [
                    'name' => 'Tensiómetro Digital',
                    'description' => 'Tensiómetro digital automático para braço com ecrã LCD grande. Memória para 2 utilizadores com 60 medições cada.',
                    'price' => 8500.00,
                    'compare_price' => 10000.00,
                    'brand' => 'MedHome',
                    'tags' => 'tensiómetro, pressão arterial, digital',
                    'specifications' => [
                        'Tipo' => 'Braço, automático',
                        'Ecrã' => 'LCD grande',
                        'Memória' => '2 utilizadores x 60 medições',
                        'Precisão' => '±3 mmHg'
                    ]
                ],
                [
                    'name' => 'Termómetro Infravermelho',
                    'description' => 'Termómetro sem contacto com tecnologia infravermelha. Medição rápida e precisa em 1 segundo.',
                    'price' => 4200.00,
                    'compare_price' => 5000.00,
                    'brand' => 'MedHome',
                    'tags' => 'termómetro, infravermelho, contacto',
                    'specifications' => [
                        'Tipo' => 'Sem contacto, infravermelho',
                        'Tempo de medição' => '1 segundo',
                        'Distância' => '3-5 cm',
                        'Precisão' => '±0.2°C'
                    ]
                ]
            ],
            'Fitness e Exercício' => [
                [
                    'name' => 'Tapete de Yoga Premium',
                    'description' => 'Tapete de yoga antiderrapante com 6mm de espessura. Material ecológico TPE, sem látex, com alças para transporte.',
                    'price' => 3500.00,
                    'compare_price' => 4000.00,
                    'brand' => 'FitPro',
                    'tags' => 'yoga, tapete, exercício',
                    'specifications' => [
                        'Espessura' => '6mm',
                        'Material' => 'TPE ecológico',
                        'Dimensões' => '183 x 61 cm',
                        'Características' => 'Antiderrapante, com alças'
                    ]
                ],
                [
                    'name' => 'Halteres Ajustáveis 20kg',
                    'description' => 'Par de halteres ajustáveis de 2.5kg a 20kg cada. Sistema de ajuste rápido, ocupam pouco espaço.',
                    'price' => 25000.00,
                    'compare_price' => 30000.00,
                    'brand' => 'FitPro',
                    'tags' => 'halteres, musculação, ajustáveis',
                    'specifications' => [
                        'Peso' => '2.5kg - 20kg cada',
                        'Sistema' => 'Ajuste rápido',
                        'Material' => 'Ferro fundido com revestimento',
                        'Quantidade' => 'Par (2 halteres)'
                    ]
                ]
            ],
            'Alimentação Saudável' => [
                [
                    'name' => 'Quinoa Orgânica',
                    'description' => 'Quinoa orgânica certificada, rica em proteínas e aminoácidos essenciais. Grão inteiro, sem glúten.',
                    'price' => 1800.00,
                    'compare_price' => 2200.00,
                    'brand' => 'NaturalLife',
                    'tags' => 'quinoa, orgânica, proteína',
                    'specifications' => [
                        'Peso' => '500g',
                        'Certificação' => 'Orgânica',
                        'Características' => 'Sem glúten, grão inteiro',
                        'Origem' => 'Agricultura biológica'
                    ]
                ],
                [
                    'name' => 'Óleo de Coco Extra Virgem',
                    'description' => 'Óleo de coco extra virgem prensado a frio. Ideal para cozinhar, hidratar a pele e cabelo.',
                    'price' => 2200.00,
                    'compare_price' => 2800.00,
                    'brand' => 'NaturalLife',
                    'tags' => 'óleo coco, extra virgem, natural',
                    'specifications' => [
                        'Volume' => '500ml',
                        'Processo' => 'Prensado a frio',
                        'Qualidade' => 'Extra virgem',
                        'Uso' => 'Culinário e cosmético'
                    ]
                ]
            ],
            'Relaxamento e Bem-estar' => [
                [
                    'name' => 'Difusor de Aromas Ultrassónico',
                    'description' => 'Difusor de óleos essenciais com tecnologia ultrassónica. 7 cores de LED, timer automático, silencioso.',
                    'price' => 5200.00,
                    'compare_price' => 6500.00,
                    'brand' => 'ZenLife',
                    'tags' => 'difusor, aromas, relaxamento',
                    'specifications' => [
                        'Capacidade' => '300ml',
                        'Tecnologia' => 'Ultrassónica',
                        'Iluminação' => '7 cores LED',
                        'Funcionamento' => 'Silencioso, timer automático'
                    ]
                ],
                [
                    'name' => 'Kit Óleos Essenciais Premium',
                    'description' => 'Kit com 6 óleos essenciais puros: lavanda, eucalipto, hortelã, laranja, tea tree e ylang-ylang.',
                    'price' => 7800.00,
                    'compare_price' => 9500.00,
                    'brand' => 'ZenLife',
                    'tags' => 'óleos essenciais, aromaterapia, kit',
                    'specifications' => [
                        'Quantidade' => '6 óleos x 10ml',
                        'Óleos inclusos' => 'Lavanda, Eucalipto, Hortelã, Laranja, Tea Tree, Ylang-ylang',
                        'Pureza' => '100% puros',
                        'Embalagem' => 'Frascos âmbar com conta-gotas'
                    ]
                ]
            ],
            'Maternidade e Bebé' => [
                [
                    'name' => 'Creme Anti-estrias Maternidade',
                    'description' => 'Creme preventivo de estrias com óleo de rosa mosqueta e manteiga de cacau. Hidrata profundamente a pele.',
                    'price' => 3200.00,
                    'compare_price' => 4000.00,
                    'brand' => 'BabyLove',
                    'tags' => 'creme, anti-estrias, maternidade',
                    'specifications' => [
                        'Volume' => '200ml',
                        'Ingredientes principais' => 'Óleo de rosa mosqueta, Manteiga de cacau',
                        'Uso' => 'Durante e após gravidez',
                        'Aplicação' => '2x ao dia'
                    ]
                ],
                [
                    'name' => 'Gel de Dentição Natural Bebé',
                    'description' => 'Gel calmante para alívio das dores de dentição. Fórmula natural com camomila e malva, sem açúcar.',
                    'price' => 1500.00,
                    'compare_price' => 1800.00,
                    'brand' => 'BabyLove',
                    'tags' => 'gel dentição, bebé, natural',
                    'specifications' => [
                        'Volume' => '15ml',
                        'Ingredientes' => 'Camomila, Malva',
                        'Idade' => 'A partir dos 3 meses',
                        'Características' => 'Natural, sem açúcar'
                    ]
                ]
            ]
        ];

        // Criar produtos
        foreach ($productsByCategory as $categoryName => $products) {
            $category = $subcategories->where('name', $categoryName)->first();
            
            if (!$category) {
                $this->command->warn("Subcategoria '$categoryName' não encontrada. Pulando...");
                continue;
            }

            foreach ($products as $productData) {
                $brand = $createdBrands[$productData['brand']] ?? null;
                
                $product = Product::firstOrCreate([
                    'name' => $productData['name'],
                ], [
                    'slug' => Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'short_description' => Str::limit($productData['description'], 120),
                    'price' => $productData['price'],
                    'sale_price' => $productData['compare_price'],
                    'category_id' => $category->id,
                    'brand_id' => $brand ? $brand->id : null,
                    'sku' => 'HW-' . strtoupper(Str::random(6)),
                    'stock_quantity' => rand(10, 100),
                    'is_active' => true,
                    'is_featured' => rand(0, 1) == 1,
                    'meta_title' => $productData['name'] . ' - SuperLoja Angola',
                    'meta_description' => Str::limit($productData['description'], 160),
                    'specifications' => $productData['specifications'],
                    'weight' => rand(100, 2000) / 1000, // peso em kg
                    'length' => rand(5, 30),
                    'width' => rand(5, 30), 
                    'height' => rand(5, 20),
                ]);

                $this->command->info("Produto criado: {$product->name}");
            }
        }

        $this->command->info('Produtos de Saúde e Bem-estar criados com sucesso!');
    }
}
