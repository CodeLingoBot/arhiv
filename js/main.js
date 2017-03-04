const BASE_URL = '/damjan/'

/** * VARIJABLE ***/

let tag = null
let br_oznake = null
let polje_za_sugestije = null

/** * DOGAĐAJI ***/

window.addEventListener('load', function() {

  tag = $('#tag')
  br_oznake = $('#br_oznake')
  polje_za_sugestije = $('#polje_za_sugestije')

  if (tag) {
    tag.addEventListener('keyup', function(e) {
      pokaziSugestije(e.target.value, polje_za_sugestije)
    })
  }

}) // on load

document.addEventListener('click', function(e) {
  const element = e.target

  if (element.classList.contains('js-promeni-vrstu-oznake')) {
    promeniVrstuOznake(element.nextElementSibling, element.dataset.id, element.previousElementSibling.value)
  }

  if (element.classList.contains('js-sugestije')) izaberiSugestiju(element)

}) // on click


/** * FUNKCIJE ***/

function izaberiSugestiju(element) {
  tag.value = element.innerHTML
  br_oznake.value = element.dataset.id
  polje_za_sugestije.style.display = 'none'
}

// AJAX

function povratniZahtev(target) {
  const ajax = new XMLHttpRequest()
  ajax.onreadystatechange = function() {
    if (ajax.status != 200 || ajax.readyState != 4) return
    target.innerHTML = ajax.responseText
  }
  return ajax
}

/* prima frazu i prazno polje, vraća sugestije */
function pokaziSugestije(fraza, polje_za_sugestije) {
  if (fraza.length <= 1) return
  polje_za_sugestije.style.display = 'block'
  const ajax = povratniZahtev(polje_za_sugestije)
  ajax.open('GET', BASE_URL + 'api/sugestije-sve.php?pocetno=' + fraza)
  ajax.send()
}

function pozadinskiBrisi(target, vrsta_materijala, broj_entia, id) {
  const ajax = povratniZahtev(target)
  ajax.open('GET', BASE_URL + 'api/asinhron-bris.php?vrsta_materijala=' + vrsta_materijala + '&broj_entia=' + broj_entia + '&id=' + id)
  ajax.send()
}

function pozadinskiTaguj(target, vrsta_materijala, broj_entia, id) {
  const ajax = povratniZahtev(target)
  ajax.open('GET', BASE_URL + 'api/asinhron-tag.php?vrsta_materijala=' + vrsta_materijala + '&broj_entia=' + broj_entia + '&id=' + id)
  ajax.send()
}

function izmeniDatumZasebno(target, id, vrsta, dan, mesec, godina) {
  const ajax = povratniZahtev(target)
  ajax.open('GET', BASE_URL + 'api/menja-datum.php?id=' + id + '&vrsta=' + vrsta + '&dan=' + dan + '&mesec=' + mesec + '&godina=' + godina)
  ajax.send()
}

function izmeniDatumFotografije(target, id, datum) {
  const ajax = povratniZahtev(target)
  ajax.open('GET', BASE_URL + 'api/menja-datum.php?id=' + id + '&vrsta=3&datum=' + datum)
  ajax.send()
}

function promeniOblast(target, id, vrsta_materijala, oblast) {
  const ajax = povratniZahtev(target)
  ajax.open('GET', BASE_URL + 'api/menja-oblast.php?vrsta_materijala=' + vrsta_materijala + '&oblast=' + oblast + '&id=' + id)
  ajax.send()
}

function promeniVrstuOznake(target, id, vrsta_entia) {
  const ajax = povratniZahtev(target)
  ajax.open('GET', BASE_URL + 'api/menja-vrstu.php?vrsta_entia=' + vrsta_entia + '&id=' + id)
  ajax.send()
}

function promeniNaziv(target, broj_oznake, novi_naziv) {
  const ajax = povratniZahtev(target)
  ajax.open('POST', BASE_URL + 'api/menja-naziv.php')
  ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
  ajax.send('novi_naziv=' + novi_naziv + '&broj_oznake=' + broj_oznake)
}

function promeniPripadnost(target, dokument_id, nova_pripadnost) {
  const ajax = povratniZahtev(target)
  ajax.open('POST', BASE_URL + 'api/menja-pripadnost.php')
  ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
  ajax.send('nova_pripadnost=' + nova_pripadnost + '&dokument_id=' + dokument_id)
}

// HELPERS

function citajUrl(varijabla) {
  const upit = window.location.search.substring(1)
  const varijable = upit.split('&')
  for (let i = 0; i < varijable.length; i++) {
    const par = varijable[i].split('=')
    if (par[0] == varijabla) return par[1]
  }
}

function $(selektor) {
  return document.querySelector(selektor)
}

function $$(selektor) {
  return document.querySelectorAll(selektor)
}
