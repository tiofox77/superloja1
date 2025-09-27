<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Eletrônicos',
                'slug' => 'eletronicos',
                'description' => 'Smartphones, tablets, computadores e acessórios tecnológicos',
                'icon' => '📱',
                'color' => '#3b82f6',
                'sort_order' => 1,
                'children' => [
                    [
                        'name' => 'Smartphones',
                        'slug' => 'smartphones',
                        'description' => 'iPhone, Samsung, Huawei e outras marcas',
                        'icon' => '📱',
                        'color' => '#6366f1'
                    ],
                    [
                        'name' => 'Laptops',
                        'slug' => 'laptops',
                        'description' => 'MacBooks, Dell, HP e outras marcas',
                        'icon' => '💻',
                        'color' => '#8b5cf6'
                    ],
                    [
                        'name' => 'Tablets',
                        'slug' => 'tablets',
                        'description' => 'iPad, Samsung Galaxy Tab e outros',
                        'icon' => '📱',
                        'color' => '#06b6d4'
                    ]
                ]
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Consoles, jogos e acessórios para gaming',
                'icon' => '🎮',
                'color' => '#ef4444',
                'sort_order' => 2,
                'children' => [
                    [
                        'name' => 'PlayStation',
                        'slug' => 'playstation',
                        'description' => 'PS5, PS4 e acessórios',
                        'icon' => '🎮',
                        'color' => '#2563eb'
                    ],
                    [
                        'name' => 'Xbox',
                        'slug' => 'xbox',
                        'description' => 'Xbox Series X/S e acessórios',
                        'icon' => '🎮',
                        'color' => '#16a34a'
                    ]
                ]
            ],
            [
                'name' => 'Higiene e Limpeza',
                'slug' => 'higiene-limpeza',
                'description' => 'Produtos de higiene pessoal e limpeza doméstica',
                'icon' => '🧽',
                'color' => '#10b981',
                'sort_order' => 3,
                'children' => [
                    [
                        'name' => 'Higiene Pessoal',
                        'slug' => 'higiene-pessoal',
                        'description' => 'Sabonetes, shampoos, cremes e desodorantes',
                        'icon' => '🧴',
                        'color' => '#06b6d4'
                    ],
                    [
                        'name' => 'Limpeza da Casa',
                        'slug' => 'limpeza-casa',
                        'description' => 'Detergentes, desinfetantes e produtos de limpeza',
                        'icon' => '🧽',
                        'color' => '#8b5cf6'
                    ],
                    [
                        'name' => 'Cuidado Oral',
                        'slug' => 'cuidado-oral',
                        'description' => 'Escovas de dente, pastas e enxaguantes',
                        'icon' => '🦷',
                        'color' => '#f59e0b'
                    ]
                ]
            ],
            [
                'name' => 'Casa e Jardim',
                'slug' => 'casa-jardim',
                'description' => 'Decoração, móveis e produtos para jardim',
                'icon' => '🏠',
                'color' => '#f59e0b',
                'sort_order' => 4
            ],
            [
                'name' => 'Moda e Acessórios',
                'slug' => 'moda-acessorios',
                'description' => 'Roupas, calçados e acessórios fashion',
                'icon' => '👕',
                'color' => '#ec4899',
                'sort_order' => 5
            ],
            [
                'name' => 'Saúde e Bem-estar',
                'slug' => 'saude-bem-estar',
                'description' => 'Suplementos, equipamentos fitness e cuidados pessoais',
                'icon' => '💊',
                'color' => '#06b6d4',
                'sort_order' => 6
            ]
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);
            
            $category = Category::create($categoryData);
            
            foreach ($children as $child) {
                $child['parent_id'] = $category->id;
                $child['sort_order'] = Category::where('parent_id', $category->id)->count() + 1;
                Category::create($child);
            }
        }
    }
}
