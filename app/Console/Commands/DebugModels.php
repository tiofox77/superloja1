<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\ProductVariant;

class DebugModels extends Command
{
    protected $signature = 'debug:models {table?}';
    protected $description = 'Debug and compare model columns with database tables';

    public function handle()
    {
        $table = $this->argument('table');
        
        if ($table) {
            $this->debugSpecificTable($table);
        } else {
            $this->debugAllTables();
        }
    }

    private function debugAllTables()
    {
        $this->info('🔍 Debugging Product Models vs Database Tables');
        $this->newLine();
        
        $this->debugProductTable();
        $this->newLine(2);
        $this->debugProductVariantsTable();
    }

    private function debugSpecificTable($table)
    {
        switch ($table) {
            case 'products':
                $this->debugProductTable();
                break;
            case 'product_variants':
                $this->debugProductVariantsTable();
                break;
            default:
                $this->error("Table '$table' not supported. Use: products or product_variants");
        }
    }

    private function debugProductTable()
    {
        $this->info('📋 PRODUCTS TABLE ANALYSIS');
        $this->line('================================');
        
        // Get database columns
        $dbColumns = $this->getDatabaseColumns('products');
        
        // Get model fillable
        $model = new Product();
        $modelFillable = $model->getFillable();
        $modelCasts = $model->getCasts();
        
        $this->info('🗃️  Database Columns (' . count($dbColumns) . '):');
        foreach ($dbColumns as $column) {
            $type = $column->Type ?? $column->type ?? 'unknown';
            $nullable = ($column->Null ?? $column->nullable ?? 'NO') === 'YES' ? ' (nullable)' : '';
            $this->line("   • {$column->Field} [{$type}]{$nullable}");
        }
        
        $this->newLine();
        $this->info('📝 Model Fillable (' . count($modelFillable) . '):');
        foreach ($modelFillable as $field) {
            $this->line("   • $field");
        }
        
        $this->newLine();
        $this->info('🔄 Model Casts (' . count($modelCasts) . '):');
        foreach ($modelCasts as $field => $cast) {
            $this->line("   • $field => $cast");
        }
        
        // Find discrepancies
        $this->newLine();
        $this->findDiscrepancies('products', $dbColumns, $modelFillable, $modelCasts);
    }

    private function debugProductVariantsTable()
    {
        $this->info('📋 PRODUCT_VARIANTS TABLE ANALYSIS');
        $this->line('=====================================');
        
        // Get database columns
        $dbColumns = $this->getDatabaseColumns('product_variants');
        
        // Get model fillable
        $model = new ProductVariant();
        $modelFillable = $model->getFillable();
        $modelCasts = $model->getCasts();
        
        $this->info('🗃️  Database Columns (' . count($dbColumns) . '):');
        foreach ($dbColumns as $column) {
            $type = $column->Type ?? $column->type ?? 'unknown';
            $nullable = ($column->Null ?? $column->nullable ?? 'NO') === 'YES' ? ' (nullable)' : '';
            $this->line("   • {$column->Field} [{$type}]{$nullable}");
        }
        
        $this->newLine();
        $this->info('📝 Model Fillable (' . count($modelFillable) . '):');
        foreach ($modelFillable as $field) {
            $this->line("   • $field");
        }
        
        $this->newLine();
        $this->info('🔄 Model Casts (' . count($modelCasts) . '):');
        foreach ($modelCasts as $field => $cast) {
            $this->line("   • $field => $cast");
        }
        
        // Find discrepancies
        $this->newLine();
        $this->findDiscrepancies('product_variants', $dbColumns, $modelFillable, $modelCasts);
    }

    private function getDatabaseColumns($tableName)
    {
        try {
            // Try different ways to get column information
            if (DB::connection()->getDriverName() === 'mysql') {
                return DB::select("DESCRIBE $tableName");
            } else {
                return collect(Schema::getColumnListing($tableName))
                    ->map(function ($column) use ($tableName) {
                        return (object)[
                            'Field' => $column,
                            'Type' => Schema::getColumnType($tableName, $column),
                            'Null' => 'UNKNOWN'
                        ];
                    });
            }
        } catch (\Exception $e) {
            $this->error("Error getting columns for $tableName: " . $e->getMessage());
            return [];
        }
    }

