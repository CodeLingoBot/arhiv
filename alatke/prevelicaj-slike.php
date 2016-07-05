<?php

require "../biblioteke/smart-resize.php";

$ulazniFolder = "../../images";
$izlazniFolder = "slike";

foreach (glob($ulazniFolder."/*.*") as $filePath) {
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    $ext = ".".$ext;  // dodaje tacku ekstenziji
    $newPath = str_replace($ulazniFolder, $izlazniFolder, $filePath);
    $newPath = str_replace($ext, "-200".$ext, $newPath); // pravi novo ime

    echo $filePath . "\r\n";
    echo $newPath . "\r\n";
    echo "\r\n";
    smart_resize_image($filePath, null, 0, 200, true, $newPath, false, false, 100);
}
