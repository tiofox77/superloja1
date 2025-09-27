<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some products and users
        $products = Product::where('is_active', true)->take(5)->get();
        $seller = User::first();

        if ($products->isEmpty() || !$seller) {
            $this->command->error('Precisa ter produtos e usuários no sistema primeiro!');
            return;
        }

        $auctions = [
            [
                'title' => 'iPhone 15 Pro Max - Selado na Caixa',
                'description' => 'Apple iPhone 15 Pro Max 256GB Titanium Natural - Completamente novo, ainda selado na caixa original. Garantia de fábrica de 1 ano.',
                'starting_price' => 650000,
                'current_bid' => 750000,
                'reserve_price' => 800000,
                'buy_now_price' => 950000,
                'start_time' => Carbon::now()->subHours(2),
                'end_time' => Carbon::now()->addHours(4),
                'status' => 'active',
            ],
            [
                'title' => 'MacBook Air M2 - Como Novo',
                'description' => 'Apple MacBook Air 13" com chip M2, 8GB RAM, 256GB SSD. Estado impecável, usado apenas por 3 meses. Inclui carregador original.',
                'starting_price' => 400000,
                'current_bid' => 520000,
                'reserve_price' => 600000,
                'buy_now_price' => 780000,
                'start_time' => Carbon::now()->subHours(1),
                'end_time' => Carbon::now()->addHours(6),
                'status' => 'active',
            ],
            [
                'title' => 'PlayStation 5 + 2 Comandos',
                'description' => 'Sony PlayStation 5 Digital Edition com 2 comandos DualSense wireless. Inclui 3 jogos: Spider-Man, FIFA 24 e Call of Duty.',
                'starting_price' => 350000,
                'current_price' => 420000,
                'reserve_price' => 480000,
                'buy_now_price' => 580000,
                'start_time' => Carbon::now()->subMinutes(30),
                'end_time' => Carbon::now()->addHours(12),
                'status' => 'active',
            ],
            [
                'title' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Samsung Galaxy S24 Ultra 512GB em Titanium Black. S Pen inclusa, protetor de tela aplicado. 6 meses de uso.',
                'starting_price' => 480000,
                'current_price' => 550000,
                'reserve_price' => 620000,
                'buy_now_price' => 750000,
                'start_time' => Carbon::now()->addMinutes(15),
                'end_time' => Carbon::now()->addHours(8),
                'status' => 'active',
            ],
            [
                'title' => 'Apple Watch Series 9 GPS + Cellular',
                'description' => 'Apple Watch Series 9 45mm GPS + Cellular em Silver Aluminum com Sport Band. Inclui carregador magnético e caixa original.',
                'starting_price' => 180000,
                'current_price' => 220000,
                'reserve_price' => 280000,
                'buy_now_price' => 350000,
                'start_time' => Carbon::now()->addHours(1),
                'end_time' => Carbon::now()->addHours(24),
                'status' => 'active',
            ],
        ];

        foreach ($auctions as $index => $auctionData) {
            if (isset($products[$index])) {
                Auction::create(array_merge($auctionData, [
                    'product_id' => $products[$index]->id,
                    'seller_id' => $seller->id, // Admin como seller
                ]));
            }
        }

        $this->command->info('✅ Leilões de exemplo criados com sucesso!');
    }
}
