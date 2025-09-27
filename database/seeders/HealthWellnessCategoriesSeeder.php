<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HealthWellnessCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Criar categoria mãe "Saúde e Bem-estar"
        $healthCategory = Category::firstOrCreate([
            'name' => 'Saúde e Bem-estar',
            'slug' => 'saude-bem-estar',
        ], [
            'description' => 'Produtos para cuidar da sua saúde e bem-estar',
            'is_active' => true,
            'parent_id' => null,
            'sort_order' => 1,
            'icon' => 'heart',
        ]);

        // Subcategorias de Saúde e Bem-estar
        $subcategories = [
            [
                'name' => 'Vitaminas e Suplementos',
                'description' => 'Vitaminas, minerais e suplementos nutricionais',
                'icon' => 'pill',
            ],
            [
                'name' => 'Cuidados Pessoais',
                'description' => 'Produtos para higiene e cuidados pessoais',
                'icon' => 'user',
            ],
            [
                'name' => 'Beleza e Cosméticos',
                'description' => 'Produtos de beleza, cosméticos e maquilhagem',
                'icon' => 'sparkles',
            ],
            [
                'name' => 'Equipamentos Médicos',
                'description' => 'Equipamentos e dispositivos médicos domésticos',
                'icon' => 'medical',
            ],
            [
                'name' => 'Fitness e Exercício',
                'description' => 'Equipamentos e acessórios para exercício físico',
                'icon' => 'fitness',
            ],
            [
                'name' => 'Alimentação Saudável',
                'description' => 'Alimentos naturais, orgânicos e funcionais',
                'icon' => 'leaf',
            ],
            [
                'name' => 'Relaxamento e Bem-estar',
                'description' => 'Produtos para relaxamento, massagem e aromaterapia',
                'icon' => 'spa',
            ],
            [
                'name' => 'Maternidade e Bebé',
                'description' => 'Produtos para mães e cuidados com bebés',
                'icon' => 'baby',
            ],
        ];

        foreach ($subcategories as $index => $subcategoryData) {
            Category::firstOrCreate([
                'name' => $subcategoryData['name'],
                'parent_id' => $healthCategory->id,
            ], [
                'slug' => Str::slug($subcategoryData['name']),
                'description' => $subcategoryData['description'],
                'is_active' => true,
                'sort_order' => $index + 1,
                'icon' => $subcategoryData['icon'],
            ]);
        }
    }
}
