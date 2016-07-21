var broj_oznake = $('#br_oznake').value;
var broj_tagovanih_hro = $('#broj_tagovanih_hro').value;
var broj_tagovanih_dok = $('#broj_tagovanih_dok').value;
var broj_tagovanih_fot = $('#broj_tagovanih_fot').value;
var ucitano_podeoka = 0;
var hronologija_od = 0;
var hronologija_do = 20;
var dokumenti_od = 0;
var dokumenti_do = 20;
var fotografije_od = 0;
var fotografije_do = 20;

var svi_tagovi = [];
var dozvoljeno_ucitavanje = true;

/*** EVENTS ***/

window.onload = function() {
    ucitajPodatke(broj_oznake);
};

$("#izaberi-pojam").addEventListener("click", function() {
    otvoriStranu($("#br_oznake").value);
});


/*** FUNKCIJE ***/

function otvoriStranu(id) {
    window.open("http://znaci.net/damjan/pojam.php?br=" + id, "_self");
}

function ucitajPodatke(broj_oznake) {
    ucitaj("hronologija", "api/ajax-hronologija.php", broj_oznake, hronologija_od, hronologija_do);
    ucitaj("dokumenti", "api/ajax-dokumenti.php", broj_oznake, dokumenti_od, dokumenti_do);
    ucitaj("fotografije", "api/ajax-fotografije.php", broj_oznake, fotografije_od, fotografije_do);
}

function ucitaj(element, url, br, ucitaj_od, ucitaj_do) {
    var http = new XMLHttpRequest();
    var target = document.getElementById(element);
    http.open("GET", url + "?br=" + br + "&ucitaj_od=" + ucitaj_od + "&ucitaj_do=" + ucitaj_do, true);
    http.send();
    http.onreadystatechange = function() {
        if (http.readyState == 4 && http.status == 200) {
            for (var i = 0; i < target.childNodes.length; i++) { // sakriva decu učitavače
                if (target.childNodes[i].className == "ucitavac") target.childNodes[i].className = "hide";
            }
            target.innerHTML += http.responseText; // dodaje tekst (i novi učitavač)
            prikupljajTagove();
            dozvoljeno_ucitavanje = true;
        } // if
    }; // callback
}

function ucitajJos(podeok) {
    if (!dozvoljeno_ucitavanje) return;

    if (podeok == "hronologija" && hronologija_do < broj_tagovanih_hro) { // ako je ostalo materijala
        hronologija_od = hronologija_do; // nastavlja gde je stao
        hronologija_do += 100; // pomera gornju granicu
        ucitaj("hronologija", "api/ajax-hronologija.php", broj_oznake, hronologija_od, hronologija_do);
        dozvoljeno_ucitavanje = false; // obustavlja dalje ucitavanje dok ne stignu podaci
    }
    if (podeok == "dokumenti" && dokumenti_do < broj_tagovanih_dok) {
        dokumenti_od = dokumenti_do;
        dokumenti_do += 100;
        ucitaj("dokumenti", "api/ajax-dokumenti.php", broj_oznake, dokumenti_od, dokumenti_do);
        dozvoljeno_ucitavanje = false;
    }
    if (podeok == "fotografije" && fotografije_do < broj_tagovanih_fot) {
        fotografije_od = fotografije_do;
        fotografije_do += 20;
        ucitaj("fotografije", "api/ajax-fotografije.php", broj_oznake, fotografije_od, fotografije_do);
        dozvoljeno_ucitavanje = false;
    }
}

function prikupljajTagove() {
    ucitano_podeoka++;
    if (ucitano_podeoka >= 3) {
        var prikupljeni_tagovi = $$('.prikupljeni_tagovi'); // hvata sve tagove iz skrivenih polja
        for (var i = 0; i < prikupljeni_tagovi.length; i++) {
            var ovi_tagovi = JSON.parse(prikupljeni_tagovi[i].innerHTML);
            // dodaje ove tagove u sve tagove
            Array.prototype.push.apply(svi_tagovi, ovi_tagovi);
        }
        var pasirani_tagovi = JSON.stringify(svi_tagovi);
        vratiSortirano("tagovi", "api/ajax-tagovi.php", pasirani_tagovi, broj_oznake);
    }
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
