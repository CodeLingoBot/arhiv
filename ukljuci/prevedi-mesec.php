<?php

function prevediMesec($mesec){
	switch ($mesec) {
		case "01":
			$prevedeni_mesec = "januara";
			break;
		case "02":
			$prevedeni_mesec = "februara";
			break;
		case "03":
			$prevedeni_mesec = "marta";
			break;
		case "04":
			$prevedeni_mesec = "aprila";
			break;
		case "05":
			$prevedeni_mesec = "maja";
			break;
		case "06":
			$prevedeni_mesec = "juna";
			break;
		case "07":
			$prevedeni_mesec = "jula";
			break;
		case "08":
			$prevedeni_mesec = "avgusta";
			break;
		case "09":
			$prevedeni_mesec = "septembra";
			break;
		case "10":
			$prevedeni_mesec = "oktobra";
			break;
		case "11":
			$prevedeni_mesec = "novembra";
			break;
		case "12":
			$prevedeni_mesec = "decembra";
			break;
	}
	return $prevedeni_mesec;
}
