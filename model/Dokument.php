<?php

require_once __DIR__ . "/../ukljuci/povezivanje2.php";
require_once "Izvor.php";

class Dokument extends Izvor {

  function __construct($id) {
      global $mysqli;
      parent::__construct($id, 2);
  } // construct
}