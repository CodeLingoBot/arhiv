/*
implicitno se prosledjuje globalne sa pojam.php:
  var broj_tagovanih_hro = <?php echo $broj_tagovanih_hro; ?>;
  var broj_tagovanih_dok = <?php echo $broj_tagovanih_dok; ?>;
  var broj_tagovanih_fot = <?php echo $broj_tagovanih_fot; ?>;
*/

var broj_tagovanih_hro = $('#broj_tagovanih_hro').value;
var broj_tagovanih_dok = $('#broj_tagovanih_dok').value;
var broj_tagovanih_fot = $('#broj_tagovanih_fot').value;
var broj_oznake = $('#br_oznake').value;
var ucitano_odeljaka = 0;
var hronologija_od = 0;
var hronologija_do = 50;
var dokumenti_od = 0;
var dokumenti_do = 50;
var fotografije_od = 0;
var fotografije_do = 20;

var svi_tagovi = [];
var dozvoljeno_ucitavanje = true;

/*** EVENTS ***/

window.onload = function () {
  ucitavajPodatke(broj_oznake);
};

$("#izaberi-pojam").addEventListener("click", function () {
  otvoriStranu($("#br_oznake").value);
});


/*** FUNKCIJE ***/

function otvoriStranu(id) {
  window.open("http://znaci.net/damjan/pojam.php?br=" + id, "_self");
}

function ucitavajPodatke(broj_oznake) {
  ucitaj("hronologija", "alatke/ajax-hronologija.php", broj_oznake, hronologija_od, hronologija_do);
  ucitaj("dokumenti", "alatke/ajax-dokumenti.php", broj_oznake, dokumenti_od, dokumenti_do);
  ucitaj("fotografije", "alatke/ajax-fotografije.php", broj_oznake, fotografije_od, fotografije_do);
}


function ucitaj(element, url, br, ucitaj_od, ucitaj_do) {
  var xmlhttp = new XMLHttpRequest();
  var target = document.getElementById(element);
  xmlhttp.open("GET", url + "?br=" + br + "&ucitaj_od=" + ucitaj_od + "&ucitaj_do=" + ucitaj_do, true);
  xmlhttp.send();

  xmlhttp.onreadystatechange = function () { // povratne radnje
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var ucitavaci = [];
      var i;
      for (i = 0; i < target.childNodes.length; i++) { // hvata sve učitavače u elementu
        if (target.childNodes[i].className == "ucitavac") {
          ucitavaci.push(target.childNodes[i]);
        }
      }

      for (i = 0; i < ucitavaci.length; i++) { // sakriva postojeće učitavače
        ucitavaci[0].className = "nevidljiv";
      }

      target.innerHTML += xmlhttp.responseText; // dodaje tekst (i novi učitavač)
      prikupljajTagove();
      dozvoljeno_ucitavanje = true;
    } // if
  }; // callback
} // ucitaj


function ucitajJos(ovo) {
  if (dozvoljeno_ucitavanje) {

    if (ovo.children[1].id == "hronologija") {
      if (hronologija_do < broj_tagovanih_hro) { // ako je ostalo materijala
        hronologija_od = hronologija_do; // nastavlja gde je stao
        hronologija_do += 100; // pomera gornju granicu
        ucitaj("hronologija", "alatke/ajax-hronologija.php", broj_oznake, hronologija_od, hronologija_do);
        dozvoljeno_ucitavanje = false; // obustavlja dalje ucitavanje dok ne stignu podaci
      }
    }
    if (ovo.children[1].id == "dokumenti") {
      if (dokumenti_do < broj_tagovanih_dok) {
        dokumenti_od = dokumenti_do; // nastavlja gde je stao
        dokumenti_do += 100; // pomera gornju granicu
        ucitaj("dokumenti", "alatke/ajax-dokumenti.php", broj_oznake, dokumenti_od, dokumenti_do);
        dozvoljeno_ucitavanje = false; // obustavlja dalje ucitavanje dok ne stignu podaci
      }
    }
    if (ovo.children[1].id == "fotografije") {
      if (fotografije_do < broj_tagovanih_fot) {
        fotografije_od = fotografije_do; // nastavlja gde je stao
        fotografije_do += 20; // pomera gornju granicu
        ucitaj("fotografije", "alatke/ajax-fotografije.php", broj_oznake, fotografije_od, fotografije_do);
        dozvoljeno_ucitavanje = false; // obustavlja dalje ucitavanje dok ne stignu podaci
      }
    }
  }
}


function prikupljajTagove() {
  ucitano_odeljaka++;
  if (ucitano_odeljaka >= 3) {
    var prikupljeni_tagovi = $$('.prikupljeni_tagovi'); // hvata sve tagove iz skrivenih polja

    for (var i = 0; i < prikupljeni_tagovi.length; i++) {
      var ovi_tagovi = JSON.parse(prikupljeni_tagovi[i].innerHTML);
      // dodaje ove tagove u sve tagove
      Array.prototype.push.apply(svi_tagovi, ovi_tagovi);
      //console.log(svi_tagovi);
    }
    var pasirani_tagovi = JSON.stringify(svi_tagovi);
    vratiSortirano("tagovi", "alatke/ajax-tagovi.php", pasirani_tagovi, broj_oznake);
  }
}


function vratiSortirano(element, url, tagovi, broj_oznake) {
  var pozadinska_veza = new XMLHttpRequest();
  pozadinska_veza.onreadystatechange = function () {
    if (pozadinska_veza.status == 200 && pozadinska_veza.readyState == 4) {
      document.getElementById(element).innerHTML = pozadinska_veza.responseText;
    }
  };
  pozadinska_veza.open("POST", url, true);
  pozadinska_veza.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  pozadinska_veza.send("tagovi=" + tagovi + "&broj_oznake=" + broj_oznake);
}
