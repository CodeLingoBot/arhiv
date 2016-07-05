<?php

require "../biblioteke/smart-resize.php";

$ulazniFolder = "../../images";
$izlazniFolder = "slike";

foreach (glob($ulazniFolder."/*.*") as $putanja) {
    $ext = pathinfo($putanja, PATHINFO_EXTENSION);
    $ext = ".".$ext;  // dodaje tacku ekstenziji
    $novaPutanja = str_replace($ulazniFolder, $izlazniFolder, $putanja);
    $novaPutanja = str_replace($ext, "-200px".$ext, $novaPutanja); // pravi novo ime

    echo $putanja . "\r\n";
    echo $novaPutanja . "\r\n";
    echo "\r\n";
    smart_resize_image($putanja, null, 0, 200, true, $novaPutanja, false, false, 100);
}
