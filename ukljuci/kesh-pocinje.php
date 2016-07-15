<?php

$kesh_ekstenzija = '.html';
$kesh_trajanje = $kesh_trajanje ?: 3600;  // 1 sat = 3600 sek
$kesh_folder = '.kesh/';
$original_url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
$keshiran_fajl = $kesh_folder.md5($original_url).$kesh_ekstenzija;
$ignore_pages   = array('prijava.php', 'admin.php');
$ignore = (in_array($_SERVER['REQUEST_URI'], $ignore_pages)) ? true : false;

if ($ignore) {
  echo "ignoriše";
} else {
  echo "ne ignoriše";
}

ob_start('ob_gzhandler'); // počinje output buffering with gzip compression

if (!$ulogovan && file_exists($keshiran_fajl) && time() - $kesh_trajanje < filemtime($keshiran_fajl)) {
    readfile($keshiran_fajl); // čita keširan fajl
    echo '<!-- keširano '.date('d-m-Y \u H:i:s', filemtime($keshiran_fajl)).', stranica: '.$original_url.' -->';
    ob_end_flush(); // završava output buffering
    exit();
}
