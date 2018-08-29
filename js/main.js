const BASE_URL = '/arhiv/'

/*** FUNKCIJE ***/

// HELPERS

function $(selektor) {
  return document.querySelector(selektor)
}

function $$(selektor) {
  return document.querySelectorAll(selektor)
}

function otvoriStranu(slug) {
  window.open(BASE_URL + "odrednica/" + slug, "_self");
}

// AJAX

function napraviAjax(element, atribut = 'innerHTML') {
  const ajax = new XMLHttpRequest()
  ajax.onreadystatechange = function() {
    if (ajax.status != 200 || ajax.readyState != 4) return
    element[atribut] = ajax.responseText
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

/*** DOGAĐAJI ***/

window.addEventListener('load', function() {
  Array.from($$('.js-sugestija')).map(
    el => el.addEventListener('keyup', e => {
      pokaziSugestije(el.value, el.nextElementSibling)
      el.nextElementSibling.nextElementSibling.value = ''
    })
  )
})

document.addEventListener('click', function(e) {
  const el = e.target

  if (el.classList.contains('js-promeni-vrstu-oznake')) {
    promeniVrstuOznake(el.nextElementSibling, el.dataset.id, el.previousElementSibling.value)
  }

  /*
    HTML struktura: input (sugestija) - span ili div - input (broj oznake)
  */
  if (el.classList.contains('js-sugestije')) {
    const sugestije = el.parentElement.parentElement
    if (sugestije.id === 'sugestije_odrednica') return otvoriStranu(el.dataset.slug)
    sugestije.previousElementSibling.value = el.innerHTML
    sugestije.nextElementSibling.value = el.dataset.id
  }
})