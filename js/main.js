var BASE_URL = "/damjan/";

window.$ = function(selektor) {
  return document.querySelector(selektor);
};

window.$$ = function(selektor) {
  return document.querySelectorAll(selektor);
};

/*** VARIJABLE ***/

var polje_za_sugestije = $("#polje_za_sugestije");
var br_oznake = $("#br_oznake");
var tag = $("#tag");

/*** DOGAĐAJI ***/

window.addEventListener('load', function () {

  if ($('#tag')) {
    $('#tag').addEventListener('keyup', function (e) {
      pokaziSugestije(e.target.value, $('#polje_za_sugestije'));
    });
  }

});

/*** FUNKCIJE ***/

/* uzima pojam iz kliknutog polja, i broj iz sledećeg, i upisuje u predviđena polja, koja moraju postojati */
function izaberiOznaku(e) {
  var kliknut_pojam = e.target;
  var pojam = kliknut_pojam.innerHTML;
  var broj_pojma = kliknut_pojam.nextElementSibling.innerHTML; // unutar sledećeg je broj pojma
  $("#tag").value = pojam;
  $("#br_oznake").value = broj_pojma;
  kliknut_pojam.parentNode.style.display = "none"; // sakriva roditelja, tj. celu listu
}

// AJAX

function napraviZahtev(target) {
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function() {
    if (ajax.status != 200 || ajax.readyState != 4) return;
    target.innerHTML = ajax.responseText;
    for (var i = 0; i < $$('.predlozi').length; i++) {
      $$('.predlozi')[i].addEventListener('click', izaberiOznaku);
    }
  };
  return ajax;
}

/* prima frazu i prazno polje, vraća sugestije */
function pokaziSugestije(fraza, polje_za_sugestije) {
  if (fraza.length > 1) {
    polje_za_sugestije.style.display = "block";
    var ajax = napraviZahtev(polje_za_sugestije);
    ajax.open("GET", BASE_URL + "api/sugestije-sve.php?pocetno=" + fraza, true);
    ajax.send();
  }
}

function pozadinskiBrisi(self, vrsta_materijala, broj_entia, id) {
  var ajax = napraviZahtev(self.nextElementSibling);
  ajax.open("GET", BASE_URL + "api/asinhron-bris.php?vrsta_materijala=" + vrsta_materijala + "&broj_entia=" + broj_entia + "&id=" + id, true);
  ajax.send();
}

function pozadinskiTaguj(self, vrsta_materijala, broj_entia, id) {
  console.log(self, vrsta_materijala, broj_entia, id);
  var target = document.createElement("span");
  if (self.nextSibling) {
    self.parentNode.insertBefore(target, self.nextSibling);
  } else {
    self.parentNode.appendChild(target);
  }
  var ajax = napraviZahtev(target);
  ajax.open("GET", BASE_URL + "api/asinhron-tag.php?vrsta_materijala=" + vrsta_materijala + "&broj_entia=" + broj_entia + "&id=" + id, true);
  ajax.send();
}

function izmeniDatum(self, id, vrsta) {
  var ajax = napraviZahtev(self.nextElementSibling);
  // za fotografije šalje skupni datum, za ostalo odvojeno
  if (vrsta == 3) {
    var datum = $("#datum").value;
    ajax.open("GET", BASE_URL + "api/menja-datum.php?id=" + id + "&vrsta=" + vrsta + "&datum=" + datum, true);
  } else {
    var dan = $("#dan").value;
    var mesec = $("#mesec").value;
    var godina = $("#godina").value;
    ajax.open("GET", BASE_URL + "api/menja-datum.php?id=" + id + "&vrsta=" + vrsta + "&dan=" + dan + "&mesec=" + mesec + "&godina=" + godina, true);
  }
  ajax.send();
}

function promeniOblast(self, id, vrsta_materijala) {
  var oblast = $("#nova_oblast").value;
  var ajax = napraviZahtev(self.nextElementSibling);
  ajax.open("GET", BASE_URL + "api/menja-oblast.php?vrsta_materijala=" + vrsta_materijala + "&oblast=" + oblast + "&id=" + id, true);
  ajax.send();
}

function promeniOvuOblast(self, id, vrsta_materijala) {
  var oblast = self.value;
  var ajax = napraviZahtev(self.nextElementSibling);
  ajax.open("GET", BASE_URL + "api/menja-oblast.php?vrsta_materijala=" + vrsta_materijala + "&oblast=" + oblast + "&id=" + id, true);
  ajax.send();
}

function promeniVrstu(self, id) {
  var vrsta_entia = self.previousElementSibling.value;
  var ajax = napraviZahtev(self.nextElementSibling);
  ajax.open("GET", BASE_URL + "api/menja-vrstu.php?vrsta_entia=" + vrsta_entia + "&id=" + id, true);
  ajax.send();
}

function promeniDatumFotke(self, id) {
  var datum = self.value;
  var ajax = napraviZahtev(self.nextElementSibling);
  ajax.open("GET", BASE_URL + "api/menja-datum.php?vrsta=3&datum=" + datum + "&id=" + id, true);
  ajax.send();
}

function promeniNaziv(self, broj_oznake) {
  var pojam = document.getElementById("pojam");
  var novi_naziv = pojam.textContent || pojam.innerText;
  var ajax = napraviZahtev(self.nextElementSibling);
  ajax.open("POST", BASE_URL + "api/menja-naziv.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("novi_naziv=" + novi_naziv + "&broj_oznake=" + broj_oznake);
}

function promeniPripadnost(target, dokument_id, nova_pripadnost) {
  var ajax = napraviZahtev(target);
  ajax.open("POST", BASE_URL + "api/menja-pripadnost.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("nova_pripadnost=" + nova_pripadnost + "&dokument_id=" + dokument_id);
}

// HELPERS

function citajUrl(varijabla) {
  var upit = window.location.search.substring(1);
  var varijable = upit.split("&");
  for (var i = 0; i < varijable.length; i++) {
    var par = varijable[i].split("=");
    if (par[0] == varijabla) return par[1];
  }
}
