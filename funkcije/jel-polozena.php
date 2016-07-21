<?php

function jelPolozena($slika) {
  list($width, $height) = getimagesize($slika);
  return ($width > $height);
}
