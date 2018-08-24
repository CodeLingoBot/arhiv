<?php
     	$konekcija = mysqli_connect("localhost","root","root","znaci");

        if (mysqli_connect_errno()) {
                echo "Ne mogu da se povežem saaa bazom. ";
                exit();
        } else {
                //echo "Povezao sam se sa bazom.<br>";
        }

	mysqli_set_charset($konekcija, 'utf8');

        if (!mysqli_set_charset($konekcija, "utf8")) {
                printf("Error loading character set utf8: %s\n", mysqli_error($konekcija));
        } else {
                //printf("Current character set: %s\n", mysqli_character_set_name($konekcija));
        }
