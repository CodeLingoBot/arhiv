<?php
$kesh_ekstenzija = '.html';
$kesh_trajanje = $kesh_trajanje ?: 3600;  // 1 sat = 3600 sek
$kesh_folder = '.kesh/';
$original_url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
$keshiran_fajl = $kesh_folder.md5($original_url).$kesh_ekstenzija;
ob_start('ob_gzhandler'); // start output buffering with gzip compression
if (file_exists($keshiran_fajl) && time() - $kesh_trajanje < filemtime($keshiran_fajl)) { // ako kesh nije istekao
    readfile($keshiran_fajl); // read Cache file
    echo '<!-- keširano '.date('d-m-Y \u H:i:s', filemtime($keshiran_fajl)).', stranica: '.$original_url.' -->';
    ob_end_flush(); // turn off output buffering
    exit();
}
