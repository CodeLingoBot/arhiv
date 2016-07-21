<?php

function jelPolozena(slika) {
  list($width, $height) = getimagesize('image.jpg');
  return $width > $height;
}
