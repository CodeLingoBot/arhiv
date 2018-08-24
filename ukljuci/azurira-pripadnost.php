<?php

if (!empty($nova_pripadnost) && $nova_pripadnost != $stara_pripadnost) {
    $upit = "UPDATE dokumenti SET pripadnost=$nova_pripadnost WHERE id='$dokument_id'; ";
    $mysqli->query($upit);
}
