<?php

if (!empty($nova_pripadnost)) {
    if ($nova_pripadnost != $stara_pripadnost) {
        $novi_upit_za_pripadnost = "UPDATE dokumenti SET pripadnost=$nova_pripadnost WHERE id='$dokument_id'; ";
        mysqli_query($konekcija,$novi_upit_za_pripadnost);
    }
}
