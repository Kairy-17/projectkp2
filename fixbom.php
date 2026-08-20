<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$iterator = new RecursiveIteratorIterator($dir);
foreach ($iterator as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $c = file_get_contents($file);
        
        $changed = false;
        // Strip BOM
        if (substr($c, 0, 3) === "\xEF\xBB\xBF") {
            $c = substr($c, 3);
            $changed = true;
        }
        // Handle UTF-16LE
        if (substr($c, 0, 2) === "\xFF\xFE") {
            $c = substr($c, 2);
            $c = mb_convert_encoding($c, 'UTF-8', 'UTF-16LE');
            $changed = true;
        }

        if ($changed || !mb_check_encoding($c, 'UTF-8')) {
            // try to convert from whatever to UTF8
            if (!mb_check_encoding($c, 'UTF-8')) {
               $c = mb_convert_encoding($c, 'UTF-8', 'auto');
            }
        }
        
        // Let's just always write it out cleanly
        file_put_contents($file, $c);
    }
}
echo "Done.";
