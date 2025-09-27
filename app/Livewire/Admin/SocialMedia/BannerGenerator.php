<?php

namespace App\Livewire\Admin\SocialMedia;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BannerGenerator extends Component
{
    use WithFileUploads;

    // Banner settings
    public $bannerType = 'product_showcase';
    public $bannerSize = 'facebook_post'; // 1200x630
    public $selectedProducts = [];
    public $backgroundImage;
    public $backgroundColor = '#ffffff';
    public $textColor = '#000000';
    public $overlayOpacity = 50;

    // Text content
    public $mainTitle = '';
    public $subtitle = '';
    public $ctaText = 'Confira agora!';
    public $logoPosition = 'top-right';
    public $showPrices = true;
    public $showDiscount = true;

    // Design options
    public $template = 'modern';
    public $fontFamily = 'Roboto';
    public $borderRadius = 10;
    public $shadowIntensity = 3;

    // Preview
    public $previewUrl = null;
    public $showPreview = false;

    public $bannerTypes = [
        'product_showcase' => 'Showcase de Produtos',
        'sale_announcement' => 'Anúncio de Promoção',
        'brand_awareness' => 'Awareness de Marca',
        'category_highlight' => 'Destaque de Categoria',
        'new_arrivals' => 'Novos Produtos',
        'custom' => 'Banner Personalizado'
    ];

    public $bannerSizes = [
        'facebook_post' => ['name' => 'Facebook Post', 'width' => 1200, 'height' => 630],
        'facebook_story' => ['name' => 'Facebook Story', 'width' => 1080, 'height' => 1920],
        'instagram_post' => ['name' => 'Instagram Post', 'width' => 1080, 'height' => 1080],
        'instagram_story' => ['name' => 'Instagram Story', 'width' => 1080, 'height' => 1920],
        'twitter_post' => ['name' => 'Twitter Post', 'width' => 1200, 'height' => 675],
        'linkedin_post' => ['name' => 'LinkedIn Post', 'width' => 1200, 'height' => 627],
        'youtube_thumbnail' => ['name' => 'YouTube Thumbnail', 'width' => 1280, 'height' => 720],
        'web_banner' => ['name' => 'Banner Web', 'width' => 1920, 'height' => 600],
        'custom' => ['name' => 'Personalizado', 'width' => 1200, 'height' => 630]
    ];

    public $templates = [
        'modern' => 'Moderno',
        'elegant' => 'Elegante',
        'bold' => 'Ousado',
        'minimal' => 'Minimalista',
        'gradient' => 'Gradiente',
        'geometric' => 'Geométrico'
    ];

    public $fonts = [
        'Roboto' => 'Roboto',
        'Open Sans' => 'Open Sans',
        'Lato' => 'Lato',
        'Montserrat' => 'Montserrat',
        'Poppins' => 'Poppins',
        'Oswald' => 'Oswald'
    ];

    public function render()
    {
        $products = Product::with(['category', 'brand'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = Category::where('is_active', true)->get();
        $brands = Brand::where('is_active', true)->get();

        return view('livewire.admin.social-media.banner-generator', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ])->layout('components.layouts.admin', [
            'title' => 'Gerador de Banners',
            'pageTitle' => 'Redes Sociais - Banners'
        ]);
    }

    public function updatedBannerType()
    {
        // Auto-populate fields based on banner type
        switch ($this->bannerType) {
            case 'sale_announcement':
                $this->mainTitle = 'PROMOÇÃO ESPECIAL';
                $this->subtitle = 'Descontos imperdíveis';
                $this->ctaText = 'Aproveite agora!';
                $this->backgroundColor = '#ff4444';
                $this->textColor = '#ffffff';
                break;
            case 'brand_awareness':
                $this->mainTitle = 'SuperLoja';
                $this->subtitle = 'Sua loja online de confiança';
                $this->ctaText = 'Conheça nossos produtos';
                $this->showPrices = false;
                break;
            case 'new_arrivals':
                $this->mainTitle = 'NOVIDADES';
                $this->subtitle = 'Últimos lançamentos';
                $this->ctaText = 'Ver novidades';
                break;
        }
    }

    public function addProduct($productId)
    {
        if (!in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts[] = $productId;
        }
    }

    public function removeProduct($productId)
    {
        $this->selectedProducts = array_filter($this->selectedProducts, function($id) use ($productId) {
            return $id != $productId;
        });
    }

    public function selectProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)
            ->where('is_active', true)
            ->limit(4)
            ->pluck('id')
            ->toArray();

