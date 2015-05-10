
var polje_za_sugestije = document.getElementById("polje_za_sugestije");
var tag = document.getElementById("tag");
var br_oznake = document.getElementById("br_oznake");


function pokaziSugestije(unos) {
	if (unos.length > 1) {
		polje_za_sugestije.style.display = "block";
        var pozadinski_zahtev = napraviZahtev(polje_za_sugestije);
		pozadinski_zahtev.open("GET", "alatke/sugestije-sve.php?pocetno="+unos, true);
		pozadinski_zahtev.send();
	}
}


function izaberiOznaku(izabrano) {
	tag.value = izabrano.innerHTML;
	br_oznake.value = izabrano.nextElementSibling.innerHTML;
	polje_za_sugestije.style.display = "none";
}


function pozadinskiBrisi(ovo, vrsta_materijala, broj_entia, id){
    var pozadinski_zahtev = napraviZahtev(ovo.nextElementSibling);
	pozadinski_zahtev.open("GET","alatke/asinhron-bris.php?vrsta_materijala="+vrsta_materijala+"&broj_entia="+broj_entia+"&id="+id,true);
	pozadinski_zahtev.send();	
}


function pozadinskiTaguj(ovo, vrsta_materijala, broj_entia, id){
    var pozadinski_zahtev = napraviZahtev(ovo.nextElementSibling);
	pozadinski_zahtev.open("GET","alatke/asinhron-tag.php?vrsta_materijala="+vrsta_materijala+"&broj_entia="+broj_entia+"&id="+id,true);
	pozadinski_zahtev.send();
}


function izmeniDatum(ovo, id, vrsta){
    var pozadinski_zahtev = napraviZahtev(ovo.nextElementSibling);
	// za fotografije šalje skupni datum, za ostalo odvojeno
	if(vrsta ==3) {
		var datum = document.getElementById("datum").value;
		pozadinski_zahtev.open("GET","alatke/menja-datum.php?id="+id+"&vrsta="+vrsta+"&datum="+datum,true);
	} else {
		var dan = document.getElementById("dan").value;
		var mesec = document.getElementById("mesec").value;
		var godina = document.getElementById("godina").value;
		pozadinski_zahtev.open("GET","alatke/menja-datum.php?id="+id+"&vrsta="+vrsta+"&dan="+dan+"&mesec="+mesec+"&godina="+godina,true);		
	}
	pozadinski_zahtev.send();	
}


function promeniOblast(ovo, id, vrsta_materijala){
	var oblast = document.getElementById("nova_oblast").value;
    var pozadinski_zahtev = napraviZahtev(ovo.nextElementSibling);
	pozadinski_zahtev.open("GET","alatke/menja-oblast.php?vrsta_materijala="+vrsta_materijala+"&oblast="+oblast+"&id="+id,true);
	pozadinski_zahtev.send();	
}


function promeniOvuOblast(ovo, id, vrsta_materijala){
    var oblast = ovo.value;
    var pozadinski_zahtev = napraviZahtev(ovo.nextElementSibling);
    pozadinski_zahtev.open("GET","alatke/menja-oblast.php?vrsta_materijala="+vrsta_materijala+"&oblast="+oblast+"&id="+id,true);
    pozadinski_zahtev.send();
}


function promeniVrstu(ovo, id){
	var vrsta_entia = ovo.previousElementSibling.value;
    var pozadinski_zahtev = napraviZahtev(ovo.nextElementSibling);
	pozadinski_zahtev.open("GET","alatke/menja-vrstu.php?vrsta_entia="+vrsta_entia+"&id="+id,true);
	pozadinski_zahtev.send();		
}


function promeniNaziv(ovo, broj_oznake){
	var naslov = document.getElementById("naslov");
	var novi_naziv = naslov.textContent || naslov.innerText;
    var pozadinski_zahtev = napraviZahtev(ovo.nextElementSibling);
	pozadinski_zahtev.open("POST","alatke/menja-naziv.php",true);
	pozadinski_zahtev.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	pozadinski_zahtev.send("novi_naziv=" + novi_naziv + "&broj_oznake=" + broj_oznake);
}


function promeniDatumFotke(ovo, id){
    var datum = ovo.value;
    var pozadinski_zahtev = napraviZahtev(ovo.nextElementSibling);
    pozadinski_zahtev.open("GET","alatke/menja-datum.php?vrsta=3&datum="+datum+"&id="+id,true);
    pozadinski_zahtev.send();
}

// pomoćna funkcija za ajax
function napraviZahtev(target){
    var pozadinski_zahtev = new XMLHttpRequest();
    pozadinski_zahtev.onreadystatechange = function() {
        if (pozadinski_zahtev.status == 200 && pozadinski_zahtev.readyState == 4) {
            target.innerHTML = pozadinski_zahtev.responseText;
        }
    }
    return pozadinski_zahtev;
}