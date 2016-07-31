// masovno menja dane, mesece, godine i oblasti

function promeniDane(ove) {
	polja_za_dan = document.getElementsByClassName('stari_dan');
	novi_dan = document.getElementById('dani_masovno').value;
	for(var i=0; i < polja_za_dan.length-1; i++) {
		if(novi_dan) {
			polja_za_dan[i].value = novi_dan;								// menja sve
		}
	}
}

function dodajDane(ove) {
	polja_za_dan = document.getElementsByClassName('stari_dan');
	novi_dan = document.getElementById('dani_masovno').value;
	for(var i=0; i < polja_za_dan.length-1; i++) {
		if(novi_dan) {
			if(polja_za_dan[i].value == "0" || polja_za_dan[i].value == "") {	// dodaje samo umesto nule i praznog
				polja_za_dan[i].value = novi_dan;
			}
		}
	}
}

function promeniMesece(ove) {
	polja_za_mesec = document.getElementsByClassName('stari_mesec');
	novi_mesec = document.getElementById("mesec_masovno").value;
	for(var i=0; i < polja_za_mesec.length-1; i++) {				// poslednje je crveno polje!
		if(novi_mesec) {
			polja_za_mesec[i].value = novi_mesec;
		}
	}
}

function dodajMesece(ove) {
	polja_za_mesec = document.getElementsByClassName('stari_mesec');
	novi_mesec = document.getElementById("mesec_masovno").value;
	for(var i=0; i < polja_za_mesec.length-1; i++) {
		if(novi_mesec) {
			if(polja_za_mesec[i].value == "0" || polja_za_mesec[i].value == "") {
				polja_za_mesec[i].value = novi_mesec;
			}
		}
	}
}


function promeniGodine(ove) {
	polja_za_godinu = document.getElementsByClassName('stara_godina');
	nova_godina = document.getElementById("godina_masovno").value;
	for(var i=0; i < polja_za_godinu.length-1; i++) {
		if(nova_godina) {
			polja_za_godinu[i].value = nova_godina;
		}
	}
}

function dodajGodine(ove) {
	polja_za_godinu = document.getElementsByClassName('stara_godina');
	nova_godina = document.getElementById("godina_masovno").value;
	for(var i=0; i < polja_za_godinu.length-1; i++) {
		if(nova_godina) {
			if(polja_za_godinu[i].value == '0' || polja_za_godinu[i].value == '') {
				polja_za_godinu[i].value = nova_godina;
			}
		}
	}
}

function dodajOblast(ovo) {
	polja_za_oblast = document.getElementsByClassName('oblast');
	nova_oblast = document.getElementById('oblast_masovno').value;
	for(var i=0; i < polja_za_oblast.length-1; i++) {
		if(nova_oblast) {
			if(polja_za_oblast[i].value == '0' || polja_za_oblast[i].value == '') {
				polja_za_oblast[i].value = nova_oblast;
			}
		}
	}
}

function promeniOblasti(){
	var sve_oblasti = document.getElementsByClassName("bira_oblast");
	for (var i=0; i<sve_oblasti.length; i++) {
		sve_oblasti[i].value = document.getElementById('oblast_masovno').value;
	}
}

function promeniPripadnosti(){
	var sve_pripadnosti = document.getElementsByClassName("bira_pripadnost");
	for (var i=0; i<sve_pripadnosti.length; i++) {
		sve_pripadnosti[i].value = document.getElementById('pripadnost_masovno').value;
	}
}
