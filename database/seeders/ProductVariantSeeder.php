<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Busca produtos específicos para criar variantes
        $iphone = Product::where('name', 'like', '%iPhone%')->first();
        $samsung = Product::where('name', 'like', '%Samsung%')->first();
        $tenis = Product::where('name', 'like', '%Tênis%')->first();
        $smartwatch = Product::where('name', 'like', '%Smartwatch%')->first();

        // Variantes para iPhone (cores e armazenamento)
        if ($iphone) {
            $iphoneVariants = [
                // Cores
                ['name' => 'Cor', 'value' => 'Titânio Natural', 'price_adjustment' => 0, 'stock_quantity' => 8],
                ['name' => 'Cor', 'value' => 'Titânio Azul', 'price_adjustment' => 0, 'stock_quantity' => 6],
                ['name' => 'Cor', 'value' => 'Titânio Branco', 'price_adjustment' => 0, 'stock_quantity' => 7],
                ['name' => 'Cor', 'value' => 'Titânio Preto', 'price_adjustment' => 0, 'stock_quantity' => 4],
                
                // Armazenamento
                ['name' => 'Armazenamento', 'value' => '256GB', 'price_adjustment' => 0, 'stock_quantity' => 15],
                ['name' => 'Armazenamento', 'value' => '512GB', 'price_adjustment' => 150000, 'stock_quantity' => 8],
                ['name' => 'Armazenamento', 'value' => '1TB', 'price_adjustment' => 300000, 'stock_quantity' => 2],
            ];

            foreach ($iphoneVariants as $variant) {
                ProductVariant::create([
                    'product_id' => $iphone->id,
                    'name' => $variant['name'],
                    'value' => $variant['value'],
                    'price_adjustment' => $variant['price_adjustment'],
                    'stock_quantity' => $variant['stock_quantity'],
                    'sku_suffix' => strtoupper(substr($variant['value'], 0, 3)),
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        }

        // Variantes para Samsung (cores e armazenamento)
        if ($samsung) {
            $samsungVariants = [
                // Cores
                ['name' => 'Cor', 'value' => 'Preto Titânio', 'price_adjustment' => 0, 'stock_quantity' => 6],
                ['name' => 'Cor', 'value' => 'Cinza Titânio', 'price_adjustment' => 0, 'stock_quantity' => 5],
                ['name' => 'Cor', 'value' => 'Violeta Titânio', 'price_adjustment' => 0, 'stock_quantity' => 4],
                ['name' => 'Cor', 'value' => 'Amarelo Titânio', 'price_adjustment' => 0, 'stock_quantity' => 3],
                
                // Armazenamento
                ['name' => 'Armazenamento', 'value' => '256GB', 'price_adjustment' => -100000, 'stock_quantity' => 10],
                ['name' => 'Armazenamento', 'value' => '512GB', 'price_adjustment' => 0, 'stock_quantity' => 6],
                ['name' => 'Armazenamento', 'value' => '1TB', 'price_adjustment' => 200000, 'stock_quantity' => 2],
            ];

            foreach ($samsungVariants as $variant) {
                ProductVariant::create([
                    'product_id' => $samsung->id,
                    'name' => $variant['name'],
                    'value' => $variant['value'],
                    'price_adjustment' => $variant['price_adjustment'],
                    'stock_quantity' => $variant['stock_quantity'],
                    'sku_suffix' => strtoupper(substr($variant['value'], 0, 3)),
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        }

        // Variantes para Tênis (tamanhos e cores)
        if ($tenis) {
            $tenisVariants = [
                // Tamanhos
                ['name' => 'Tamanho', 'value' => '38', 'price_adjustment' => 0, 'stock_quantity' => 3],
                ['name' => 'Tamanho', 'value' => '39', 'price_adjustment' => 0, 'stock_quantity' => 5],
                ['name' => 'Tamanho', 'value' => '40', 'price_adjustment' => 0, 'stock_quantity' => 8],
                ['name' => 'Tamanho', 'value' => '41', 'price_adjustment' => 0, 'stock_quantity' => 10],
                ['name' => 'Tamanho', 'value' => '42', 'price_adjustment' => 0, 'stock_quantity' => 12],
                ['name' => 'Tamanho', 'value' => '43', 'price_adjustment' => 0, 'stock_quantity' => 8],
                ['name' => 'Tamanho', 'value' => '44', 'price_adjustment' => 0, 'stock_quantity' => 5],
                ['name' => 'Tamanho', 'value' => '45', 'price_adjustment' => 0, 'stock_quantity' => 2],
                
                // Cores
                ['name' => 'Cor', 'value' => 'Preto/Branco', 'price_adjustment' => 0, 'stock_quantity' => 25],
                ['name' => 'Cor', 'value' => 'Azul/Branco', 'price_adjustment' => 0, 'stock_quantity' => 15],
                ['name' => 'Cor', 'value' => 'Vermelho/Preto', 'price_adjustment' => 2000, 'stock_quantity' => 10],
                ['name' => 'Cor', 'value' => 'Cinza/Verde', 'price_adjustment' => 1500, 'stock_quantity' => 8],
            ];

            foreach ($tenisVariants as $variant) {
                ProductVariant::create([
                    'product_id' => $tenis->id,
                    'name' => $variant['name'],
                    'value' => $variant['value'],
                    'price_adjustment' => $variant['price_adjustment'],
                    'stock_quantity' => $variant['stock_quantity'],
                    'sku_suffix' => strtoupper(str_replace(['/', ' '], '', substr($variant['value'], 0, 3))),
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        }

        // Variantes para Smartwatch (cores e pulseiras)
        if ($smartwatch) {
            $smartwatchVariants = [
                // Cores do case
                ['name' => 'Cor do Case', 'value' => 'Preto', 'price_adjustment' => 0, 'stock_quantity' => 12],
                ['name' => 'Cor do Case', 'value' => 'Prata', 'price_adjustment' => 0, 'stock_quantity' => 8],
                ['name' => 'Cor do Case', 'value' => 'Dourado', 'price_adjustment' => 5000, 'stock_quantity' => 4],
                
                // Tipos de pulseira
                ['name' => 'Pulseira', 'value' => 'Silicone Preto', 'price_adjustment' => 0, 'stock_quantity' => 15],
                ['name' => 'Pulseira', 'value' => 'Silicone Azul', 'price_adjustment' => 0, 'stock_quantity' => 10],
                ['name' => 'Pulseira', 'value' => 'Nylon Esportivo', 'price_adjustment' => 3000, 'stock_quantity' => 8],
                ['name' => 'Pulseira', 'value' => 'Couro Marrom', 'price_adjustment' => 8000, 'stock_quantity' => 5],
                ['name' => 'Pulseira', 'value' => 'Aço Inoxidável', 'price_adjustment' => 15000, 'stock_quantity' => 3],
            ];

            foreach ($smartwatchVariants as $variant) {
                ProductVariant::create([
                    'product_id' => $smartwatch->id,
                    'name' => $variant['name'],
                    'value' => $variant['value'],
                    'price_adjustment' => $variant['price_adjustment'],
                    'stock_quantity' => $variant['stock_quantity'],
                    'sku_suffix' => strtoupper(str_replace([' ', '/'], '', substr($variant['value'], 0, 3))),
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        }

        $this->command->info('Variantes de produtos criadas com sucesso!');
        $this->command->info('Total de variantes criadas: ' . ProductVariant::count());
    }
}
