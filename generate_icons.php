<?php
$sourcePath = 'public/icons/logo-new.png';
$destPath = 'public/icons/icon-512x512.png';
$destPathSmall = 'public/icons/icon-192x192.png';

$source = imagecreatefrompng($sourcePath);
$srcWidth = imagesx($source);
$srcHeight = imagesy($source);

// Create 512x512
$dest512 = imagecreatetruecolor(512, 512);
imagealphablending($dest512, false);
imagesavealpha($dest512, true);
$transparent = imagecolorallocatealpha($dest512, 255, 255, 255, 127);
imagefill($dest512, 0, 0, $transparent);

// Calculate centered and scaled dimensions
$scale = min(512 / $srcWidth, 512 / $srcHeight);
$newWidth = $srcWidth * $scale;
$newHeight = $srcHeight * $scale;
$dstX = (512 - $newWidth) / 2;
$dstY = (512 - $newHeight) / 2;

imagecopyresampled($dest512, $source, $dstX, $dstY, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);
imagepng($dest512, $destPath);
imagedestroy($dest512);

// Create 192x192
$dest192 = imagecreatetruecolor(192, 192);
imagealphablending($dest192, false);
imagesavealpha($dest192, true);
$transparent192 = imagecolorallocatealpha($dest192, 255, 255, 255, 127);
imagefill($dest192, 0, 0, $transparent192);

$scale192 = min(192 / $srcWidth, 192 / $srcHeight);
$newWidth192 = $srcWidth * $scale192;
$newHeight192 = $srcHeight * $scale192;
$dstX192 = (192 - $newWidth192) / 2;
$dstY192 = (192 - $newHeight192) / 2;

imagecopyresampled($dest192, $source, $dstX192, $dstY192, 0, 0, $newWidth192, $newHeight192, $srcWidth, $srcHeight);
imagepng($dest192, $destPathSmall);
imagedestroy($dest192);
imagedestroy($source);

echo "Icons generated.";
