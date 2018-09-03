<?php
$id = filter_input(INPUT_GET, 'br', FILTER_SANITIZE_NUMBER_INT);
Header("Location: odrednica.php?br=".$id);
