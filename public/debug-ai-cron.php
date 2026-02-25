<?php
/**
 * DIAGNÓSTICO: Encontrar de onde vêm os comandos ai:*
 * Aceder via: https://superloja.vip/debug-ai-cron.php?key=Popadic17
 * APAGAR ESTE FICHEIRO DEPOIS DE USAR!
 */

// Segurança simples
if (($_GET['key'] ?? '') !== 'Popadic17') {
    http_response_code(403);
    die('Forbidden');
}

header('Content-Type: text/plain; charset=utf-8');
$basePath = dirname(__DIR__);

echo "=== DIAGNÓSTICO AI CRON ===\n";
echo "Data: " . date('Y-m-d H:i:s') . "\n";
echo "Base: $basePath\n\n";

// 1. Verificar console.php
echo "--- 1. routes/console.php ---\n";
$consoleFile = "$basePath/routes/console.php";
if (file_exists($consoleFile)) {
    $content = file_get_contents($consoleFile);
    if (strpos($content, 'ai:') !== false) {
        echo "⚠️ ENCONTRADO 'ai:' em console.php!\n";
        echo $content . "\n";
    } else {
        echo "✅ console.php LIMPO (sem ai:)\n";
        echo "Conteúdo:\n$content\n";
    }
} else {
    echo "❌ console.php NÃO EXISTE!\n";
}

// 2. Verificar caches do Laravel
echo "\n--- 2. Caches Laravel ---\n";
$cacheFiles = [
    "$basePath/bootstrap/cache/config.php" => "Config cache",
    "$basePath/bootstrap/cache/routes-v7.php" => "Routes cache",
    "$basePath/bootstrap/cache/events.php" => "Events cache",
    "$basePath/bootstrap/cache/schedule.php" => "Schedule cache",
    "$basePath/bootstrap/cache/packages.php" => "Packages cache",
    "$basePath/bootstrap/cache/services.php" => "Services cache",
];

foreach ($cacheFiles as $file => $label) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $hasAi = strpos($content, 'ai:') !== false || strpos($content, 'ai\\') !== false;
        $size = round(filesize($file) / 1024, 1);
        $modified = date('Y-m-d H:i:s', filemtime($file));
        echo ($hasAi ? "⚠️" : "📄") . " $label: {$size}KB (modificado: $modified)";
        if ($hasAi) {
            echo " — CONTÉM REFERÊNCIA A 'ai:'!";
        }
        echo "\n";
    } else {
        echo "  $label: não existe\n";
    }
}

// 3. Verificar se há ficheiros Command com ai:
echo "\n--- 3. Comandos Artisan registados ---\n";
$commandsDir = "$basePath/app/Console/Commands";
if (is_dir($commandsDir)) {
    $files = glob("$commandsDir/*.php");
    foreach ($files as $file) {
        $content = file_get_contents($file);
        if (strpos($content, "'ai:") !== false || strpos($content, '"ai:') !== false) {
            echo "⚠️ ENCONTRADO: " . basename($file) . "\n";
            // Extrair a signature
            preg_match("/signature\s*=\s*['\"]([^'\"]+)/", $content, $match);
            if ($match) echo "   Signature: {$match[1]}\n";
        }
    }
    echo "Total ficheiros em Commands: " . count($files) . "\n";
} else {
    echo "Pasta Commands não existe\n";
}

// 4. Procurar em TODOS os ficheiros PHP por 'ai:'
echo "\n--- 4. Busca global por 'ai:' em app/ e routes/ ---\n";
$found = [];
$dirs = ["$basePath/app", "$basePath/routes", "$basePath/config"];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'php') continue;
        $content = file_get_contents($file->getPathname());
        if (preg_match("/['\"]ai:/", $content)) {
            $relativePath = str_replace($basePath . '/', '', $file->getPathname());
            $found[] = $relativePath;
            echo "⚠️ $relativePath\n";
        }
    }
}
if (empty($found)) {
    echo "✅ Nenhuma referência a 'ai:' encontrada\n";
}

// 5. Verificar crontab do sistema (se possível)
echo "\n--- 5. Crontab do sistema ---\n";
$crontab = @shell_exec('crontab -l 2>&1');
if ($crontab) {
    $lines = explode("\n", trim($crontab));
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || $line[0] === '#') continue;
        $hasAi = strpos($line, 'ai:') !== false;
        echo ($hasAi ? "⚠️ " : "  ") . $line . "\n";
    }
    if (empty(array_filter($lines, fn($l) => !empty(trim($l)) && trim($l)[0] !== '#'))) {
        echo "  (vazio)\n";
    }
} else {
    echo "  Não foi possível ler crontab\n";
}

// 6. Verificar storage/framework/schedule
echo "\n--- 6. Schedule cache em storage ---\n";
$scheduleFiles = glob("$basePath/storage/framework/schedule-*");
foreach ($scheduleFiles as $file) {
    echo "  " . basename($file) . " (modified: " . date('Y-m-d H:i:s', filemtime($file)) . ")\n";
}
if (empty($scheduleFiles)) {
    echo "  Nenhum ficheiro de schedule encontrado\n";
}

// 7. LIMPAR TODOS OS CACHES
echo "\n--- 7. LIMPEZA DE CACHES ---\n";
$cachesToDelete = glob("$basePath/bootstrap/cache/*.php");
foreach ($cachesToDelete as $file) {
    $basename = basename($file);
    // Não apagar app.php
    if ($basename === 'app.php') continue;
    if (@unlink($file)) {
        echo "🗑️ Apagado: $basename\n";
    } else {
        echo "❌ Não consegui apagar: $basename\n";
    }
}

// Limpar file cache
$fileCacheDir = "$basePath/storage/framework/cache/data";
if (is_dir($fileCacheDir)) {
    $count = 0;
    $cacheIterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($fileCacheDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($cacheIterator as $item) {
        if ($item->isFile()) {
            @unlink($item->getPathname());
            $count++;
        }
    }
    echo "🗑️ Limpos $count ficheiros de cache\n";
}

echo "\n=== DIAGNÓSTICO COMPLETO ===\n";
echo "Se os erros ai:* continuarem após isto, o problema está no CRONTAB DO CPANEL.\n";
echo "Aceda ao cPanel → Cron Jobs e apague todas as entradas com 'ai:'\n";
echo "\n⚠️ APAGUE ESTE FICHEIRO: rm $basePath/public/debug-ai-cron.php\n";
