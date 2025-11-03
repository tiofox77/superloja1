<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageProcessorService
{
    /**
     * Processar imagem de produto para redes sociais
     * Adiciona logo, moldura, preço e nome do produto
     */
    public function processProductImage(string $imagePath, array $options = []): ?string
    {
        try {
            // Opções padrão
            $productName = $options['product_name'] ?? '';
            $price = $options['price'] ?? '';
            $addLogo = $options['add_logo'] ?? true;
            $addBorder = $options['add_border'] ?? true;
            $addWatermark = $options['add_watermark'] ?? true;

            // Normalizar o caminho
            $cleanPath = str_replace('storage/', '', $imagePath);
            
            // Verificar diferentes caminhos possíveis
            $possiblePaths = [
                storage_path('app/public/' . $cleanPath),
                public_path('storage/' . $cleanPath),
                public_path($imagePath),
            ];

            $fullPath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $fullPath = $path;
                    break;
                }
            }

            if (!$fullPath) {
                \Log::error('Imagem não encontrada em nenhum caminho', [
                    'attempted_paths' => $possiblePaths
                ]);
                return null;
            }

            // Criar ImageManager com driver GD
            $manager = new ImageManager(new Driver());
            
            // 1. CRIAR CANVAS COM FUNDO COLORIDO (1080x1080)
            $canvas = $manager->create(1080, 1080);
            $canvas->fill('8B1E5C'); // Cor vinho/magenta
            
            // 1.1 ADICIONAR PADRÃO DE BOLINHAS no fundo (estilo 2025)
            for ($y = 0; $y < 1080; $y += 60) {
                for ($x = 0; $x < 1080; $x += 60) {
                    $dotSize = 40;
                    $canvas = $this->drawCircle($canvas, $x + 30, $y + 30, $dotSize, '7A1850'); // Bolinhas mais escuras
                }
            }
            
            // 2. CRIAR CARD BRANCO COM BORDAS ARREDONDADAS (880x920)
            $cardWidth = 880;
            $cardHeight = 920;
            $borderRadius = 70; // Bordas bem arredondadas (estilo 2025)
            $card = $this->createRoundedRectangle($manager, $cardWidth, $cardHeight, $borderRadius, 'FFFFFF');
            
            // 3. CRIAR HEADER ARREDONDADO NO TOPO (logo area) - ACIMA do card
            $headerWidth = 300;
            $headerHeight = 90;
            $header = $this->createRoundedRectangle($manager, $headerWidth, $headerHeight, 45, 'FFFFFF');
            
            // Adicionar texto SUPERLOJA no header (centralizado)
            $gdHeader = $header->core()->native();
            $logoColor = imagecolorallocate($gdHeader, 255, 140, 0); // Laranja
            $logoText = "SUPERLOJA";
            
            // Calcular posição para centralizar
            $logoTextWidth = strlen($logoText) * 9;
            $logoX = ($headerWidth - $logoTextWidth) / 2;
            
            // Desenhar em negrito
            $this->drawBoldText($gdHeader, $logoX, 35, $logoText, $logoColor, 5);
            
            // Posicionar header ACIMA do card (no canvas)
            $headerX = (1080 - $headerWidth) / 2;
            $canvas->place($header, 'top-left', $headerX, 45);
            
            // 4. CARREGAR IMAGEM DO PRODUTO
            $productImg = $manager->read($fullPath);
            
            // Redimensionar MANTENDO PROPORÇÃO (MAIOR agora)
            $maxSize = 600; // Aumentado de 480 para 600
            if ($productImg->width() > $productImg->height()) {
                $productImg->scale(width: $maxSize);
            } else {
                $productImg->scale(height: $maxSize);
            }
            
            // Garantir que não ultrapasse limites
            if ($productImg->width() > $maxSize) {
                $productImg->scale(width: $maxSize);
            }
            if ($productImg->height() > $maxSize) {
                $productImg->scale(height: $maxSize);
            }
            
            // 5. POSICIONAR PRODUTO NO CENTRO-SUPERIOR DO CARD
            $card->place($productImg, 'center', 0, -100); // Ajustado para produto maior
            
            // 6. ADICIONAR TEXTOS DENTRO DO CARD
            $gdCard = $card->core()->native();
            
            // 6.1 ADICIONAR DESTAQUE DO PRODUTO (canto superior esquerdo) - ex: "30W"
            $highlight = $this->extractProductHighlight($productName);
            if ($highlight) {
                $highlightColor = imagecolorallocate($gdCard, 0, 0, 0); // Preto
                // Fonte GRANDE e em NEGRITO (simulado)
                $this->drawBoldText($gdCard, 100, 180, $highlight, $highlightColor, 5);
            }
            
            // 6.2 ADICIONAR DESCRIÇÃO DO PRODUTO (abaixo do produto)
            if ($productName) {
                // Limitar nome
                $shortName = mb_strlen($productName) > 55 
                    ? mb_substr($productName, 0, 52) . '...' 
                    : $productName;
                
                // Quebrar em linhas se necessário
                $words = explode(' ', $shortName);
                $lines = [];
                $currentLine = '';
                
                foreach ($words as $word) {
                    if (mb_strlen($currentLine . ' ' . $word) <= 40) {
                        $currentLine .= ($currentLine ? ' ' : '') . $word;
                    } else {
                        if ($currentLine) $lines[] = $currentLine;
                        $currentLine = $word;
                    }
                }
                if ($currentLine) $lines[] = $currentLine;
                
                // Limitar a 3 linhas
                $lines = array_slice($lines, 0, 3);
                
                $descColor = imagecolorallocate($gdCard, 139, 30, 92); // Vinho
                $textY = 680;
                
                // Desenhar cada linha centralizada (fonte 4 - MAIOR)
                foreach ($lines as $index => $line) {
                    $textX = ($cardWidth / 2) - (mb_strlen($line) * 4.5);
                    // Desenhar em negrito
                    imagestring($gdCard, 4, $textX, $textY + ($index * 22), $line, $descColor);
                    imagestring($gdCard, 4, $textX + 1, $textY + ($index * 22), $line, $descColor);
                }
                
                // 6.3 ADICIONAR PREÇO (sem negrito, fonte maior)
                $priceText = number_format($price, 2, ',', '.') . ' Kz';
                $priceColor = imagecolorallocate($gdCard, 0, 0, 0); // Preto
                
                // Desenhar preço SEM negrito e com fonte GRANDE
                $priceY = $textY + (count($lines) * 22) + 30;
                
                // Usar a maior fonte disponível (5) e desenhar uma vez só
                // Calcular centralização para fonte 5 (cada caractere ~9px)
                $priceX = ($cardWidth / 2) - (strlen($priceText) * 9 / 2);
                imagestring($gdCard, 5, $priceX, $priceY, $priceText, $priceColor);
            }
            
            // 7. INSERIR CARD NO CANVAS
            $cardX = (1080 - $cardWidth) / 2;
            $canvas->place($card, 'top-left', $cardX, 100);
            
            // 8. ADICIONAR FAIXA LARANJA COM BORDAS ARREDONDADAS (melhor UI/UX)
            $footerWidth = 680;
            $footerHeight = 75;
            $footerRadius = 15; // Bordas arredondadas
            
            // Criar faixa com bordas arredondadas
            $footer = $this->createRoundedRectangle($manager, $footerWidth, $footerHeight, $footerRadius, 'FF8C00');
            
            // Adicionar texto "superloja.vip" CENTRALIZADO na faixa laranja
            $gdFooter = $footer->core()->native();
            $footerTextColor = imagecolorallocate($gdFooter, 139, 30, 92); // Vinho escuro
            $footerText = "superloja.vip";
            
            // Calcular posição X para centralizar texto (fonte 5 tem ~9px por caractere)
            $textWidth = strlen($footerText) * 9;
            $footerTextX = ($footerWidth - $textWidth) / 2;
            $footerTextY = 28;
            
            // Desenhar texto em negrito e mais grosso
            for ($i = 0; $i < 2; $i++) {
                for ($j = 0; $j < 2; $j++) {
                    imagestring($gdFooter, 5, $footerTextX + $i, $footerTextY + $j, $footerText, $footerTextColor);
                }
            }
            
            // Posicionar faixa centralizada no rodapé
            $footerX = (1080 - $footerWidth) / 2;
            $canvas->place($footer, 'bottom-left', $footerX, 25);
            
            $img = $canvas;

            // Salvar imagem processada
            $filename = 'processed_' . basename($imagePath);
            $processedPath = 'social_media/' . date('Y/m/d') . '/' . $filename;
            
            // Criar diretório se não existir
            $directory = storage_path('app/public/' . dirname($processedPath));
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Salvar com qualidade alta
            $img->save(storage_path('app/public/' . $processedPath), 90);

            return $processedPath;

        } catch (\Exception $e) {
            \Log::error('Erro ao processar imagem', [
                'error' => $e->getMessage(),
                'path' => $imagePath
            ]);
            return null;
        }
    }

    /**
     * Criar retângulo com bordas arredondadas
     */
    private function createRoundedRectangle($manager, int $width, int $height, int $radius, string $color)
    {
        // Criar imagem base
        $img = $manager->create($width, $height);
        $img->fill('00000000'); // Transparente
        
        // Obter recurso GD
        $gd = $img->core()->native();
        
        // Converter cor hex para RGB
        $rgb = $this->hexToRgb($color);
        $gdColor = imagecolorallocate($gd, $rgb[0], $rgb[1], $rgb[2]);
        
        // Desenhar retângulo com cantos arredondados
        imagefilledrectangle($gd, $radius, 0, $width - $radius, $height, $gdColor);
        imagefilledrectangle($gd, 0, $radius, $width, $height - $radius, $gdColor);
        
        // Desenhar cantos arredondados
        imagefilledellipse($gd, $radius, $radius, $radius * 2, $radius * 2, $gdColor);
        imagefilledellipse($gd, $width - $radius, $radius, $radius * 2, $radius * 2, $gdColor);
        imagefilledellipse($gd, $radius, $height - $radius, $radius * 2, $radius * 2, $gdColor);
        imagefilledellipse($gd, $width - $radius, $height - $radius, $radius * 2, $radius * 2, $gdColor);
        
        return $img;
    }
    
    /**
     * Desenhar círculo
     */
    private function drawCircle($img, int $x, int $y, int $size, string $color)
    {
        $gd = $img->core()->native();
        $rgb = $this->hexToRgb($color);
        $gdColor = imagecolorallocatealpha($gd, $rgb[0], $rgb[1], $rgb[2], 80); // Semi-transparente
        imagefilledellipse($gd, $x, $y, $size, $size, $gdColor);
        return $img;
    }
    
    /**
     * Converter Hex para RGB
     */
    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        ];
    }
    
    /**
     * Extrair destaque do produto (ex: 30W, 5000mAh, etc)
     */
    private function extractProductHighlight(string $productName): ?string
    {
        // Procurar por padrões comuns: números seguidos de W, mAh, GB, etc
        if (preg_match('/(\d+\s*(?:W|mAh|GB|TB|MP|Hz|A|V))/i', $productName, $matches)) {
            return strtoupper($matches[1]);
        }
        
        // Procurar números com unidades separadas
        if (preg_match('/(\d+)\s*(watt|watts|ampere)/i', $productName, $matches)) {
            return $matches[1] . 'W';
        }
        
        return null;
    }
    
    /**
     * Desenhar texto em negrito (simulado com desenho múltiplo)
     */
    private function drawBoldText($gd, int $x, int $y, string $text, $color, int $font): void
    {
        // Desenhar o texto múltiplas vezes com pequenos deslocamentos para simular negrito
        imagestring($gd, $font, $x, $y, $text, $color);
        imagestring($gd, $font, $x + 1, $y, $text, $color);
        imagestring($gd, $font, $x, $y + 1, $text, $color);
        imagestring($gd, $font, $x + 1, $y + 1, $text, $color);
    }

    /**
     * Processar múltiplas imagens (para carrosséis)
     */
    public function processMultipleImages(array $imagePaths, array $options = []): array
    {
        $processedImages = [];

        foreach ($imagePaths as $imagePath) {
            $processed = $this->processProductImage($imagePath, $options);
            if ($processed) {
                $processedImages[] = $processed;
            }
        }

        return $processedImages;
    }
}
