<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SetupSuperlojaCommand extends Command
{
    protected $signature = 'superloja:setup {--fresh : Drop all tables and recreate}';
    protected $description = 'Setup SuperLoja with all migrations, seeders and sample data';

    public function handle(): int
    {
        $this->info('🚀 Setting up SuperLoja...');
        
        if ($this->option('fresh')) {
            $this->warn('⚠️ This will drop all existing data!');
            if (!$this->confirm('Are you sure you want to continue?')) {
                $this->info('Setup cancelled.');
                return 0;
            }
            
            $this->info('🗑️ Dropping all tables...');
            Artisan::call('migrate:fresh');
            $this->info('✅ Tables dropped and recreated');
        } else {
            $this->info('📊 Running migrations...');
            Artisan::call('migrate');
            $this->info('✅ Migrations completed');
        }

        // Create admin user if not exists
        $this->info('🔑 Creating admin user...');
        $admin = User::firstOrCreate(
            ['email' => 'admin@superloja.ao'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@superloja.ao',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        
        if ($admin->wasRecentlyCreated) {
            $this->info('✅ Admin user created: admin@superloja.ao / admin123');
        } else {
            $this->info('ℹ️ Admin user already exists');
        }

        // Run seeders
        $this->info('🌱 Running seeders...');
        
        try {
            Artisan::call('db:seed', ['--class' => 'HealthWellnessCategoriesSeeder']);
            $this->info('✅ Health & Wellness categories seeded');
        } catch (\Exception $e) {
            $this->warn('⚠️ Health categories seeder failed: ' . $e->getMessage());
        }

        // Create sample data
        $this->info('📝 Creating sample data...');
        $this->createSampleData();

        // Create storage links
        $this->info('🔗 Creating storage links...');
        Artisan::call('storage:link');
        $this->info('✅ Storage links created');

        // Clear caches
        $this->info('🧹 Clearing caches...');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        $this->info('✅ Caches cleared and rebuilt');

        $this->newLine();
        $this->info('🎉 SuperLoja setup completed successfully!');
        $this->newLine();
        $this->line('📋 <comment>Next Steps:</comment>');
        $this->line('   • Access admin panel: <info>http://superloja.test/admin</info>');
        $this->line('   • Login: <info>admin@superloja.ao</info> / <info>admin123</info>');
        $this->line('   • Configure social media APIs in Social Media section');
        $this->line('   • Add OpenAI API key to .env for AI features');
        $this->newLine();

        return 0;
    }

    private function createSampleData(): void
    {
        // Create sample brands if none exist
        if (!\App\Models\Brand::exists()) {
            $brands = [
                ['name' => 'Apple', 'description' => 'Tecnologia premium', 'is_active' => true],
                ['name' => 'Samsung', 'description' => 'Inovação tecnológica', 'is_active' => true],
                ['name' => 'Nike', 'description' => 'Just Do It', 'is_active' => true],
                ['name' => 'Adidas', 'description' => 'Impossible is Nothing', 'is_active' => true],
            ];

            foreach ($brands as $brand) {
                \App\Models\Brand::create($brand);
            }
            $this->info('✅ Sample brands created');
        }

        // Create sample categories if none exist (beyond health categories)
        if (\App\Models\Category::where('parent_id', null)->count() < 3) {
            $categories = [
                [
                    'name' => 'Tecnologia',
                    'description' => 'Produtos tecnológicos e eletrônicos',
                    'is_active' => true,
                    'icon' => '💻',
                ],
                [
                    'name' => 'Moda e Vestuário',
                    'description' => 'Roupas, calçados e acessórios',
                    'is_active' => true,
                    'icon' => '👕',
                ],
                [
                    'name' => 'Casa e Jardim',
                    'description' => 'Produtos para casa e jardim',
                    'is_active' => true,
                    'icon' => '🏠',
                ],
            ];

            foreach ($categories as $category) {
                \App\Models\Category::create($category);
            }
            $this->info('✅ Sample categories created');
        }

        // Create sample products
        if (!\App\Models\Product::exists()) {
            $category = \App\Models\Category::first();
            $brand = \App\Models\Brand::first();

            if ($category && $brand) {
                $products = [
                    [
                        'name' => 'iPhone 15 Pro',
                        'slug' => 'iphone-15-pro',
                        'short_description' => 'O mais avançado iPhone de sempre',
                        'description' => 'iPhone 15 Pro com chip A17 Pro, câmera profissional e design em titânio.',
                        'price' => 45000000, // Em centavos
                        'sale_price' => 42000000, // Em centavos
                        'sku' => 'IPH15PRO128',
                        'stock_quantity' => 50,
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'is_active' => true,
                        'condition' => 'new',
                        'manage_stock' => true,
                        'stock_status' => 'in_stock',
                    ],
                    [
                        'name' => 'MacBook Air M2',
                        'slug' => 'macbook-air-m2',
                        'short_description' => 'Poder e portabilidade redefinidos',
                        'description' => 'MacBook Air com chip M2, 13 polegadas, ideal para trabalho e criatividade.',
                        'price' => 38000000, // Em centavos
                        'sku' => 'MBAM2256',
                        'stock_quantity' => 25,
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'is_active' => true,
                        'condition' => 'new',
                        'manage_stock' => true,
                        'stock_status' => 'in_stock',
                    ],
                ];

                foreach ($products as $product) {
                    \App\Models\Product::create($product);
                }
                $this->info('✅ Sample products created');
            }
        }

        // Create sample social media account
        if (!\App\Models\SocialMediaAccount::exists()) {
            \App\Models\SocialMediaAccount::create([
                'platform' => 'facebook',
                'account_name' => 'SuperLoja Angola',
                'page_id' => 'demo_page_id',
                'access_token' => 'demo_token_replace_with_real',
                'is_active' => false, // Disabled until real tokens are provided
                'auto_post' => false,
            ]);
            $this->info('✅ Sample social media account created');
        }
    }
}
