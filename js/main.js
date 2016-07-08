window.$ = function(selektor) {
  return document.querySelector(selektor);
};

window.$$ = function(selektor) {
  return document.querySelectorAll(selektor);
};


var polje_za_sugestije = document.getElementById("polje_za_sugestije");
var tag = document.getElementById("tag");
var br_oznake = document.getElementById("br_oznake");


/*** FUNKCIJE ***/

/* prima frazu i prazno polje, vraća sugestije */
function pokaziSugestije(fraza, polje_za_sugestije) {
  if (fraza.length > 1) {
    polje_za_sugestije.style.display = "block";
    var pozadinski_zahtev = napraviZahtev(polje_za_sugestije);
    pozadinski_zahtev.open("GET", "alatke/sugestije-sve.php?pocetno=" + fraza, true);
    pozadinski_zahtev.send();
  }
}

/* uzima pojam iz kliknutog polja, i broj iz sledećeg, i upisuje u predviđena polja, koja moraju postojati */
function izaberiOznaku(kliknut_pojam) {
  var pojam = kliknut_pojam.innerHTML;
  var broj_pojma = kliknut_pojam.nextElementSibling.innerHTML; // unutar sledećeg je broj pojma
  // upisuje pojam
  if (document.getElementById("pojam")) {
    document.getElementById("pojam").innerHTML = pojam;
  } else if (document.getElementById("tag")) {
    document.getElementById("tag").value = pojam;
  }
  document.getElementById("br_oznake").value = broj_pojma;
  kliknut_pojam.parentNode.style.display = "none"; // sakriva roditelja, tj. celu listu
}


function pozadinskiBrisi(ovaj, vrsta_materijala, broj_entia, id) {
  var pozadinski_zahtev = napraviZahtev(ovaj.nextElementSibling);
  pozadinski_zahtev.open("GET", "alatke/asinhron-bris.php?vrsta_materijala=" + vrsta_materijala + "&broj_entia=" + broj_entia + "&id=" + id, true);
  pozadinski_zahtev.send();
}


function pozadinskiTaguj(ovaj, vrsta_materijala, broj_entia, id) {
  var target = document.createElement("span");
  if (ovaj.nextSibling) {
    ovaj.parentNode.insertBefore(target, ovaj.nextSibling);
  } else {
    ovaj.parentNode.appendChild(target);
  }
  var pozadinski_zahtev = napraviZahtev(target);
  pozadinski_zahtev.open("GET", "alatke/asinhron-tag.php?vrsta_materijala=" + vrsta_materijala + "&broj_entia=" + broj_entia + "&id=" + id, true);
  pozadinski_zahtev.send();
}


function izmeniDatum(ovaj, id, vrsta) {
  var pozadinski_zahtev = napraviZahtev(ovaj.nextElementSibling);
  // za fotografije šalje skupni datum, za ostalo odvojeno
  if (vrsta == 3) {
    var datum = document.getElementById("datum").value;
    pozadinski_zahtev.open("GET", "alatke/menja-datum.php?id=" + id + "&vrsta=" + vrsta + "&datum=" + datum, true);
  } else {
    var dan = document.getElementById("dan").value;
    var mesec = document.getElementById("mesec").value;
    var godina = document.getElementById("godina").value;
    pozadinski_zahtev.open("GET", "alatke/menja-datum.php?id=" + id + "&vrsta=" + vrsta + "&dan=" + dan + "&mesec=" + mesec + "&godina=" + godina, true);
  }
  pozadinski_zahtev.send();
}


function promeniOblast(ovaj, id, vrsta_materijala) {
  var oblast = document.getElementById("nova_oblast").value;
  var pozadinski_zahtev = napraviZahtev(ovaj.nextElementSibling);
  pozadinski_zahtev.open("GET", "alatke/menja-oblast.php?vrsta_materijala=" + vrsta_materijala + "&oblast=" + oblast + "&id=" + id, true);
  pozadinski_zahtev.send();
}


function promeniOvuOblast(ovaj, id, vrsta_materijala) {
  var oblast = ovaj.value;
  var pozadinski_zahtev = napraviZahtev(ovaj.nextElementSibling);
  pozadinski_zahtev.open("GET", "alatke/menja-oblast.php?vrsta_materijala=" + vrsta_materijala + "&oblast=" + oblast + "&id=" + id, true);
  pozadinski_zahtev.send();
}


function promeniVrstu(ovaj, id) {
  var vrsta_entia = ovaj.previousElementSibling.value;
  var pozadinski_zahtev = napraviZahtev(ovaj.nextElementSibling);
  pozadinski_zahtev.open("GET", "alatke/menja-vrstu.php?vrsta_entia=" + vrsta_entia + "&id=" + id, true);
  pozadinski_zahtev.send();
}


function promeniNaziv(ovaj, broj_oznake) {
  var naslov = document.getElementById("naslov");
  var novi_naziv = naslov.textContent || naslov.innerText;
  var pozadinski_zahtev = napraviZahtev(ovaj.nextElementSibling);
  pozadinski_zahtev.open("POST", "alatke/menja-naziv.php", true);
  pozadinski_zahtev.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  pozadinski_zahtev.send("novi_naziv=" + novi_naziv + "&broj_oznake=" + broj_oznake);
}


function promeniDatumFotke(ovaj, id) {
  var datum = ovaj.value;
  var pozadinski_zahtev = napraviZahtev(ovaj.nextElementSibling);
  pozadinski_zahtev.open("GET", "alatke/menja-datum.php?vrsta=3&datum=" + datum + "&id=" + id, true);
  pozadinski_zahtev.send();
}

// pomoćna funkcija za ajax
function napraviZahtev(target) {
  var pozadinski_zahtev = new XMLHttpRequest();
  pozadinski_zahtev.onreadystatechange = function () {
    if (pozadinski_zahtev.status == 200 && pozadinski_zahtev.readyState == 4) {
      target.innerHTML = pozadinski_zahtev.responseText;
    }
  };
  return pozadinski_zahtev;
}
