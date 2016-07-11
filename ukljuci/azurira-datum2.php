<?php

if (is_numeric($novi_dan)) {
    if ($novi_dan != $stari_dan) {
        $novi_upit = "UPDATE dokumenti SET dan_izv = $novi_dan WHERE id='$dokument_id'; ";
      mysqli_query($konekcija,$novi_upit);
    }
}

if (is_numeric($novi_mesec)) {
    if ($novi_mesec != $stari_mesec) {
        $novi_upit2 = "UPDATE dokumenti SET mesec_izv=$novi_mesec WHERE id='$dokument_id'; ";
      mysqli_query($konekcija,$novi_upit2);
    }
}

if (is_numeric($nova_godina)) {
    if ($nova_godina != $stara_godina) {
        $novi_upit3 = "UPDATE dokumenti SET god_izv=$nova_godina WHERE id='$dokument_id'; ";
      mysqli_query($konekcija,$novi_upit3);
    }
}
