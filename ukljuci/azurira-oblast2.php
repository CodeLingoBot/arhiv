<?php

if (!empty($nova_oblast)) {
    if ($nova_oblast != $oblast) {
        $novi_upit = "UPDATE dokumenti SET oblast=$nova_oblast WHERE id='$dokument_id'; ";
        mysqli_query($konekcija,$novi_upit);
    }
}
