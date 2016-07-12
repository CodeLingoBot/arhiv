<?php
    // define the path and name of cached file
    $keshiran_fajl = '.kesh/'.date('M-d-Y').'.php';
    $trajanje_kesha = 18000;  // 5 hours
    // Check if the cached file is still fresh. If it is, serve it up and exit.
    if (file_exists($keshiran_fajl) && time() - $trajanje_kesha < filemtime($keshiran_fajl)) {
        include($keshiran_fajl);
        exit;
    }
    // if there is either no file OR the file to too old, render the page and capture the HTML.
    ob_start();
?>
    <html>
        output all your html here.
    </html>
<?php
    // Save the cached content to a file
    $fp = fopen($keshiran_fajl, 'w');
    fwrite($fp, ob_get_contents());
    fclose($fp);
    // send browser output
    ob_end_flush();
?>
