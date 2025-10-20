<?php

echo "🎨 Teste de Geração de Banner com GD\n";
echo "====================================\n\n";

// Verificar se GD está instalado
if (!extension_loaded('gd')) {
    die("❌ Extensão GD não está instalada!\n");
}

echo "✅ GD está instalado\n";
echo "Versão: " . gd_info()['GD Version'] . "\n\n";

// Criar banner de teste
$width = 1200;
$height = 630;

echo "📐 Criando banner {$width}x{$height}...\n";

$canvas = imagecreatetruecolor($width, $height);

// Fundo rosa/magenta
$pink = imagecolorallocate($canvas, 169, 30, 92); // #a91e5c
imagefilledrectangle($canvas, 0, 0, $width, $height, $pink);

echo "✅ Fundo rosa aplicado\n";

// Adicionar bolinhas
$darkerPink = imagecolorallocatealpha($canvas, 139, 0, 62, 80);
$dotSize = 30;
$spacing = 100;

$dotCount = 0;
for ($y = 0; $y < $height + $dotSize; $y += $spacing) {
    for ($x = 0; $x < $width + $dotSize; $x += $spacing) {
        imagefilledellipse($canvas, $x, $y, $dotSize * 2, $dotSize * 2, $darkerPink);
        $dotCount++;
    }
}

echo "✅ {$dotCount} bolinhas adicionadas\n";

// Card branco
$cardWidth = $width * 0.75;
$cardHeight = $height * 0.85;
$cardX = ($width - $cardWidth) / 2;
$cardY = ($height - $cardHeight) / 2;

$white = imagecolorallocate($canvas, 248, 249, 250);
imagefilledrectangle($canvas, $cardX, $cardY, $cardX + $cardWidth, $cardY + $cardHeight, $white);

echo "✅ Card branco adicionado\n";

// Texto
$textColor = imagecolorallocate($canvas, 51, 51, 51);
$text = "Um dos nossos produtos para criacao de conteudos online";
$font = 5;
$textWidth = imagefontwidth($font) * strlen($text);
$textX = ($width - $textWidth) / 2;
$textY = $cardY + $cardHeight * 0.7;

imagestring($canvas, $font, $textX, $textY, $text, $textColor);

echo "✅ Texto adicionado\n";

// Retângulo laranja
$rectWidth = 350;
$rectHeight = 60;
$rectX = ($width - $rectWidth) / 2;
$rectY = $cardY + $cardHeight - 80;

$orange = imagecolorallocate($canvas, 255, 136, 0);
imagefilledrectangle($canvas, $rectX, $rectY, $rectX + $rectWidth, $rectY + $rectHeight, $orange);

$whiteText = imagecolorallocate($canvas, 255, 255, 255);
$logoText = "superloja.vip";
$logoWidth = imagefontwidth($font) * strlen($logoText);
$logoX = ($width - $logoWidth) / 2;

imagestring($canvas, $font, $logoX, $rectY + 20, $logoText, $whiteText);

echo "✅ Logo adicionada\n";

// Salvar
$outputDir = __DIR__ . '/storage/app/public/banners';
if (!file_exists($outputDir)) {
    mkdir($outputDir, 0755, true);
}

$outputFile = $outputDir . '/test_banner_' . time() . '.png';
imagepng($canvas, $outputFile, 9);
imagedestroy($canvas);

echo "\n✅ Banner salvo em: {$outputFile}\n";

$fileSize = filesize($outputFile);
echo "📊 Tamanho: " . number_format($fileSize / 1024, 2) . " KB\n";

echo "\n====================================\n";
echo "🎉 Teste concluído com sucesso!\n";
echo "Acesse: /storage/banners/" . basename($outputFile) . "\n";
