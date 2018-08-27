var broj_oznake = null;
var dozvoljeno_ucitavanje = true;
var korak_ucitavanja = 100

var hronologija = {
  skroler: '#hronologija',
  target: "#hronologija-sadrzaj",
  ukupno: '#broj_dogadjaja',
  api: "api/ajax-dogadjaji.php",
  od: 100,
};

var dokumenti = {
  skroler: '#dokumenti',
  target: "#dokumenti-sadrzaj",
  ukupno: '#broj_dokumenata',
  api: "api/ajax-dokumenti.php",
  od: 100,
};

var fotografije = {
  skroler: '#fotografije',
  target: "#fotografije-sadrzaj",
  ukupno: '#broj_fotografija',
  api: "api/ajax-fotografije.php",
  od: 20,
};

/*** EVENTS ***/

window.addEventListener('load', function () {
  hronologija.skroler = $(hronologija.skroler);
  hronologija.target = $(hronologija.target);
  hronologija.ukupno = $(hronologija.ukupno).value;

  dokumenti.skroler = $(dokumenti.skroler);
  dokumenti.target = $(dokumenti.target);
  dokumenti.ukupno = $(dokumenti.ukupno).value;

  fotografije.skroler = $(fotografije.skroler);
  fotografije.target = $(fotografije.target);
  fotografije.ukupno = $(fotografije.ukupno).value;

  broj_oznake = id = citajUrl('br')

  hronologija.skroler.addEventListener("scroll", function () {
    ucitajJos(hronologija);
  });

  dokumenti.skroler.addEventListener("scroll", function () {
    ucitajJos(dokumenti);
  });

  fotografije.skroler.addEventListener("scroll", function () {
    ucitajJos(fotografije);
  });

});

document.addEventListener('click', function (e) {
  var element = e.target;
  if (element.id == 'promeni-naziv') promeniNaziv(element.nextElementSibling, broj_oznake, $('#pojam').innerText);
});

/*** FUNKCIJE ***/

function ucitaj(target, url, ucitaj_od, ucitaj_do) {
  var http = new XMLHttpRequest();
  http.open("GET", url + "?br=" + broj_oznake + "&ucitaj_od=" + ucitaj_od + "&ucitaj_do=" + ucitaj_do);
  http.send();
  http.onreadystatechange = function() {
    if (http.readyState != 4 || http.status != 200) return;
    sakrijUcitavace(target);
    target.innerHTML += http.responseText; // dodaje tekst i novi učitavač
    dozvoljeno_ucitavanje = true;
  };
}

function sakrijUcitavace(target) {
  for (var i = 0; i < target.childNodes.length; i++) {
    if (target.childNodes[i].className == "ucitavac") target.childNodes[i].className = "hide";
  }
}

function ucitajJos(predmet) {
  if (!dozvoljeno_ucitavanje || predmet.od >= predmet.ukupno) return;
  ucitaj(predmet.target, predmet.api, predmet.od, predmet.od + korak_ucitavanja);
  predmet.od += korak_ucitavanja; // pomera gornju granicu
  dozvoljeno_ucitavanje = false; // brani dalje ucitavanje dok ne stignu podaci
}

function promeniNaziv(element, broj_oznake, novi_naziv) {
  const ajax = napraviAjax(element)
  ajax.open('POST', BASE_URL + 'api/menja-naziv.php')
  ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
  ajax.send('novi_naziv=' + novi_naziv + '&broj_oznake=' + broj_oznake)
}
