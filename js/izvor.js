let id = null
let vrsta = null

let zum = 1.0
let brojStrane = 1

let drzac = null
let ovajDokument = null

PDFJS.workerSrc = 'js/libs/pdfjs/pdf.worker.js'
PDFJS.disableWorker = true // gasi workere zbog cross-origin greške

/** FUNCTIONS **/

function $(selektor) {
  return document.querySelector(selektor)
}

function proverBrojStrane() {
  if (brojStrane < 1) brojStrane = 1
  if (brojStrane > ovajDokument.numPages) brojStrane = ovajDokument.numPages
}

function brisiPrethodneStrane() {
  const strane = document.querySelectorAll('.page')
  for (let i = 0; i < strane.length; i++) {
    strane[i].remove()
  }
}

function azurirajPolja() {
  $('#trenutna_strana').textContent = brojStrane
  $('#ukupno_strana').textContent = ovajDokument.numPages
  $('#zum').textContent = zum.toFixed(1)
}

function azurirajStanje() {
  proverBrojStrane()
  brisiPrethodneStrane()
  azurirajPolja()
}

function renderujStranu() {
  azurirajStanje()
  ovajDokument.getPage(brojStrane)
    .then(function(pdfStrana) {
      const renderOpcije = {
        container: drzac,
        id: brojStrane,
        scale: zum,
        defaultViewport: pdfStrana.getViewport(zum),  // namesta platno na velicinu vidnog polja
        textLayerFactory: new PDFJS.DefaultTextLayerFactory(),
      }
      const pdfPrikaz = new PDFJS.PDFPageView(renderOpcije)
      pdfPrikaz.setPdfPage(pdfStrana)
      pdfPrikaz.draw()
    })
}

function ucitajPDF(fajl_url) {
  PDFJS.getDocument(fajl_url)
    .then(function(pdf) {
      ovajDokument = pdf
      if (brojStrane > ovajDokument.numPages) brojStrane = ovajDokument.numPages
      renderujStranu()
    })
}

function okreniStranu(broj) {
  brojStrane += broj
  renderujStranu()
}

function zumiraj(broj) {
  zum += broj
  renderujStranu()
}

/** * DOGAĐAJI ***/

window.addEventListener('load', function() {
  id = citajUrl('br')
  vrsta = citajUrl('vrsta')
  if (vrsta == 2) {
    brojStrane = Number($('#broj_strane').value)
    drzac = document.getElementById('pdf-drzac')
    const fajl_url = $('#fajl_url').value
    ucitajPDF(fajl_url)
  }
})

$('#oznaka').addEventListener('keyup', function(e) {
  $('#id_oznake').value = ''
  pokaziSugestije(e.target.value, $('#sugestije_oznaka'))
})

document.addEventListener('click', function(e) {
  const el = e.target
  if (el.id == 'azuriraj_opis') $('#novi_opis').value = $('#opis').textContent || $('#opis').innerText

  if (el.classList.contains('js-idi-nazad')) okreniStranu(-1)
  if (el.classList.contains('js-idi-napred')) okreniStranu(1)
  if (el.classList.contains('js-zum')) zumiraj(0.1)
  if (el.classList.contains('js-odzum')) zumiraj(-0.1)

  if (el.id == 'izmeni-datum-fotografije') izmeniDatumFotografije(el.nextElementSibling, id, $('#datum').value)
  if (el.id == 'izmeni-datum-zasebno') {
    izmeniDatumZasebno(el.nextElementSibling, id, vrsta, $('#dan').value, $('#mesec').value, $('#godina').value)
  }
  if (el.id == 'promeni-oblast') promeniOblast(el.nextElementSibling, id, vrsta, $('#nova_oblast').value)
  if (el.id == 'promeni-pripadnost') promeniPripadnost(el.nextElementSibling, id, $('#nova_pripadnost').value)
  if (el.id == 'brisi-tag') pozadinskiBrisi(el.nextElementSibling, vrsta, el.value, id)
  if (el.id == 'dodaj-tag') {
    pozadinskiTaguj(el.nextElementSibling, vrsta, el.previousElementSibling.value, id)
  }

  if (el.classList.contains('js-sugestije') && el.parentElement.parentElement.id === 'sugestije_oznaka') {
    $('#oznaka').value = el.innerHTML
    $('#id_oznake').value = el.dataset.id
  }
})
