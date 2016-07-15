<?php
if (!is_dir($kesh_folder)) mkdir($kesh_folder);

if (!$ignore) {
  $fp = fopen($keshiran_fajl, 'w');  // open file for writing
  fwrite($fp, ob_get_contents()); // write contents of the output buffer
  fclose($fp); // close file pointer
}

ob_end_flush(); // turn off output buffering
