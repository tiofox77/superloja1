<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Catalog;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class CatalogGenerator extends Component
{
    public $selectedProducts = [];
    public $selectedCategories = [];
    public $selectedBrands = [];
    public $catalogTitle = 'Catálogo SuperLoja';
    public $catalogDescription = 'Descubra os melhores produtos com preços incríveis!';
    public $includeImages = true;
    public $includePrices = true;
    public $includeDescriptions = true;
    public $catalogLayout = 'grid';
    public $productsPerPage = 12;
    public $showModal = false;
    public $previewUrl = null;
    public $downloadingImages = false;
    public $imageDownloadProgress = 0;
    public $imageDownloadTotal = 0;

    // Filters
    public $search = '';
    public $filterCategory = '';
    public $filterBrand = '';
    public $filterStatus = 'active';

    public function render()
    {
        $products = Product::query()
            ->with(['category', 'brand'])
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCategory, function($query) {
                $query->where('category_id', $this->filterCategory);
            })
            ->when($this->filterBrand, function($query) {
                $query->where('brand_id', $this->filterBrand);
            })
            ->when($this->filterStatus === 'active', function($query) {
                $query->where('is_active', true);
            })
            ->when($this->filterStatus === 'all', function($query) {
                // Não aplica filtro, mostra todos
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        // Melhorar as estatísticas
        $selectedProductsData = Product::whereIn('id', $this->selectedProducts)->with(['category', 'brand'])->get();
        
        $stats = [
            'total_products' => count($this->selectedProducts),
            'estimated_pages' => $this->selectedProducts ? ceil(count($this->selectedProducts) / $this->productsPerPage) : 0,
            'categories_count' => $selectedProductsData->unique('category_id')->count(),
            'brands_count' => $selectedProductsData->unique('brand_id')->count(),
            'total_available' => $products->total(),
        ];

        return view('livewire.admin.catalog.catalog-generator', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Gerador de Catálogos',
            'pageTitle' => 'Catálogos'
        ]);
    }

    public function toggleProduct($productId): void
    {
        if (in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
        } else {
            $this->selectedProducts[] = $productId;
        }
    }

    public function selectAllProducts(): void
    {
        $query = Product::query();
        
        // Aplicar os mesmos filtros da query principal
        $query->when($this->search, function($q) {
            $q->where('name', 'like', '%' . $this->search . '%')
              ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->when($this->filterCategory, function($q) {
            $q->where('category_id', $this->filterCategory);
        })
        ->when($this->filterBrand, function($q) {
            $q->where('brand_id', $this->filterBrand);
        })
        ->when($this->filterStatus === 'active', function($q) {
            $q->where('is_active', true);
        });
        
        $products = $query->pluck('id')->toArray();
        $this->selectedProducts = array_unique(array_merge($this->selectedProducts, $products));
        
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => count($products) . ' produtos selecionados!'
        ]);
    }

    public function clearSelection(): void
    {
        $this->selectedProducts = [];
        $this->dispatch('showAlert', [
            'type' => 'info',
            'message' => 'Seleção limpa!'
        ]);
    }

    public function selectByCategory($categoryId): void
    {
        $products = Product::where('category_id', $categoryId)
            ->when($this->filterStatus === 'active', function($query) {
                $query->where('is_active', true);
            })
            ->pluck('id')
            ->toArray();
        
        $this->selectedProducts = array_unique(array_merge($this->selectedProducts, $products));
        
        $categoryName = Category::find($categoryId)->name ?? 'Categoria';
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => count($products) . ' produtos de "' . $categoryName . '" adicionados à seleção!'
        ]);
    }

    public function selectByBrand($brandId): void
    {
        $products = Product::where('brand_id', $brandId)
            ->when($this->filterStatus === 'active', function($query) {
                $query->where('is_active', true);
            })
            ->pluck('id')
            ->toArray();
        
        $this->selectedProducts = array_unique(array_merge($this->selectedProducts, $products));
        
        $brandName = Brand::find($brandId)->name ?? 'Marca';
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => count($products) . ' produtos da marca "' . $brandName . '" adicionados à seleção!'
        ]);
    }

    public function generatePreview(): void
    {
        if (empty($this->selectedProducts)) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Selecione pelo menos um produto para gerar o catálogo.'
            ]);
            return;
        }

        try {
            $products = Product::with(['category', 'brand'])
                ->whereIn('id', $this->selectedProducts)
                ->orderBy('name')
                ->get();

            if ($products->isEmpty()) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'Nenhum produto válido encontrado.'
                ]);
                return;
            }

            $html = $this->generateCatalogHtml($products, false);
            
            // Ensure directory exists
            if (!Storage::disk('public')->exists('catalogs')) {
                Storage::disk('public')->makeDirectory('catalogs');
            }
            
            // Save preview to storage
            $filename = 'catalog_preview_' . time() . '.html';
            $filePath = 'catalogs/' . $filename;
            
            Storage::disk('public')->put($filePath, $html);
            
            // Verify file was created
            if (!Storage::disk('public')->exists($filePath)) {
                throw new \Exception('Arquivo de preview não foi criado.');
            }
            
            $this->previewUrl = Storage::url($filePath);
            $this->showModal = true;
            
            // Debug log
            \Log::info('Preview gerado:', [
                'file_path' => $filePath,
                'preview_url' => $this->previewUrl,
                'show_modal' => $this->showModal,
                'file_exists' => Storage::disk('public')->exists($filePath),
                'file_size' => Storage::disk('public')->size($filePath)
            ]);
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Pré-visualização gerada com ' . $products->count() . ' produtos! URL: ' . $this->previewUrl
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar preview: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao gerar pré-visualização: ' . $e->getMessage()
            ]);
        }
    }

    public function generatePDF()
    {
        if (empty($this->selectedProducts)) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Selecione pelo menos um produto para gerar o catálogo.'
            ]);
            return;
        }

        try {
            $products = Product::with(['category', 'brand'])
                ->whereIn('id', $this->selectedProducts)
                ->orderBy('name')
                ->get();

            if ($products->isEmpty()) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'Nenhum produto válido encontrado.'
                ]);
                return;
            }

            $html = $this->generateCatalogHtml($products, true);
            
            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'dpi' => 150,
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => false,
                    'isFontSubsettingEnabled' => true,
                    'isRemoteEnabled' => true,
                ]);

            $filename = 'catalogo_superloja_' . date('Y-m-d_H-i-s') . '.pdf';
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'PDF gerado com sucesso!'
            ]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $filename, [
                'Content-Type' => 'application/pdf',
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar PDF: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao gerar PDF: ' . $e->getMessage()
            ]);
        }
    }

    private function generateCatalogHtml($products, $forPdf = false): string
    {
        // Garantir que os produtos têm as informações necessárias
        $products = $products->map(function($product) {
            // Garantir que o accessor está sendo chamado
            $product->featured_image_url = $product->featured_image_url;
            return $product;
        });

        $html = view('admin.catalog.templates.catalog', [
            'products' => $products,
            'title' => $this->catalogTitle,
            'description' => $this->catalogDescription,
            'includeImages' => $this->includeImages,
            'includePrices' => $this->includePrices,
            'includeDescriptions' => $this->includeDescriptions,
            'layout' => $this->catalogLayout,
            'productsPerPage' => $this->productsPerPage,
            'forPdf' => $forPdf,
            'baseUrl' => $forPdf ? '' : url('/'),
        ])->render();

        // Para debug - log das diferenças
        if ($forPdf) {
            \Log::info('Gerando PDF:', [
                'produtos' => $products->count(),
                'title' => $this->catalogTitle,
                'layout' => $this->catalogLayout,
                'include_images' => $this->includeImages,
                'include_prices' => $this->includePrices,
                'include_descriptions' => $this->includeDescriptions,
                'products_per_page' => $this->productsPerPage
            ]);
        } else {
            \Log::info('Gerando Preview:', [
                'produtos' => $products->count(),
                'title' => $this->catalogTitle,
                'layout' => $this->catalogLayout,
                'include_images' => $this->includeImages,
                'include_prices' => $this->includePrices,
                'include_descriptions' => $this->includeDescriptions,
                'products_per_page' => $this->productsPerPage
            ]);
        }

        return $html;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->previewUrl = null;
    }

    public function downloadImagesForProducts(): void
    {
        $productsWithoutImages = Product::where(function($query) {
            $query->whereNull('featured_image')
                  ->orWhere('featured_image', '')
                  ->orWhere(function($q) {
                      $q->whereNull('images')
                        ->orWhereJsonLength('images', 0);
                  });
        })->get();

        if ($productsWithoutImages->isEmpty()) {
            $this->dispatch('showAlert', [
                'type' => 'info',
                'message' => 'Todos os produtos já possuem imagens!'
            ]);
            return;
        }

        $this->downloadingImages = true;
        $this->imageDownloadTotal = $productsWithoutImages->count();
        $this->imageDownloadProgress = 0;

        foreach ($productsWithoutImages as $product) {
            try {
                $this->downloadProductImage($product);
                $this->imageDownloadProgress++;
                
                // Dispatch progress update
                $this->dispatch('imageDownloadProgress', [
                    'current' => $this->imageDownloadProgress,
                    'total' => $this->imageDownloadTotal,
                    'product' => $product->name
                ]);
                
                // Small delay to avoid hitting API rate limits
                usleep(500000); // 0.5 seconds
                
            } catch (\Exception $e) {
                \Log::error('Erro ao baixar imagem para o produto ' . $product->id . ': ' . $e->getMessage());
                continue;
            }
        }

        $this->downloadingImages = false;
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => "Processo concluído! {$this->imageDownloadProgress} de {$this->imageDownloadTotal} imagens baixadas."
        ]);
    }

    private function downloadProductImage(Product $product): bool
    {
        try {
            // Clean product name for search
            $searchTerm = $this->cleanProductName($product->name);
            
            // Try Unsplash API first
            $imageUrl = $this->searchUnsplashImage($searchTerm);
            
            // Fallback to Lorem Picsum with relevant categories
            if (!$imageUrl) {
                $imageUrl = $this->getLoremPicsumImage($product);
            }
            
            if ($imageUrl) {
                $imagePath = $this->downloadAndSaveImage($imageUrl, $product->id);
                if ($imagePath) {
                    $product->update(['featured_image' => $imagePath]);
                    return true;
                }
            }
            
            return false;
        } catch (\Exception $e) {
            \Log::error('Erro no download da imagem do produto ' . $product->id . ': ' . $e->getMessage());
            return false;
        }
    }

    private function cleanProductName(string $name): string
    {
        // Remove special characters and common words
        $cleanName = strtolower($name);
        $removeWords = ['com', 'de', 'da', 'do', 'para', 'em', 'na', 'no', 'e', 'ou', 'um', 'uma'];
        
        foreach ($removeWords as $word) {
            $cleanName = str_replace(' ' . $word . ' ', ' ', $cleanName);
        }
        
        // Remove numbers, special chars, keep only letters and spaces
        $cleanName = preg_replace('/[^a-zA-Z\s]/', ' ', $cleanName);
        $cleanName = trim(preg_replace('/\s+/', ' ', $cleanName));
        
        // Get first 2-3 relevant words
        $words = explode(' ', $cleanName);
        return implode(' ', array_slice($words, 0, 2));
    }

    private function searchUnsplashImage(string $query): ?string
    {
        try {
            // Using Unsplash's free API
            $response = Http::timeout(10)->get('https://api.unsplash.com/search/photos', [
                'query' => $query,
                'per_page' => 1,
                'client_id' => env('UNSPLASH_ACCESS_KEY', 'demo') // You would need to get a free API key
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (!empty($data['results'])) {
                    return $data['results'][0]['urls']['regular'] ?? null;
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Erro na busca Unsplash: ' . $e->getMessage());
        }

        return null;
    }

    private function getLoremPicsumImage(Product $product): string
    {
        // Generate different image categories based on product category
        $categoryMappings = [
            'eletrônicos' => ['technology', 'gadgets', 'electronics'],
            'roupas' => ['fashion', 'clothing', 'style'],
            'casa' => ['home', 'furniture', 'interior'],
            'beleza' => ['beauty', 'cosmetics', 'skincare'],
            'esportes' => ['sports', 'fitness', 'outdoor'],
            'livros' => ['books', 'education', 'reading'],
            'saúde' => ['health', 'medicine', 'wellness'],
        ];

        $categoryName = strtolower($product->category->name ?? '');
        $seed = $product->id;
        
        // Use a more generic approach with Lorem Picsum
        return "https://picsum.photos/seed/{$seed}/400/300";
    }

    private function downloadAndSaveImage(string $imageUrl, int $productId): ?string
    {
        try {
            $response = Http::timeout(30)->get($imageUrl);
            
            if (!$response->successful()) {
                return null;
            }

            $imageContent = $response->body();
            $extension = $this->getImageExtension($imageUrl, $imageContent);
            $filename = 'products/product_' . $productId . '_' . time() . '.' . $extension;
            
            // Save original image
            Storage::disk('public')->put($filename, $imageContent);
            
            // Optimize image using Intervention Image
            $imagePath = storage_path('app/public/' . $filename);
            
            if (extension_loaded('gd') || extension_loaded('imagick')) {
                try {
                    $image = Image::make($imagePath);
                    $image->resize(400, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save();
                } catch (\Exception $e) {
                    // If image processing fails, keep the original
                    \Log::warning('Erro no processamento da imagem: ' . $e->getMessage());
                }
            }
            
            return $filename;
        } catch (\Exception $e) {
            \Log::error('Erro no download da imagem: ' . $e->getMessage());
            return null;
        }
    }

    private function getImageExtension(string $url, string $content): string
    {
        // Try to get extension from URL
        $urlExtension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        if ($urlExtension && in_array(strtolower($urlExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return $urlExtension;
        }

        // Try to detect from content
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $content);
        finfo_close($finfo);

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];

        return $extensions[$mimeType] ?? 'jpg';
    }
}
