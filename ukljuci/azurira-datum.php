<?php

if (is_numeric($novi_dan) && $novi_dan != $stari_dan) {
    $upit = "UPDATE dokumenti SET dan_izv = $novi_dan WHERE id='$dokument_id'; ";
    $mysqli->query($upit);
}

if (is_numeric($novi_mesec) && $novi_mesec != $stari_mesec) {
    $upit = "UPDATE dokumenti SET mesec_izv=$novi_mesec WHERE id='$dokument_id'; ";
    $mysqli->query($upit);
}

if (is_numeric($nova_godina) && $nova_godina != $stara_godina) {
    $upit = "UPDATE dokumenti SET god_izv=$nova_godina WHERE id='$dokument_id'; ";
    $mysqli->query($upit);
}
