const BASE_URL = '/arhiv/'

/*** DOGAĐAJI ***/

window.addEventListener('load', function() {
  $('#odrednica').addEventListener('keyup', function(e) {
    pokaziSugestije(e.target.value, $('#sugestije_odrednica'))
  })
})

document.addEventListener('click', function(e) {
  const el = e.target

  if (el.classList.contains('js-promeni-vrstu-oznake')) {
    promeniVrstuOznake(el.nextElementSibling, el.dataset.id, el.previousElementSibling.value)
  }

  if (el.classList.contains('js-sugestije') && el.parentElement.parentElement.id === 'sugestije_odrednica') 
    otvoriStranu(el.dataset.id)
})


/*** FUNKCIJE ***/

function otvoriStranu(id) {
  window.open(BASE_URL + "odrednica.php?br=" + id, "_self");
}

// AJAX

function napraviAjax(element) {
  const ajax = new XMLHttpRequest()
  ajax.onreadystatechange = function() {
    if (ajax.status != 200 || ajax.readyState != 4) return
    element.innerHTML = ajax.responseText
  }
  return ajax
}

function pokaziSugestije(fraza, element) {
  if (fraza.length <= 1) return
  const ajax = napraviAjax(element)
  ajax.open('GET', BASE_URL + 'api/sugestije-sve.php?pocetno=' + fraza)
  ajax.send()
}

function pozadinskiBrisi(element, vrsta_materijala, id_oznake, id_izvora) {
  const ajax = napraviAjax(element)
  ajax.open('GET', BASE_URL + 'api/asinhron-bris.php?vrsta_materijala=' + vrsta_materijala + '&broj_entia=' + id_oznake + '&id=' + id_izvora)
  ajax.send()
}

function pozadinskiTaguj(element, vrsta_materijala, id_oznake, id_izvora) {
  const ajax = napraviAjax(element)
  ajax.open('GET', BASE_URL + 'api/asinhron-tag.php?vrsta_materijala=' + vrsta_materijala + '&broj_entia=' + id_oznake + '&id=' + id_izvora)
  ajax.send()
}

function izmeniDatumZasebno(element, id, vrsta, dan, mesec, godina) {
  const ajax = napraviAjax(element)
  ajax.open('GET', BASE_URL + 'api/menja-datum.php?id=' + id + '&vrsta=' + vrsta + '&dan=' + dan + '&mesec=' + mesec + '&godina=' + godina)
  ajax.send()
}

function izmeniDatumFotografije(element, id, datum) {
  const ajax = napraviAjax(element)
  ajax.open('GET', BASE_URL + 'api/menja-datum.php?id=' + id + '&vrsta=3&datum=' + datum)
  ajax.send()
}

function promeniOblast(element, id, vrsta_materijala, oblast) {
  const ajax = napraviAjax(element)
  ajax.open('GET', BASE_URL + 'api/menja-oblast.php?vrsta_materijala=' + vrsta_materijala + '&oblast=' + oblast + '&id=' + id)
  ajax.send()
}

function promeniVrstuOznake(element, id, vrsta_entia) {
  const ajax = napraviAjax(element)
  ajax.open('GET', BASE_URL + 'api/menja-vrstu.php?vrsta_entia=' + vrsta_entia + '&id=' + id)
  ajax.send()
}

function promeniPripadnost(element, dokument_id, nova_pripadnost) {
  const ajax = napraviAjax(element)
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