    private function findDiscrepancies($tableName, $dbColumns, $modelFillable, $modelCasts)
    {
        $this->info("🔍 DISCREPANCIES ANALYSIS FOR $tableName");
        $this->line(str_repeat('=', 50));
        
        $dbColumnNames = collect($dbColumns)->pluck('Field')->toArray();
        $systemColumns = ['id', 'created_at', 'updated_at', 'deleted_at'];
        
        // Remove system columns for comparison
        $dbColumnNames = array_diff($dbColumnNames, $systemColumns);
        
        // 1. Columns in DB but not in fillable
        $missingInFillable = array_diff($dbColumnNames, $modelFillable);
        if (!empty($missingInFillable)) {
            $this->warn('❌ Columns in DATABASE but NOT in MODEL FILLABLE:');
            foreach ($missingInFillable as $column) {
                $this->line("   • $column");
            }
        } else {
            $this->info('✅ All database columns are in model fillable');
        }
        
        $this->newLine();
        
        // 2. Columns in fillable but not in DB
        $missingInDb = array_diff($modelFillable, $dbColumnNames);
        if (!empty($missingInDb)) {
            $this->warn('❌ Columns in MODEL FILLABLE but NOT in DATABASE:');
            foreach ($missingInDb as $column) {
                $this->line("   • $column");
            }
        } else {
            $this->info('✅ All model fillable columns exist in database');
        }
        
        $this->newLine();
        
        // 3. Cast columns that don't exist in DB
        $castKeys = array_keys($modelCasts);
        $invalidCasts = array_diff($castKeys, $dbColumnNames);
        if (!empty($invalidCasts)) {
            $this->warn('❌ Model CASTS for non-existent columns:');
            foreach ($invalidCasts as $column) {
                $this->line("   • $column => {$modelCasts[$column]}");
            }
        } else {
            $this->info('✅ All model casts reference existing columns');
        }
        
        // 4. Generate correction suggestions
        $this->newLine();
        $this->generateCorrections($tableName, $missingInFillable, $missingInDb, $invalidCasts);
    }

    private function generateCorrections($tableName, $missingInFillable, $missingInDb, $invalidCasts)
    {
        $this->info('🔧 CORRECTION SUGGESTIONS:');
        $this->line(str_repeat('-', 30));
        
        if (!empty($missingInFillable)) {
            $this->line('1. Add to model fillable:');
            $fillableString = "'" . implode("',\n        '", $missingInFillable) . "'";
            $this->line("   protected \$fillable = [");
            $this->line("       // existing fillable...");
            $this->line("       $fillableString");
            $this->line("   ];");
            $this->newLine();
        }
        
        if (!empty($missingInDb)) {
            $this->line('2. Create migration to add missing columns:');
            foreach ($missingInDb as $column) {
                $this->line("   \$table->string('$column')->nullable();");
            }
            $this->newLine();
        }
        
        if (!empty($invalidCasts)) {
            $this->line('3. Remove invalid casts from model:');
            foreach ($invalidCasts as $column) {
                $cast = isset($modelCasts[$column]) ? $modelCasts[$column] : 'unknown';
                $this->line("   Remove: '$column' => '$cast'");
            }
            $this->newLine();
        }
        
        // Generate sample queries for testing
        $this->info('🧪 TEST QUERIES:');
        $this->line("// Test $tableName table");
        $this->line("DB::table('$tableName')->count(); // Count records");
        $this->line("DB::table('$tableName')->first(); // Get first record");
        if ($tableName === 'products') {
            $this->line("Product::with(['category', 'brand', 'variants'])->first(); // Test relationships");
        } elseif ($tableName === 'product_variants') {
            $this->line("ProductVariant::with('product')->first(); // Test relationships");
        }
    }
}
