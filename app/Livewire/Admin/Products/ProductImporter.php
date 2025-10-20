<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductImporter extends Component
{
    use WithFileUploads;

    public $file;
    public $importing = false;
    public $progress = 0;
    public $totalRows = 0;
    public $currentRow = 0;
    public $importedCount = 0;
    public $errorCount = 0;
    public $errors = [];
    public $logs = [];

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
    ];

    public function import()
    {
        $this->validate();
        
        $this->importing = true;
        $this->progress = 0;
        $this->importedCount = 0;
        $this->errorCount = 0;
        $this->errors = [];
        $this->logs = [];

        try {
            $this->addLog('Iniciando importação...');
            
            // Salvar arquivo temporariamente
            $filePath = $this->file->store('temp');
            $fullPath = storage_path('app/' . $filePath);
            
            // Ler arquivo Excel/CSV
            $data = $this->readExcelFile($fullPath);
            
            if (empty($data)) {
                throw new \Exception('Arquivo vazio ou formato inválido.');
            }

            $this->totalRows = count($data);
            $this->addLog("Arquivo carregado. {$this->totalRows} produtos encontrados.");

            // Processar cada linha
            foreach ($data as $index => $row) {
                $this->currentRow = $index + 1;
                $this->progress = ($this->currentRow / $this->totalRows) * 100;

                try {
                    $this->processRow($row);
                    $this->importedCount++;
                    $this->addLog("Produto {$this->currentRow}/{$this->totalRows} importado: " . ($row['title'] ?? 'N/A'));
                } catch (\Exception $e) {
                    $this->errorCount++;
                    $error = "Erro na linha {$this->currentRow}: " . $e->getMessage();
                    $this->errors[] = $error;
                    $this->addLog($error, 'error');
                }

                // Atualizar progresso
                if ($this->currentRow % 5 == 0) {
                    $this->dispatch('importProgress', ['progress' => $this->progress]);
                }
            }

            // Limpeza
            Storage::delete($filePath);
            
            $this->addLog("✅ Importação concluída! {$this->importedCount} produtos importados, {$this->errorCount} erros.");
            $this->dispatch('showAlert', ['type' => 'success', 'message' => "Importação concluída! {$this->importedCount} produtos importados."]);

        } catch (\Exception $e) {
            $this->addLog('❌ Erro geral: ' . $e->getMessage(), 'error');
            $this->dispatch('showAlert', ['type' => 'error', 'message' => 'Erro na importação: ' . $e->getMessage()]);
        } finally {
            $this->importing = false;
            $this->file = null;
        }
    }

    private function readExcelFile($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        
        if ($extension === 'csv') {
            return $this->readCsvFile($filePath);
        } else {
            // Para arquivos Excel, vamos usar uma leitura simples com PhpSpreadsheet se disponível
            // Por agora, vamos focar em CSV
            throw new \Exception('Por favor, exporte o arquivo como CSV para importação.');
        }
    }

    private function readCsvFile($filePath)
    {
        $data = [];
        $headers = [];
        
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            $rowIndex = 0;
            
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($rowIndex === 0) {
                    // Primeira linha são os cabeçalhos
                    $headers = array_map('trim', $row);
                } else {
                    // Criar array associativo com os dados
                    $rowData = [];
                    foreach ($headers as $index => $header) {
                        $rowData[$header] = isset($row[$index]) ? trim($row[$index]) : '';
                    }
                    $data[] = $rowData;
                }
                $rowIndex++;
            }
            fclose($handle);
        }
        
        return $data;
    }

    private function processRow($row)
    {
        // Mapear colunas do Excel
        $productData = [
            'name' => $row['title'] ?? '',
            'description' => $row['description'] ?? '',
            'price' => $this->parsePrice($row['price'] ?? '0'),
            'brand_name' => $row['brand'] ?? 'Genérico',
            'image_url' => $row['image_link'] ?? '',
            'availability' => $row['availability'] ?? 'in stock',
            'condition' => $row['condition'] ?? 'new',
        ];

        // Validações básicas
        if (empty($productData['name'])) {
            throw new \Exception('Nome do produto é obrigatório.');
        }

        // Criar/encontrar categoria (usando 'Eletrônicos' como padrão)
        $category = Category::firstOrCreate(
            ['name' => 'Eletrônicos'],
            [
                'slug' => 'eletronicos',
                'description' => 'Produtos eletrônicos diversos',
                'is_active' => true
            ]
        );

        // Criar/encontrar marca
        $brand = Brand::firstOrCreate(
            ['name' => $productData['brand_name']],
            [
                'slug' => Str::slug($productData['brand_name']),
                'description' => 'Marca ' . $productData['brand_name'],
                'is_active' => true
            ]
        );

        // Baixar imagem
        $imagePath = null;
        if (!empty($productData['image_url'])) {
            $imagePath = $this->downloadImage($productData['image_url'], $productData['name']);
        }

        // Gerar SKU único
        $sku = $this->generateUniqueSku($productData['name']);

        // Determinar stock baseado na disponibilidade
        $stockQuantity = $productData['availability'] === 'in stock' ? rand(5, 50) : 0;
        $stockStatus = $productData['availability'] === 'in stock' ? 'in_stock' : 'out_of_stock';

        // Criar produto
        Product::create([
            'name' => $productData['name'],
            'slug' => Str::slug($productData['name']),
            'description' => $productData['description'],
            'short_description' => Str::limit($productData['description'], 100),
            'sku' => $sku,
            'price' => $productData['price'],
            'sale_price' => $productData['price'] * 0.9, // 10% desconto como promoção
            'stock_quantity' => $stockQuantity,
            'stock_status' => $stockStatus,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'featured_image' => $imagePath,
            'images' => $imagePath ? [$imagePath] : [],
            'is_active' => true,
            'is_featured' => rand(0, 1) === 1, // 50% chance
            'meta_title' => $productData['name'],
            'meta_description' => Str::limit($productData['description'], 160),
        ]);
    }

    private function parsePrice($priceString)
    {
        // Remove caracteres não numéricos exceto ponto e vírgula
        $price = preg_replace('/[^0-9.,]/', '', $priceString);
        
        // Converte vírgula para ponto
        $price = str_replace(',', '.', $price);
        
        // Converte para float
        $price = floatval($price);
        
        // Se o preço for muito baixo, assume que está em formato centavos
        if ($price < 100 && $price > 0) {
            $price = $price * 1000; // Multiplica para ter um preço realista em Kwanzas
        }
        
        return max(1000, $price); // Preço mínimo de 1000 Kz
    }

    private function downloadImage($url, $productName)
    {
        try {
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                $extension = 'jpg';
                
                // Gerar nome de arquivo único
                $filename = Str::slug($productName) . '-' . time() . '.' . $extension;
                $path = "products/{$filename}";
                
                Storage::disk('public')->put($path, $response->body());
                
                return $path;
            }
        } catch (\Exception $e) {
            $this->addLog("Erro ao baixar imagem: {$url} - " . $e->getMessage(), 'warning');
        }

        return null;
    }

    private function generateUniqueSku($name)
    {
        $base = strtoupper(Str::slug($name, ''));
        $base = substr($base, 0, 8); // Primeiros 8 caracteres
        $counter = 1;
        
        do {
            $sku = $base . str_pad($counter, 3, '0', STR_PAD_LEFT);
            $counter++;
        } while (Product::where('sku', $sku)->exists());
        
        return $sku;
    }

    private function addLog($message, $type = 'info')
    {
        $this->logs[] = [
            'message' => $message,
            'type' => $type,
            'time' => now()->format('H:i:s')
        ];
    }

    public function resetImport()
    {
        $this->file = null;
        $this->importing = false;
        $this->progress = 0;
        $this->totalRows = 0;
        $this->currentRow = 0;
        $this->importedCount = 0;
        $this->errorCount = 0;
        $this->errors = [];
        $this->logs = [];
    }

    public function render()
    {
        return view('livewire.admin.products.product-importer')
            ->layout('components.layouts.admin', ['title' => 'Importar Produtos']);
    }
}
