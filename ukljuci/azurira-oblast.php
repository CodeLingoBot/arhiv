<?php

if (!empty($nova_oblast)) {
    if ($nova_oblast != $oblast) {
        $upit = "UPDATE dokumenti SET oblast=$nova_oblast WHERE id='$dokument_id'; ";
        $mysqli->query($upit);
    }
}
