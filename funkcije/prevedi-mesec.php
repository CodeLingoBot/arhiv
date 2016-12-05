<?php

function prevediMesec($mesec){
	switch ($mesec) {
		case "01":
			return "januara";
		case "02":
			return "februara";
		case "03":
			return "marta";
		case "04":
			return "aprila";
		case "05":
			return "maja";
		case "06":
			return "juna";
		case "07":
			return "jula";
		case "08":
			return "avgusta";
		case "09":
			return "septembra"
		case "10":
			return "oktobra";
		case "11":
			return "novembra";
		case "12":
			return "decembra";
	}
}
