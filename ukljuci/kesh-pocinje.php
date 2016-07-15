<?php

if ($ulogovan) {
  die();
}

$kesh_ekstenzija = '.html';
$kesh_trajanje = $kesh_trajanje ?: 3600;  // 1 sat = 3600 sek
$kesh_folder = '.kesh/';
$original_url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
$keshiran_fajl = $kesh_folder.md5($original_url).$kesh_ekstenzija;
$ignorisane_strane   = array('prijava.php', '');
$ignorise = (in_array($original_url, $ignorisane_strane)) ? true : false;

ob_start('ob_gzhandler'); // počinje output buffering with gzip compression
if (!$ignorise && !$ulogovan && file_exists($keshiran_fajl) && time() - $kesh_trajanje < filemtime($keshiran_fajl)) {
    readfile($keshiran_fajl); // čita keširan fajl
    echo '<!-- keširano '.date('d-m-Y \u H:i:s', filemtime($keshiran_fajl)).', stranica: '.$original_url.' -->';
    ob_end_flush(); // završava output buffering
    exit();
}
