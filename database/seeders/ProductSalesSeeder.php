<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            // Gerar dados de vendas realistas
            $orderCount = rand(5, 500);
            $ratingCount = rand(1, 50);
            $rating = rand(35, 50) / 10; // Rating entre 3.5 e 5.0
            
            $product->update([
                'order_count' => $orderCount,
                'rating_count' => $ratingCount,
                'rating_average' => $rating
            ]);
            
            $this->command->info("Vendas atualizadas para: {$product->name} ({$orderCount} vendidos, {$rating} estrelas)");
        }
        
        $this->command->info('Dados de vendas atualizados com sucesso!');
    }
}
