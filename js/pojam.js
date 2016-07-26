var hronologija = {
  skroler: '#hronologija',
  target: "#hronologija-sadrzaj",
  ukupno: '#broj_tagovanih_hro',
  api: "api/ajax-hronologija.php",
  od: 0,
  do: 20
};

var dokumenti = {
  skroler: '#dokumenti',
  target: "#dokumenti-sadrzaj",
  ukupno: '#broj_tagovanih_dok',
  api: "api/ajax-dokumenti.php",
  od: 0,
  do: 20
};

var fotografije = {
  skroler: '#fotografije',
  target: "#fotografije-sadrzaj",
  ukupno: '#broj_tagovanih_fot',
  api: "api/ajax-fotografije.php",
  od: 0,
  do: 20
};

var broj_oznake = null;
var ucitano_podeoka = 0;
var ukupno_podeoka = 3;
var svi_tagovi = [];
var dozvoljeno_ucitavanje = true;

/*** EVENTS ***/

window.addEventListener('load', function () {
  hronologija.target = $(hronologija.target);
  hronologija.ukupno = $(hronologija.ukupno).value;
  dokumenti.target = $(dokumenti.target);
  dokumenti.ukupno = $(dokumenti.ukupno).value;
  fotografije.target = $(fotografije.target);
  fotografije.ukupno = $(fotografije.ukupno).value;

  broj_oznake = $('#br_oznake').value;
  ucitajInicijalno(broj_oznake);
});

window.addEventListener('scroll', function (e) {
  var element = e.target;
  if (element.id == 'hronologija') ucitajJos(hronologija);
  if (element.id == 'dokumenti') ucitajJos(dokumenti);
  if (element.id == 'fotografije') ucitajJos(fotografije);
});

document.addEventListener('click', function (e) {
  var element = e.target;
  if (element.id == 'izaberi-pojam') otvoriStranu($("#br_oznake").value);
  if (element.id == 'promeni-naziv') promeniNaziv(element.nextElementSibling, broj_oznake, $('#pojam').innerText);
});


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
  console.log('target', target);
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
  var neprevedeni_tagovi = JSON.stringify(svi_tagovi);
  prevediTagove($("#tagovi"), "api/ajax-tagovi.php", neprevedeni_tagovi, broj_oznake);
}

function prevediTagove(target, url, tagovi, broj_oznake) {
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function() {
    if (ajax.status != 200 || ajax.readyState != 4) return;
    target.innerHTML = ajax.responseText;
  };
  ajax.open("POST", url, true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send("tagovi=" + tagovi + "&broj_oznake=" + broj_oznake);
}
