<?php

// pokreće se iz konzole, napraviti interfejs
// smanjuje sve slike iz foldera images na visinu 200px i izvozi ih u slike/smanjene

ini_set('memory_limit', '-1');
require "../biblioteke/smart-resize.php";

$ulazniFolder = "../../images";
$izlazniFolder = "../slike/smanjene";
$fajlovi = glob($ulazniFolder."/*.*");
$duzina_niza = count($fajlovi);

for ($i = 0; $i <= $duzina_niza; $i++) {
    $filePath = $fajlovi[$i];
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    $ext = ".".$ext;  // dodaje tacku ekstenziji
    $newPath = str_replace($ulazniFolder, $izlazniFolder, $filePath);
    $newPath = str_replace($ext, "-200px".$ext, $newPath); // pravi novo ime

    echo $filePath . "\r\n";
    echo $newPath . "\r\n";
    echo "\r\n";
    smart_resize_image($filePath, null, 0, 200, true, $newPath, false, false, 100);
}
