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

function povratniZahtev(target) {
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
  if (fraza.length <= 1) return;
  polje_za_sugestije.style.display = "block";
  var ajax = povratniZahtev(polje_za_sugestije);
  ajax.open("GET", BASE_URL + "api/sugestije-sve.php?pocetno=" + fraza);
  ajax.send();
}

function pozadinskiBrisi(target, vrsta_materijala, broj_entia, id) {
  var ajax = povratniZahtev(target);
  ajax.open("GET", BASE_URL + "api/asinhron-bris.php?vrsta_materijala=" + vrsta_materijala + "&broj_entia=" + broj_entia + "&id=" + id);
  ajax.send();
}

function pozadinskiTaguj(target, vrsta_materijala, broj_entia, id) {
  var ajax = povratniZahtev(target);
  ajax.open("GET", BASE_URL + "api/asinhron-tag.php?vrsta_materijala=" + vrsta_materijala + "&broj_entia=" + broj_entia + "&id=" + id);
  ajax.send();
}

function izmeniDatumZasebno(target, id, vrsta, dan, mesec, godina) {
  var ajax = povratniZahtev(target);
  ajax.open("GET", BASE_URL + "api/menja-datum.php?id=" + id + "&vrsta=" + vrsta + "&dan=" + dan + "&mesec=" + mesec + "&godina=" + godina);
  ajax.send();
}

function izmeniDatumFotografije(target, id, datum) {
  var ajax = povratniZahtev(target);
  ajax.open("GET", BASE_URL + "api/menja-datum.php?id=" + id + "&vrsta=3&datum=" + datum);
  ajax.send();
}

function promeniOblast(target, id, vrsta_materijala, oblast) {
  var ajax = povratniZahtev(target);
  ajax.open("GET", BASE_URL + "api/menja-oblast.php?vrsta_materijala=" + vrsta_materijala + "&oblast=" + oblast + "&id=" + id);
  ajax.send();
}

function promeniVrstuOznake(target, id, vrsta_entia) {
  var ajax = povratniZahtev(target);
  ajax.open("GET", BASE_URL + "api/menja-vrstu.php?vrsta_entia=" + vrsta_entia + "&id=" + id);
  ajax.send();
}

function promeniNaziv(target, broj_oznake, novi_naziv) {
  var ajax = povratniZahtev(target);
  ajax.open("POST", BASE_URL + "api/menja-naziv.php");
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("novi_naziv=" + novi_naziv + "&broj_oznake=" + broj_oznake);
}

function promeniPripadnost(target, dokument_id, nova_pripadnost) {
  var ajax = povratniZahtev(target);
  ajax.open("POST", BASE_URL + "api/menja-pripadnost.php");
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
