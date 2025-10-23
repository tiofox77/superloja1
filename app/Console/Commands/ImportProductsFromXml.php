<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportProductsFromXml extends Command
{
    protected $signature = 'products:import-xml {file=produtos-export-2025-10-20.xml}';
    protected $description = 'Importar produtos do XML, baixar imagens e popular banco';

    public function handle()
    {
        $filePath = base_path($this->argument('file'));
        
        if (!file_exists($filePath)) {
            $this->error("Arquivo não encontrado: {$filePath}");
            return 1;
        }

        $this->info('🔄 Iniciando importação de produtos...');
        
        // Perguntar se quer apagar produtos existentes
        if ($this->confirm('⚠️  Apagar TODOS os produtos existentes?', false)) {
            $this->info('🗑️  Apagando produtos...');
            $count = Product::count();
            Product::query()->delete();
            $this->info("✅ {$count} produtos apagados!");
        }

        // Ler XML
        $xml = simplexml_load_file($filePath);
        $total = count($xml->lista->produto);
        
        $this->info("📦 Total de produtos a importar: {$total}");
        $this->newLine();

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $imported = 0;
        $failed = 0;

        foreach ($xml->lista->produto as $produtoXml) {
            try {
                // Buscar ou criar categoria
                $categoryName = trim((string)$produtoXml->categoria->nome);
                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    [
                        'slug' => Str::slug($categoryName),
                        'is_active' => true,
                    ]
                );

                // Baixar e salvar imagem
                $imagemUrl = (string)$produtoXml->imagens->principal;
                $imagemPath = null;
                
                if ($imagemUrl) {
                    $imagemPath = $this->downloadImage($imagemUrl, (string)$produtoXml->slug);
                }

                // Criar produto
                $nome = trim((string)$produtoXml->nome);
                $preco = (float)$produtoXml->preco->valor;
                $estoque = (int)$produtoXml->estoque->quantidade;
                $descricao = trim((string)$produtoXml->descricao);

                Product::create([
                    'category_id' => $category->id,
                    'name' => $nome,
                    'slug' => Str::slug($nome),
                    'sku' => 'SKU-' . strtoupper(Str::random(8)),
                    'description' => $descricao ?: "Produto de qualidade {$nome}",
                    'short_description' => Str::limit($descricao ?: "Produto {$nome}", 100),
                    'price' => $preco,
                    'stock_quantity' => $estoque,
                    'featured_image' => $imagemPath,
                    'images' => $imagemPath ? [$imagemPath] : [],
                    'is_active' => (string)$produtoXml->ativo === 'true',
                    'is_featured' => false,
                    'stock_status' => $estoque > 0 ? 'in_stock' : 'out_of_stock',
                    'manage_stock' => true,
                ]);

                $imported++;
                
            } catch (\Exception $e) {
                $failed++;
                $this->newLine();
                $this->error("Erro ao importar: {$nome} - " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Resumo
        $this->info("✅ Importação concluída!");
        $this->table(
            ['Status', 'Quantidade'],
            [
                ['✅ Importados', $imported],
                ['❌ Falharam', $failed],
                ['📊 Total', $total],
            ]
        );

        // Mostrar categorias criadas
        $categorias = Category::count();
        $this->info("📁 Categorias criadas: {$categorias}");
        
        return 0;
    }

    private function downloadImage(string $url, string $slug): ?string
    {
        try {
            // Fazer download da imagem
            $response = Http::timeout(30)->get($url);
            
            if (!$response->successful()) {
                return null;
            }

            // Gerar nome único
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            if (!$extension) {
                $extension = 'jpg';
            }
            
            $filename = Str::slug($slug) . '-' . time() . '-' . Str::random(6) . '.' . $extension;
            $path = 'products/' . $filename;

            // Salvar no storage
            Storage::disk('public')->put($path, $response->body());

            return $path;
            
        } catch (\Exception $e) {
            $this->warn("Erro ao baixar imagem: {$url}");
            return null;
        }
    }
}
