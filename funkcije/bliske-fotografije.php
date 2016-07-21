<?php

function bliske($datum, $konekcija) {
    $niz = array();
    $brojac = 0;
    $razlika = 0;
    $dtm_unix = strtotime($datum) / 86400;
    while ($brojac < 20) {
        $upit = "SELECT * FROM fotografije WHERE ABS(dat_unix - $dtm_unix) = $razlika";
        $rezultat = mysqli_query($konekcija, $upit);
        while($red = mysqli_fetch_assoc($rezultat)) {
            $niz[$brojac] = $red['id'];
            $brojac++;
            if( $brojac == 20) { break; }
        }
        $razlika++;
    }
    return $niz;
}
