<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckTables extends Command
{
    protected $signature = 'check:tables';
    protected $description = 'Check tables structure and identify issues';

    public function handle()
    {
        $this->info('🔍 Checking Tables Structure...');
        $this->newLine();
        
        $this->checkProductsTable();
        $this->newLine();
        $this->checkProductVariantsTable();
        $this->newLine();
        $this->fixProductManager();
    }

    private function checkProductsTable()
    {
        $this->info('📋 PRODUCTS TABLE:');
        
        try {
            $columns = Schema::getColumnListing('products');
            $this->line('Columns found: ' . count($columns));
            foreach ($columns as $column) {
                $this->line("  • $column");
            }
            
            $count = DB::table('products')->count();
            $this->info("Records: $count");
            
            // Test specific columns that are causing issues
            $this->testProductColumns();
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
    
    private function testProductColumns()
    {
        $this->line('Testing problematic columns:');
        
        $columns = Schema::getColumnListing('products');
        
        $expectedColumns = [
            'sale_price', 'length', 'width', 'height', 'featured_image', 'images'
        ];
        
        foreach ($expectedColumns as $column) {
            if (in_array($column, $columns)) {
                $this->line("  ✅ $column - EXISTS");
            } else {
                $this->line("  ❌ $column - MISSING");
            }
        }
        
        // Check fillable vs actual columns
        $modelFillable = [
            'category_id', 'brand_id', 'name', 'slug', 'description', 'short_description',
            'sku', 'price', 'compare_price', 'cost_price', 'stock_quantity', 'min_stock_level',
            'weight', 'dimensions', 'image_url', 'gallery_images', 'is_active', 'is_featured',
            'condition', 'condition_notes', 'meta_title', 'meta_description', 'featured_image',
            'attributes', 'specifications', 'rating_average', 'rating_count', 'view_count',
            'order_count', 'sale_price', 'length', 'width', 'height', 'images'
        ];
        
        $missingColumns = array_diff($modelFillable, $columns);
        if (!empty($missingColumns)) {
            $this->error('Missing columns in database:');
            foreach ($missingColumns as $column) {
                $this->line("  • $column");
            }
        }
    }

    private function checkProductVariantsTable()
    {
        $this->info('📋 PRODUCT_VARIANTS TABLE:');
        
        try {
            $columns = Schema::getColumnListing('product_variants');
            $this->line('Columns found: ' . count($columns));
            foreach ($columns as $column) {
                $this->line("  • $column");
            }
            
            $count = DB::table('product_variants')->count();
            $this->info("Records: $count");
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
    
    private function fixProductManager()
    {
        $this->info('🔧 ProductManager Fixes Needed:');
        
        $columns = Schema::getColumnListing('products');
        
        // Check what fields ProductManager is trying to use that don't exist
        $managerFields = ['sale_price', 'length', 'width', 'height', 'featured_image'];
        
        foreach ($managerFields as $field) {
            if (!in_array($field, $columns)) {
                $this->error("ProductManager uses '$field' but column doesn't exist");
                $this->line("  Fix: Add migration or remove from ProductManager");
            }
        }
        
        // Suggest the migration
        $this->info('Migration needed:');
        $this->line('php artisan make:migration add_missing_columns_to_products_table');
        
        $missingColumns = array_diff($managerFields, $columns);
        if (!empty($missingColumns)) {
            $this->line('Add these columns:');
            foreach ($missingColumns as $column) {
                if ($column === 'sale_price') {
                    $this->line("\$table->decimal('$column', 10, 2)->nullable();");
                } elseif (in_array($column, ['length', 'width', 'height'])) {
                    $this->line("\$table->decimal('$column', 8, 2)->nullable();");
                } elseif ($column === 'featured_image') {
                    $this->line("\$table->string('$column')->nullable();");
                }
            }
        }
    }
}
