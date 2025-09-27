<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'Tecnologia inovadora e design elegante',
                'website' => 'https://www.apple.com',
                'sort_order' => 1
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'Líder mundial em eletrônicos',
                'website' => 'https://www.samsung.com',
                'sort_order' => 2
            ],
            [
                'name' => 'Huawei',
                'slug' => 'huawei',
                'description' => 'Conectando o mundo com tecnologia',
                'website' => 'https://www.huawei.com',
                'sort_order' => 3
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'description' => 'Entretenimento e tecnologia premium',
                'website' => 'https://www.sony.com',
                'sort_order' => 4
            ],
            [
                'name' => 'Microsoft',
                'slug' => 'microsoft',
                'description' => 'Produtividade e gaming',
                'website' => 'https://www.microsoft.com',
                'sort_order' => 5
            ],
            [
                'name' => 'Dell',
                'slug' => 'dell',
                'description' => 'Computadores para todos',
                'website' => 'https://www.dell.com',
                'sort_order' => 6
            ],
            [
                'name' => 'HP',
                'slug' => 'hp',
                'description' => 'Impressão e computação',
                'website' => 'https://www.hp.com',
                'sort_order' => 7
            ],
            // Marcas de Higiene e Limpeza
            [
                'name' => 'Unilever',
                'slug' => 'unilever',
                'description' => 'Produtos de higiene e limpeza de qualidade',
                'website' => 'https://www.unilever.com',
                'sort_order' => 8
            ],
            [
                'name' => 'Procter & Gamble',
                'slug' => 'procter-gamble',
                'description' => 'P&G - Cuidados pessoais e domésticos',
                'website' => 'https://www.pg.com',
                'sort_order' => 9
            ],
            [
                'name' => 'Colgate',
                'slug' => 'colgate',
                'description' => 'Cuidado oral premium',
                'website' => 'https://www.colgate.com',
                'sort_order' => 10
            ],
            [
                'name' => 'Johnson & Johnson',
                'slug' => 'johnson-johnson',
                'description' => 'Cuidados com a família',
                'website' => 'https://www.jnj.com',
                'sort_order' => 11
            ]
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