        $this->selectedProducts = array_unique(array_merge($this->selectedProducts, $products));
    }

    public function selectProductsByBrand($brandId)
    {
        $products = Product::where('brand_id', $brandId)
            ->where('is_active', true)
            ->limit(4)
            ->pluck('id')
            ->toArray();

        $this->selectedProducts = array_unique(array_merge($this->selectedProducts, $products));
    }

    public function generatePreview()
    {
        try {
            $bannerPath = $this->createBanner();
            $this->previewUrl = Storage::url($bannerPath);
            $this->showPreview = true;

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Preview gerado com sucesso!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro ao gerar preview do banner: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao gerar preview: ' . $e->getMessage()
            ]);
        }
    }

    public function downloadBanner()
    {
        try {
            $bannerPath = $this->createBanner();
            $fileName = 'banner_' . $this->bannerType . '_' . time() . '.png';
            
            return response()->download(storage_path('app/public/' . $bannerPath), $fileName);

        } catch (\Exception $e) {
            \Log::error('Erro ao baixar banner: ' . $e->getMessage());
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao baixar banner: ' . $e->getMessage()
            ]);
        }
    }

    private function createBanner()
    {
        $size = $this->bannerSizes[$this->bannerSize];
        $width = $size['width'];
        $height = $size['height'];

        // Create base canvas
        $canvas = Image::canvas($width, $height, $this->backgroundColor);

        // Add background image if provided
        if ($this->backgroundImage) {
            $bg = Image::make($this->backgroundImage->getRealPath())
                ->fit($width, $height);
            
            // Apply overlay
            if ($this->overlayOpacity > 0) {
                $overlay = Image::canvas($width, $height, 
                    $this->hexToRgba($this->backgroundColor, $this->overlayOpacity / 100));
                $bg->insert($overlay);
            }
            
            $canvas = $bg;
        }

        // Add products
        if (!empty($this->selectedProducts) && $this->bannerType !== 'custom') {
            $this->addProductsToCanvas($canvas, $width, $height);
        }

        // Add text content
        $this->addTextToCanvas($canvas, $width, $height);

        // Add logo
        $this->addLogoToCanvas($canvas, $width, $height);

        // Apply template styling
        $this->applyTemplateEffects($canvas, $width, $height);

        // Save banner
        $fileName = 'banners/banner_' . time() . '.png';
        $fullPath = storage_path('app/public/' . $fileName);
        
        // Ensure directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $canvas->save($fullPath, 90);

        return $fileName;
    }

    private function addProductsToCanvas($canvas, $width, $height)
    {
        $products = Product::whereIn('id', array_slice($this->selectedProducts, 0, 4))->get();
        
        if ($products->isEmpty()) return;

        $productCount = min(4, $products->count());
        $productWidth = min(200, $width / ($productCount + 1));
        $productHeight = min(200, $height / 3);
        
        $startX = ($width - ($productCount * $productWidth)) / 2;
        $startY = $height - $productHeight - 100;

        foreach ($products->take(4) as $index => $product) {
            if ($product->featured_image_url) {
                try {
                    $productImage = Image::make($product->featured_image_url)
                        ->fit($productWidth - 20, $productHeight - 60);
                    
                    $x = $startX + ($index * $productWidth) + 10;
                    $y = $startY;
                    
                    // Add product image
                    $canvas->insert($productImage, 'top-left', $x, $y);
                    
                    // Add price if enabled
                    if ($this->showPrices) {
                        $price = number_format($product->sale_price ?? $product->price, 2) . ' Kz';
                        $canvas->text($price, $x + $productWidth/2, $y + $productHeight - 20, function($font) {
                            $font->file(public_path('fonts/Roboto-Bold.ttf'));
                            $font->size(16);
                            $font->color($this->textColor);
                            $font->align('center');
                        });
                    }
                    
                } catch (\Exception $e) {
                    \Log::warning('Erro ao adicionar produto ao banner: ' . $e->getMessage());
                }
            }
        }
    }

    private function addTextToCanvas($canvas, $width, $height)
    {
        if ($this->mainTitle) {
            $canvas->text($this->mainTitle, $width/2, $height/3, function($font) {
                $font->file(public_path('fonts/Roboto-Bold.ttf'));
                $font->size(min(48, $width/20));
                $font->color($this->textColor);
                $font->align('center');
                $font->valign('middle');
            });
        }

        if ($this->subtitle) {
            $canvas->text($this->subtitle, $width/2, $height/3 + 60, function($font) {
                $font->file(public_path('fonts/Roboto-Regular.ttf'));
                $font->size(min(24, $width/40));
                $font->color($this->textColor);
                $font->align('center');
                $font->valign('middle');
            });
        }

        if ($this->ctaText) {
            $canvas->text($this->ctaText, $width/2, $height - 50, function($font) {
                $font->file(public_path('fonts/Roboto-Medium.ttf'));
                $font->size(min(20, $width/50));
                $font->color($this->textColor);
                $font->align('center');
                $font->valign('middle');
            });
        }
    }

    private function addLogoToCanvas($canvas, $width, $height)
    {
        $logoPath = public_path('images/logo.png');
        if (!file_exists($logoPath)) return;

        try {
            $logo = Image::make($logoPath)->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            switch ($this->logoPosition) {
                case 'top-left':
                    $canvas->insert($logo, 'top-left', 20, 20);
                    break;
                case 'top-right':
                    $canvas->insert($logo, 'top-right', 20, 20);
                    break;
                case 'bottom-left':
                    $canvas->insert($logo, 'bottom-left', 20, 20);
                    break;
                case 'bottom-right':
                    $canvas->insert($logo, 'bottom-right', 20, 20);
                    break;
            }
        } catch (\Exception $e) {
            \Log::warning('Erro ao adicionar logo: ' . $e->getMessage());
        }
    }

    private function applyTemplateEffects($canvas, $width, $height)
    {
        switch ($this->template) {
            case 'gradient':
                $this->applyGradientEffect($canvas, $width, $height);
                break;
            case 'geometric':
                $this->applyGeometricEffect($canvas, $width, $height);
                break;
        }
    }

    private function applyGradientEffect($canvas, $width, $height)
    {
        // Add gradient overlay
        $gradient = Image::canvas($width, $height, 'rgba(0,0,0,0)');
        // Note: Creating actual gradient would require more complex implementation
        $canvas->insert($gradient, 'bottom-left', 0, 0);
    }

    private function applyGeometricEffect($canvas, $width, $height)
    {
        // Add geometric shapes
        // Note: This would require more complex shape drawing implementation
    }

    private function hexToRgba($hex, $alpha)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        return "rgba($r, $g, $b, $alpha)";
    }
}
