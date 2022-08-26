<?php

$path = __DIR__ . '/test';
print_r('Scan dir: ' . $path . PHP_EOL);

$directory = new RecursiveDirectoryIterator(__DIR__ . '/test');
$iterator = new RecursiveIteratorIterator($directory);

// Calc summ in file lines
function getSummFromFile(SplFileObject $file) {
    $fileSumm = 0;

    while (!$file->eof()) {
        $line  =  $file->fgets();
        
        if (empty(trim($line))) {
            continue;
        }

        $fileSumm += (float) str_replace(',', '.', $line);
    }

    return $fileSumm;
}

$totalSumm = 0;
foreach(iterator_to_array($iterator) as $fileInfo) {
    if (!$fileInfo->isFile()) {
        continue;
    }

    if (!$fileInfo->isReadable()) {
        continue;
    }

    if ($fileInfo->getFilename() === 'count') {
        $file = $fileInfo->openFile();
        $totalSumm += getSummFromFile($file);
    }
}

echo 'Summ "count" file values: ' . $totalSumm . PHP_EOL;