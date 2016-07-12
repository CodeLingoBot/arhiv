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
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </html>
<?php
    // Save the cached content to a file
    $fp = fopen($keshiran_fajl, 'w');
    fwrite($fp, ob_get_contents());
    fclose($fp);
    // send browser output
    ob_end_flush();
?>
