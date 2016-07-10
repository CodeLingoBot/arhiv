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

/*** FUNKCIJE ***/

/* uzima pojam iz kliknutog polja, i broj iz sledećeg, i upisuje u predviđena polja, koja moraju postojati */
function izaberiOznaku(kliknut_pojam) {
    var pojam = kliknut_pojam.innerHTML;
    var broj_pojma = kliknut_pojam.nextElementSibling.innerHTML; // unutar sledećeg je broj pojma
    // upisuje pojam
    if ($("#pojam")) {
        $("#pojam").innerHTML = pojam;
    } else if ($("#tag")) {
        $("#tag").value = pojam;
    }
    $("#br_oznake").value = broj_pojma;
    kliknut_pojam.parentNode.style.display = "none"; // sakriva roditelja, tj. celu listu
}

/*** AJAX ***/

/* prima frazu i prazno polje, vraća sugestije */
function pokaziSugestije(fraza, polje_za_sugestije) {
    if (fraza.length > 1) {
        polje_za_sugestije.style.display = "block";
        var ajax = napraviZahtev(polje_za_sugestije);
        ajax.open("GET", "alatke/sugestije-sve.php?pocetno=" + fraza, true);
        ajax.send();
    }
}

function pozadinskiBrisi(self, vrsta_materijala, broj_entia, id) {
    var ajax = napraviZahtev(self.nextElementSibling);
    ajax.open("GET", "alatke/asinhron-bris.php?vrsta_materijala=" + vrsta_materijala + "&broj_entia=" + broj_entia + "&id=" + id, true);
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
    ajax.open("GET", "alatke/asinhron-tag.php?vrsta_materijala=" + vrsta_materijala + "&broj_entia=" + broj_entia + "&id=" + id, true);
    ajax.send();
}

function izmeniDatum(self, id, vrsta) {
    var ajax = napraviZahtev(self.nextElementSibling);
    // za fotografije šalje skupni datum, za ostalo odvojeno
    if (vrsta == 3) {
        var datum = $("#datum").value;
        ajax.open("GET", "alatke/menja-datum.php?id=" + id + "&vrsta=" + vrsta + "&datum=" + datum, true);
    } else {
        var dan = $("#dan").value;
        var mesec = $("#mesec").value;
        var godina = $("#godina").value;
        ajax.open("GET", "alatke/menja-datum.php?id=" + id + "&vrsta=" + vrsta + "&dan=" + dan + "&mesec=" + mesec + "&godina=" + godina, true);
    }
    ajax.send();
}

function promeniOblast(self, id, vrsta_materijala) {
    var oblast = $("#nova_oblast").value;
    var ajax = napraviZahtev(self.nextElementSibling);
    ajax.open("GET", "alatke/menja-oblast.php?vrsta_materijala=" + vrsta_materijala + "&oblast=" + oblast + "&id=" + id, true);
    ajax.send();
}

function promeniOvuOblast(self, id, vrsta_materijala) {
    var oblast = self.value;
    var ajax = napraviZahtev(self.nextElementSibling);
    ajax.open("GET", "alatke/menja-oblast.php?vrsta_materijala=" + vrsta_materijala + "&oblast=" + oblast + "&id=" + id, true);
    ajax.send();
}

function promeniVrstu(self, id) {
    var vrsta_entia = self.previousElementSibling.value;
    var ajax = napraviZahtev(self.nextElementSibling);
    ajax.open("GET", "alatke/menja-vrstu.php?vrsta_entia=" + vrsta_entia + "&id=" + id, true);
    ajax.send();
}

function promeniNaziv(self, broj_oznake) {
    var naslov = document.getElementById("naslov");
    var novi_naziv = naslov.textContent || naslov.innerText;
    var ajax = napraviZahtev(self.nextElementSibling);
    ajax.open("POST", "alatke/menja-naziv.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send("novi_naziv=" + novi_naziv + "&broj_oznake=" + broj_oznake);
}

function promeniDatumFotke(self, id) {
    var datum = self.value;
    var ajax = napraviZahtev(self.nextElementSibling);
    ajax.open("GET", "alatke/menja-datum.php?vrsta=3&datum=" + datum + "&id=" + id, true);
    ajax.send();
}

// pomoćna funkcija za ajax
function napraviZahtev(target) {
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (ajax.status == 200 && ajax.readyState == 4) {
            target.innerHTML = ajax.responseText;
        }
    };
    return ajax;
}

/*** HELPERS ***/

function citajUrl(varijabla) {
    var upit = window.location.search.substring(1);
    var varijable = upit.split("&");
    for (var i = 0; i < varijable.length; i++) {
        var par = varijable[i].split("=");
        if (par[0] == varijabla) return par[1];
    }
}
