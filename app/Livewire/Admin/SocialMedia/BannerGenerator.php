<?php

namespace App\Livewire\Admin\SocialMedia;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

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
        'geometric' => 'Geométrico',
        'dotted' => 'Bolinhas (Padrão)',
        'card' => 'Card Centralizado'
    ];

    public $backgroundPatterns = [
        'none' => 'Sem padrão',
        'dots' => 'Bolinhas',
        'circles' => 'Círculos',
        'waves' => 'Ondas',
        'diagonal' => 'Diagonal'
    ];

    public $backgroundPattern = 'dots';
    public $showLogo = true;
    public $logoUrl = '';

    public $fonts = [
        'Roboto' => 'Roboto',
        'Open Sans' => 'Open Sans',
        'Lato' => 'Lato',
        'Montserrat' => 'Montserrat',
        'Poppins' => 'Poppins',
        'Oswald' => 'Oswald'
    ];

    public function mount()
    {
        // Inicializar com valores padrão - cores vibrantes
        $this->mainTitle = 'Um dos nossos produtos';
        $this->subtitle = 'para criação de conteúdos online';
        $this->logoUrl = 'superloja.vip';
        $this->backgroundColor = '#E91E63'; // Rosa vibrante (Material Design Pink)
        $this->template = 'card'; // Template padrão
        $this->backgroundPattern = 'dots'; // Bolinhas padrão
    }

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
                $this->mainTitle = 'SuperLoja Angola';
                $this->subtitle = 'Sua loja online de confiança';
                $this->ctaText = 'Conheça nossos produtos';
                $this->logoUrl = 'superloja.vip';
                $this->showPrices = false;
                break;
            case 'new_arrivals':
                $this->mainTitle = 'NOVIDADES';
                $this->subtitle = 'Últimos lançamentos';
                $this->ctaText = 'Ver novidades';
                break;
            case 'product_showcase':
                $this->mainTitle = 'Um dos nossos produtos';
                $this->subtitle = 'Qualidade e confiança';
                $this->logoUrl = 'superloja.vip';
                break;
        }
    }

    public function updatedTemplate()
    {
        // Auto-populate for dotted/card templates com cores vibrantes
        if ($this->template === 'dotted' || $this->template === 'card') {
            $this->backgroundColor = '#E91E63'; // Rosa vibrante
            $this->backgroundPattern = 'dots';
            $this->logoUrl = 'superloja.vip';
        } elseif ($this->template === 'modern') {
            $this->backgroundColor = '#9C27B0'; // Roxo vibrante (Material Purple)
        } elseif ($this->template === 'bold') {
            $this->backgroundColor = '#FF5722'; // Laranja profundo
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
            \Log::info('Gerando banner com configurações:', [
                'template' => $this->template,
                'backgroundColor' => $this->backgroundColor,
                'mainTitle' => $this->mainTitle,
                'logoUrl' => $this->logoUrl,
                'selectedProducts' => $this->selectedProducts
            ]);

            $bannerPath = $this->createBanner();
            $this->previewUrl = Storage::url($bannerPath);
            $this->showPreview = true;

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Preview gerado com sucesso!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro ao gerar preview do banner: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
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

        \Log::info("Criando banner {$width}x{$height} com cor {$this->backgroundColor}");

        // Criar imagem base com GD
        $canvas = imagecreatetruecolor($width, $height);
        
        // Habilitar alpha blending para transparência
        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);
        
        // Forçar cor vibrante para templates card e dotted
        if ($this->template === 'card' || $this->template === 'dotted') {
            if ($this->backgroundColor === '#ffffff' || empty($this->backgroundColor)) {
                $this->backgroundColor = '#E91E63'; // Rosa vibrante
                \Log::info("Aplicando cor vibrante rosa para template {$this->template}");
            }
        }
        
        // FUNDO SÓLIDO VIBRANTE (flat design)
        list($r, $g, $b) = $this->hexToRgbArray($this->backgroundColor);
        $bgColor = imagecolorallocate($canvas, $r, $g, $b);
        imagefilledrectangle($canvas, 0, 0, $width, $height, $bgColor);

        // Adicionar padrão de bolinhas se template for card ou dotted
        if ($this->template === 'card' || $this->template === 'dotted') {
            \Log::info("Desenhando bolinhas e card");
            $this->drawDotsPatternGd($canvas, $width, $height);
            $this->createCardLayoutGd($canvas, $width, $height);
        } else {
            // Layout simples com texto
            \Log::info("Layout simples");
            $this->addTextToCanvasGd($canvas, $width, $height);
        }

        // Salvar banner
        $fileName = 'banners/banner_' . time() . '.png';
        $fullPath = storage_path('app/public/' . $fileName);
        
        // Garantir que o diretório existe
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        \Log::info("Salvando banner em: {$fullPath}");
        imagepng($canvas, $fullPath, 9);
        imagedestroy($canvas);

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
                        $price = number_format((float)($product->sale_price ?? $product->price), 2) . ' Kz';
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

    /**
     * Adicionar padrão de fundo (bolinhas, círculos, etc)
     */
    private function addBackgroundPattern($canvas, $width, $height)
    {
        // Criar cor mais escura para o padrão (15% mais escuro)
        $rgb = $this->hexToRgbArray($this->backgroundColor);
        $darkerColor = [
            max(0, $rgb[0] - 30),
            max(0, $rgb[1] - 30),
            max(0, $rgb[2] - 30),
            0.3 // Opacidade
        ];

        switch ($this->backgroundPattern) {
            case 'dots':
                $this->drawDotsPattern($canvas, $width, $height, $darkerColor);
                break;
            case 'circles':
                $this->drawCirclesPattern($canvas, $width, $height, $darkerColor);
                break;
        }
    }

    /**
     * Desenhar gradiente moderno de fundo (estilo 2025)
     */
    private function drawModernGradient($canvas, $width, $height, $baseColor)
    {
        list($r, $g, $b) = $this->hexToRgbArray($baseColor);
        
        // Criar gradiente diagonal (top-left mais claro, bottom-right mais escuro)
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                // Calcular intensidade baseado na posição diagonal
                $ratio = (($x + $y) / ($width + $height));
                
                // Variar entre 20% mais claro e 20% mais escuro
                $newR = (int)($r + (($r * 0.2) * (1 - $ratio)) - (($r * 0.2) * $ratio));
                $newG = (int)($g + (($g * 0.2) * (1 - $ratio)) - (($g * 0.2) * $ratio));
                $newB = (int)($b + (($b * 0.2) * (1 - $ratio)) - (($b * 0.2) * $ratio));
                
                // Limitar valores entre 0-255
                $newR = max(0, min(255, $newR));
                $newG = max(0, min(255, $newG));
                $newB = max(0, min(255, $newB));
                
                $pixelColor = imagecolorallocate($canvas, $newR, $newG, $newB);
                imagesetpixel($canvas, $x, $y, $pixelColor);
            }
        }
    }

    /**
     * Desenhar padrão de bolinhas com GD (como na imagem)
     */
    private function drawDotsPatternGd($canvas, $width, $height)
    {
        // Criar cor mais escura para as bolinhas
        list($r, $g, $b) = $this->hexToRgbArray($this->backgroundColor);
        $darkerR = max(0, $r - 30);
        $darkerG = max(0, $g - 30);
        $darkerB = max(0, $b - 30);
        
        $dotColor = imagecolorallocatealpha($canvas, $darkerR, $darkerG, $darkerB, 80);
        
        $dotSize = 30; // Raio das bolinhas
        $spacing = 100; // Espaçamento

        for ($y = 0; $y < $height + $dotSize; $y += $spacing) {
            for ($x = 0; $x < $width + $dotSize; $x += $spacing) {
                imagefilledellipse($canvas, $x, $y, $dotSize * 2, $dotSize * 2, $dotColor);
            }
        }
    }

    /**
     * Desenhar padrão de círculos
     */
    private function drawCirclesPattern($canvas, $width, $height, $color)
    {
        $circleSize = 80;
        $spacing = 120;

        for ($y = 0; $y < $height + $circleSize; $y += $spacing) {
            for ($x = 0; $x < $width + $circleSize; $x += $spacing) {
                $canvas->circle($circleSize, $x, $y, function ($draw) use ($color) {
                    $draw->background('transparent');
                    $draw->border(3, "rgba({$color[0]}, {$color[1]}, {$color[2]}, {$color[3]})");
                });
            }
        }
    }

    /**
     * Criar layout tipo card MODERNO FLAT
     */
    private function createCardLayoutGd($canvas, $width, $height)
    {
        // Dimensões do card
        $cardWidth = $width * 0.82;
        $cardHeight = $height * 0.90;
        $cardX = ($width - $cardWidth) / 2;
        $cardY = ($height - $cardHeight) / 2;

        // Card branco limpo (estilo flat)
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefilledrectangle($canvas, $cardX, $cardY, $cardX + $cardWidth, $cardY + $cardHeight, $white);
        
        // Borda colorida chamativa (mesma cor do fundo para contraste)
        list($r, $g, $b) = $this->hexToRgbArray($this->backgroundColor);
        $borderColor = imagecolorallocate($canvas, $r, $g, $b);
        
        // Borda grossa (5px) para visual moderno
        for ($i = 0; $i < 5; $i++) {
            imagerectangle($canvas, $cardX - $i, $cardY - $i, $cardX + $cardWidth + $i, $cardY + $cardHeight + $i, $borderColor);
        }

        // Adicionar produto(s) se houver
        if (!empty($this->selectedProducts)) {
            $products = Product::whereIn('id', array_slice($this->selectedProducts, 0, 1))->get();
            
            foreach ($products as $index => $product) {
                if ($product && $product->featured_image_url) {
                    try {
                        \Log::info("Carregando produto: {$product->name} - URL: {$product->featured_image_url}");
                        
                        // Tentar carregar imagem
                        $productImg = $this->loadImageFromUrl($product->featured_image_url);
                        
                        if ($productImg) {
                            \Log::info("Imagem carregada com sucesso");
                            
                            // Redimensionar para caber no card (50% da altura do card)
                            $maxProductHeight = $cardHeight * 0.5;
                            $productResized = $this->resizeImage($productImg, null, $maxProductHeight);
                            
                            // Centralizar produto no card
                            $productX = $cardX + ($cardWidth - imagesx($productResized)) / 2;
                            $productY = $cardY + 80;
                            
                            \Log::info("Posicionando produto em X:{$productX}, Y:{$productY}");
                            
                            imagecopy($canvas, $productResized, $productX, $productY, 0, 0, imagesx($productResized), imagesy($productResized));
                            imagedestroy($productImg);
                            imagedestroy($productResized);
                            
                            \Log::info("Produto adicionado ao banner com sucesso!");
                        } else {
                            \Log::warning("Não foi possível carregar a imagem do produto");
                        }
                    } catch (\Exception $e) {
                        \Log::error('Erro ao carregar produto: ' . $e->getMessage());
                        \Log::error('Stack: ' . $e->getTraceAsString());
                    }
                }
            }
        } else {
            \Log::warning("Nenhum produto selecionado");
        }

        // SEÇÃO DE TEXTO limpa e direta
        $textY = $cardY + $cardHeight * 0.68;
        
        if ($this->mainTitle) {
            // Título em preto forte
            $titleColor = imagecolorallocate($canvas, 20, 20, 20);
            $this->addCenteredText($canvas, $this->mainTitle, $width/2, $textY, 24, $titleColor);
        }

        if ($this->subtitle) {
            // Subtítulo em cinza médio
            $subtitleColor = imagecolorallocate($canvas, 90, 90, 90);
            $this->addCenteredText($canvas, $this->subtitle, $width/2, $textY + 50, 14, $subtitleColor);
        }

        // BOTÃO CTA FLAT E CHAMATIVO
        if ($this->logoUrl) {
            $this->drawFlatCTA($canvas, $width, $cardY, $cardHeight);
        }
    }

    /**
     * Adicionar texto centralizado
     */
    private function addCenteredText($canvas, $text, $x, $y, $fontSize, $color)
    {
        // Usar fonte padrão do GD
        $font = 5; // Fonte built-in maior
        $textWidth = imagefontwidth($font) * strlen($text);
        $textX = $x - ($textWidth / 2);
        
        imagestring($canvas, $font, $textX, $y - 7, $text, $color);
    }

    /**
     * Adicionar texto com GD
     */
    private function addTextToCanvasGd($canvas, $width, $height)
    {
        $textColor = imagecolorallocate($canvas, 255, 255, 255);
        
        if ($this->mainTitle) {
            $this->addCenteredText($canvas, $this->mainTitle, $width/2, $height/3, 32, $textColor);
        }

        if ($this->subtitle) {
            $this->addCenteredText($canvas, $this->subtitle, $width/2, $height/3 + 50, 18, $textColor);
        }

        if ($this->ctaText) {
            $this->addCenteredText($canvas, $this->ctaText, $width/2, $height - 50, 16, $textColor);
        }
    }

    /**
     * Carregar imagem de URL
     */
    private function loadImageFromUrl($url)
    {
        try {
            $imageData = @file_get_contents($url);
            if ($imageData === false) {
                return null;
            }
            return imagecreatefromstring($imageData);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Redimensionar imagem mantendo proporção
     */
    private function resizeImage($image, $newWidth = null, $newHeight = null)
    {
        $width = imagesx($image);
        $height = imagesy($image);

        if ($newHeight && !$newWidth) {
            $ratio = $newHeight / $height;
            $newWidth = $width * $ratio;
        } elseif ($newWidth && !$newHeight) {
            $ratio = $newWidth / $width;
            $newHeight = $height * $ratio;
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
        imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
        
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        return $resized;
    }

    /**
     * Criar layout tipo card centralizado (como na imagem) - DEPRECATED
     */
    private function createCardLayout($canvas, $width, $height)
    {
        // Dimensões do card branco central
        $cardWidth = $width * 0.75;
        $cardHeight = $height * 0.85;
        $cardX = ($width - $cardWidth) / 2;
        $cardY = ($height - $cardHeight) / 2;
        $borderRadius = 60;

        // Criar card branco com cantos arredondados
        $card = Image::canvas($cardWidth, $cardHeight, '#f8f9fa');
        
        // Inserir card no canvas
        $canvas->insert($card, 'top-left', $cardX, $cardY);

        // Adicionar produto principal no centro do card
        if (!empty($this->selectedProducts)) {
            $product = Product::find($this->selectedProducts[0]);
            
            if ($product && $product->featured_image_url) {
                try {
                    $productImgHeight = $cardHeight * 0.5;
                    $productImage = Image::make($product->featured_image_url)
                        ->resize(null, $productImgHeight, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                    // Centralizar imagem do produto
                    $productX = $cardX + ($cardWidth - $productImage->width()) / 2;
                    $productY = $cardY + 60;
                    
                    $canvas->insert($productImage, 'top-left', $productX, $productY);

                } catch (\Exception $e) {
                    \Log::error('Erro ao adicionar produto ao card: ' . $e->getMessage());
                }
            }
        }

        // Adicionar texto abaixo da imagem
        if ($this->mainTitle) {
            $textY = $cardY + $cardHeight * 0.7;
            
            $canvas->text($this->mainTitle, $width/2, $textY, function($font) use ($width) {
                $fontPath = public_path('fonts/Roboto-Bold.ttf');
                if (!file_exists($fontPath)) {
                    $fontPath = public_path('fonts/Arial.ttf');
                }
                if (file_exists($fontPath)) {
                    $font->file($fontPath);
                }
                $font->size(min(36, $width/25));
                $font->color('#333333');
                $font->align('center');
                $font->valign('middle');
            });
        }

        if ($this->subtitle) {
            $textY = $cardY + $cardHeight * 0.7 + 50;
            
            $canvas->text($this->subtitle, $width/2, $textY, function($font) use ($width) {
                $fontPath = public_path('fonts/Roboto-Regular.ttf');
                if (!file_exists($fontPath)) {
                    $fontPath = public_path('fonts/Arial.ttf');
                }
                if (file_exists($fontPath)) {
                    $font->file($fontPath);
                }
                $font->size(min(20, $width/45));
                $font->color('#666666');
                $font->align('center');
                $font->valign('middle');
            });
        }

        // Adicionar URL/Logo na parte inferior (como superloja.vip na imagem)
        if ($this->logoUrl) {
            $logoY = $cardY + $cardHeight - 60;
            
            // Criar retângulo laranja para o texto
            $rectWidth = 350;
            $rectHeight = 60;
            $rectX = ($width - $rectWidth) / 2;
            $rectY = $logoY - 25;
            
            $canvas->rectangle($rectX, $rectY, $rectX + $rectWidth, $rectY + $rectHeight, function ($draw) {
                $draw->background('#ff8800');
                $draw->border(0, 'transparent');
            });
            
            $canvas->text($this->logoUrl, $width/2, $logoY, function($font) use ($width) {
                $fontPath = public_path('fonts/Roboto-Bold.ttf');
                if (!file_exists($fontPath)) {
                    $fontPath = public_path('fonts/Arial.ttf');
                }
                if (file_exists($fontPath)) {
                    $font->file($fontPath);
                }
                $font->size(min(28, $width/35));
                $font->color('#ffffff');
                $font->align('center');
                $font->valign('middle');
            });
        }
    }

    /**
     * Converter hex para array RGB
     */
    private function hexToRgbArray($hex)
    {
        $hex = str_replace('#', '', $hex);
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        ];
    }

    /**
     * Desenhar botão CTA FLAT e chamativo
     */
    private function drawFlatCTA($canvas, $width, $cardY, $cardHeight)
    {
        $btnWidth = 400;
        $btnHeight = 65;
        $btnX = ($width - $btnWidth) / 2;
        $btnY = $cardY + $cardHeight - 95;
        
        // BOTÃO com cor vibrante laranja (#FF8800)
        $orange = imagecolorallocate($canvas, 255, 136, 0);
        imagefilledrectangle($canvas, $btnX, $btnY, $btnX + $btnWidth, $btnY + $btnHeight, $orange);
        
        // Borda do botão mais escura para contraste
        $darkerOrange = imagecolorallocate($canvas, 220, 100, 0);
        for ($i = 0; $i < 3; $i++) {
            imagerectangle($canvas, $btnX + $i, $btnY + $i, $btnX + $btnWidth - $i, $btnY + $btnHeight - $i, $darkerOrange);
        }
        
        // TEXTO DO BOTÃO em maiúsculas (branco puro)
        $whiteText = imagecolorallocate($canvas, 255, 255, 255);
        
        $font = 5;
        $text = strtoupper($this->logoUrl);
        $textWidth = imagefontwidth($font) * strlen($text);
        $textX = $btnX + ($btnWidth - $textWidth) / 2;
        $textY = $btnY + ($btnHeight / 2) - 7;
        
        // Texto sem sombra (flat design)
        imagestring($canvas, $font, $textX, $textY, $text, $whiteText);
    }
}
