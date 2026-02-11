<?php
// Script para baixar fonte Poppins do Google Fonts

$fontUrl = 'https://github.com/google/fonts/raw/main/ofl/poppins/Poppins-Bold.ttf';
$fontPath = __DIR__ . '/Poppins-Bold.ttf';

echo "Baixando fonte Poppins-Bold...\n";

$fontData = file_get_contents($fontUrl);
if ($fontData === false) {
    echo "Erro ao baixar fonte!\n";
    exit(1);
}

file_put_contents($fontPath, $fontData);
echo "Fonte salva em: $fontPath\n";

// Baixar também a versão Regular
$fontRegularUrl = 'https://github.com/google/fonts/raw/main/ofl/poppins/Poppins-Regular.ttf';
$fontRegularPath = __DIR__ . '/Poppins-Regular.ttf';

echo "Baixando fonte Poppins-Regular...\n";

$fontRegularData = file_get_contents($fontRegularUrl);
if ($fontRegularData === false) {
    echo "Erro ao baixar fonte Regular!\n";
    exit(1);
}

file_put_contents($fontRegularPath, $fontRegularData);
echo "Fonte Regular salva em: $fontRegularPath\n";

echo "Fontes baixadas com sucesso!\n";
