var hronologija = {
  skroler: $('#hronologija'),
  target: $("#hronologija-sadrzaj"),
  api: "api/ajax-hronologija.php",
  ukupno: $('#broj_tagovanih_hro').value,
  od: 0,
  do: 20
};

var dokumenti = {
  skroler: $('#dokumenti'),
  target: $("#dokumenti-sadrzaj"),
  api: "api/ajax-dokumenti.php",
  ukupno: $('#broj_tagovanih_dok').value,
  od: 0,
  do: 20
};

var fotografije = {
  skroler: $('#fotografije'),
  target: $("#fotografije-sadrzaj"),
  api: "api/ajax-fotografije.php",
  ukupno: $('#broj_tagovanih_fot').value,
  od: 0,
  do: 20
};

var broj_oznake = null;
var ucitano_podeoka = 0;
var ukupno_podeoka = 3;
var svi_tagovi = [];
var dozvoljeno_ucitavanje = true;

/*** EVENTS ***/

window.onload = function() {
  broj_oznake = $('#br_oznake').value;
  ucitajInicijalno(broj_oznake);

  $('#hronologija').addEventListener("scroll", function () {
    ucitajJos(hronologija);
  });

  $('#dokumenti').addEventListener("scroll", function () {
    ucitajJos(dokumenti);
  });

  $('#fotografije').addEventListener("scroll", function () {
    ucitajJos(fotografije);
  });

  $("#izaberi-pojam").addEventListener("click", function() {
    otvoriStranu($("#br_oznake").value);
  });

};

/*** FUNKCIJE ***/

function otvoriStranu(id) {
  window.open("http://znaci.net/damjan/pojam.php?br=" + id, "_self");
}

function ucitajInicijalno(broj_oznake) {
  ucitaj(hronologija.target, hronologija.api, hronologija.od, hronologija.do);
  ucitaj(dokumenti.target, dokumenti.api, dokumenti.od, dokumenti.do);
  ucitaj(fotografije.target, fotografije.api, fotografije.od, fotografije.do);
}

function ucitaj(target, url, ucitaj_od, ucitaj_do) {
  var http = new XMLHttpRequest();
  http.open("GET", url + "?br=" + broj_oznake + "&ucitaj_od=" + ucitaj_od + "&ucitaj_do=" + ucitaj_do);
  http.send();
  http.onreadystatechange = function() {
    if (http.readyState != 4 || http.status != 200) return;
    sakrijUcitavace(target);
    target.innerHTML += http.responseText; // dodaje tekst i novi učitavač
    prikupljajTagove();
    dozvoljeno_ucitavanje = true;
  }; // callback
}

function sakrijUcitavace(target) {
  for (var i = 0; i < target.childNodes.length; i++) {
    if (target.childNodes[i].className == "ucitavac") target.childNodes[i].className = "hide";
  }
}

function ucitajJos(predmet) {
  if (!dozvoljeno_ucitavanje || predmet.do >= predmet.ukupno) return;
  predmet.od = predmet.do; // nastavlja gde je stao
  predmet.do += 100; // pomera gornju granicu
  ucitaj(predmet.target, predmet.api, predmet.od, predmet.do);
  dozvoljeno_ucitavanje = false; // brani dalje ucitavanje dok ne stignu podaci
}

function prikupljajTagove() {
  ucitano_podeoka++;
  if (ucitano_podeoka < ukupno_podeoka) return;
  var prikupljeni_tagovi = $$('.prikupljeni_tagovi'); // hvata tagove iz skrivenih polja
  for (var i = 0; i < prikupljeni_tagovi.length; i++) {
    var ovi_tagovi = JSON.parse(prikupljeni_tagovi[i].innerHTML);
    Array.prototype.push.apply(svi_tagovi, ovi_tagovi); // dodaje ove tagove u sve tagove
  }
  var pasirani_tagovi = JSON.stringify(svi_tagovi);
  vratiSortirano("tagovi", "api/ajax-tagovi.php", pasirani_tagovi, broj_oznake);
}

function vratiSortirano(element, url, tagovi, broj_oznake) {
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function() {
    if (ajax.status == 200 && ajax.readyState == 4) {
      document.getElementById(element).innerHTML = ajax.responseText;
    }
  };
  ajax.open("POST", url, true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("tagovi=" + tagovi + "&broj_oznake=" + broj_oznake);
}
