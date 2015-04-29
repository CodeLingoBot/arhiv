var polje_za_sugestije = document.getElementById("polje_za_sugestije");
var tag = document.getElementById("tag");
var br_oznake = document.getElementById("br_oznake");

// pravi hvatač elemenata ala jquery
window.$ = function(selector) {
	return document.querySelectorAll(selector);
};


function pokaziSugestije(unos) {
	var pozadinska_veza = new XMLHttpRequest();
	if (unos.length > 1) {
		polje_za_sugestije.style.display = "block";
		
		pozadinska_veza.onreadystatechange = function() {
			if (pozadinska_veza.readyState == 4 && pozadinska_veza.status == 200) {
				polje_za_sugestije.innerHTML = pozadinska_veza.responseText;
			}
		}
		pozadinska_veza.open("GET", "alatke/sugestije-sve.php?pocetno="+unos, true);
		pozadinska_veza.send();
	}
}


function izaberiOznaku(izabrano) {
	tag.value = izabrano.innerHTML;
	br_oznake.value = izabrano.nextSibling.innerHTML;
	polje_za_sugestije.style.display = "none";
}


function pozadinskiBrisi(ovo, vrsta_materijala, broj_entia, id){
	var pozadinska_veza = new XMLHttpRequest();

    pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			ovo.nextSibling.innerHTML = pozadinska_veza.responseText;
			// sakriva element dva koraka iza (računa i razmak); možda nije opšte primenljivo
			//ovo.previousSibling.previousSibling.style.display="none";
        }
    }
	pozadinska_veza.open("GET","alatke/asinhron-bris.php?vrsta_materijala="+vrsta_materijala+"&broj_entia="+broj_entia+"&id="+id,true);
	pozadinska_veza.send();	
}


function pozadinskiTaguj(ovo, vrsta_materijala, broj_entia, id){
	if(ovo){
		var pozadinska_veza = new XMLHttpRequest();

		pozadinska_veza.onreadystatechange = function() {
			if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
				ovo.nextSibling.innerHTML = pozadinska_veza.responseText;
			}
		}
		pozadinska_veza.open("GET","alatke/asinhron-tag.php?vrsta_materijala="+vrsta_materijala+"&broj_entia="+broj_entia+"&id="+id,true);
		pozadinska_veza.send();
	}
}


function izmeniDatum(ovo,id,vrsta){
	
	var pozadinska_veza = new XMLHttpRequest();
	
    pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			ovo.nextSibling.innerHTML = pozadinska_veza.responseText;
        }
    }
	
	// za fotografije šalje skupni datum, za ostalo odvojeno
	if(vrsta ==3) {
		var datum = document.getElementById("datum").value;
		pozadinska_veza.open("GET","alatke/menja-datum.php?id="+id+"&vrsta="+vrsta+"&datum="+datum,true);
	} else {
		var dan = document.getElementById("dan").value;
		var mesec = document.getElementById("mesec").value;
		var godina = document.getElementById("godina").value;
		pozadinska_veza.open("GET","alatke/menja-datum.php?id="+id+"&vrsta="+vrsta+"&dan="+dan+"&mesec="+mesec+"&godina="+godina,true);		
	}
	pozadinska_veza.send();	
}


function promeniOblast(ovo, id, vrsta_materijala){
	
	var oblast = document.getElementById("nova_oblast").value;
	var pozadinska_veza = new XMLHttpRequest();

    pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			ovo.nextSibling.innerHTML = pozadinska_veza.responseText;
        }
    }
	pozadinska_veza.open("GET","alatke/menja-oblast.php?vrsta_materijala="+vrsta_materijala+"&oblast="+oblast+"&id="+id,true);
	pozadinska_veza.send();	
}


function promeniVrstu(ovo, id){
	var vrsta_entia = ovo.previousElementSibling.value;
	var pozadinska_veza = new XMLHttpRequest();
	
    pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			ovo.nextElementSibling.innerHTML = pozadinska_veza.responseText;
        }
    }
	pozadinska_veza.open("GET","alatke/menja-vrstu.php?vrsta_entia="+vrsta_entia+"&id="+id,true);
	pozadinska_veza.send();		
}


function promeniNaziv(ovo, broj_oznake){
	var naslov = document.getElementById("naslov");
	var novi_naziv = naslov.textContent || naslov.innerText;
	
	var pozadinska_veza = new XMLHttpRequest();	
	pozadinska_veza.onreadystatechange = function() {
        if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
			ovo.nextElementSibling.innerHTML = pozadinska_veza.responseText;
        }
    }
	pozadinska_veza.open("POST","alatke/menja-naziv.php",true);
	pozadinska_veza.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	pozadinska_veza.send("novi_naziv=" + novi_naziv + "&broj_oznake=" + broj_oznake);
}
