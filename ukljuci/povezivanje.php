<?php

$mysqli = new mysqli("localhost", "root", "root", "znaci");

if ($mysqli->connect_errno) {
        echo "Ne mogu da se povežem sa bazom. ";
        exit();
}

$mysqli->set_charset("utf8");
