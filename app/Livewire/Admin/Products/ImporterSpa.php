<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

#[Layout('components.admin.layouts.app')]
#[Title('Importar Produtos')]
class ImporterSpa extends Component
{
    use WithFileUploads;

    public $file;
    public string $importType = 'csv';
    public bool $updateExisting = false;
    public ?int $defaultCategoryId = null;
    public ?int $defaultBrandId = null;
    
    public array $importResults = [];
    public bool $showResults = false;
    public int $successCount = 0;
    public int $errorCount = 0;
    public array $errors = [];

    protected $rules = [
        'file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
    ];

    public function import(): void
    {
        $this->validate();
        
        try {
            $path = $this->file->store('imports', 'local');
            $fullPath = storage_path('app/' . $path);
            
            $this->processFile($fullPath);
            
            Storage::disk('local')->delete($path);
            
            $this->showResults = true;
            $this->dispatch('toast', ['type' => 'success', 'message' => "Importação concluída! {$this->successCount} produtos importados."]);
            
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Erro na importação: ' . $e->getMessage()]);
        }
    }

    protected function processFile(string $path): void
    {
        $this->successCount = 0;
        $this->errorCount = 0;
        $this->errors = [];
        
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle, 0, ';');
        
        $lineNumber = 1;
        while (($data = fgetcsv($handle, 0, ';')) !== false) {
            $lineNumber++;
            
            try {
                $row = array_combine($header, $data);
                
                $productData = [
                    'name' => $row['name'] ?? $row['nome'] ?? '',
                    'description' => $row['description'] ?? $row['descricao'] ?? '',
                    'price' => (float) str_replace([',', ' '], ['.', ''], $row['price'] ?? $row['preco'] ?? 0),
                    'stock_quantity' => (int) ($row['stock'] ?? $row['estoque'] ?? $row['stock_quantity'] ?? 0),
                    'sku' => $row['sku'] ?? $row['codigo'] ?? null,
                    'category_id' => $this->defaultCategoryId,
                    'brand_id' => $this->defaultBrandId,
                    'is_active' => true,
                ];
                
                if (empty($productData['name'])) {
                    throw new \Exception('Nome do produto é obrigatório');
                }
                
                if ($this->updateExisting && !empty($productData['sku'])) {
                    $product = Product::where('sku', $productData['sku'])->first();
                    if ($product) {
                        $product->update($productData);
                    } else {
                        Product::create($productData);
                    }
                } else {
                    Product::create($productData);
                }
                
                $this->successCount++;
                
            } catch (\Exception $e) {
                $this->errorCount++;
                $this->errors[] = "Linha {$lineNumber}: " . $e->getMessage();
            }
        }
        
        fclose($handle);
    }

    public function downloadTemplate(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['name', 'description', 'price', 'stock_quantity', 'sku'], ';');
            fputcsv($output, ['Produto Exemplo', 'Descrição do produto', '1500', '10', 'SKU001'], ';');
            fclose($output);
        }, 'template_produtos.csv');
    }

    public function resetImport(): void
    {
        $this->reset(['file', 'showResults', 'successCount', 'errorCount', 'errors']);
    }

    public function render()
    {
        return view('livewire.admin.products.importer-spa', [
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
            'brands' => Brand::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
