// nema vise vrste u URL-u, srediti to!!!

let id = null
let vrsta = null

/** FUNCTIONS **/

function $(selektor) {
  return document.querySelector(selektor)
}

/** * DOGAĐAJI ***/

window.addEventListener('load', function() {
  id = citajUrl('br')
  vrsta = citajUrl('vrsta')
})

$('#oznaka').addEventListener('keyup', function(e) {
  $('#id_oznake').value = ''
  pokaziSugestije(e.target.value, $('#sugestije_oznaka'))
})

document.addEventListener('click', function(e) {
  const el = e.target
  if (el.id == 'azuriraj_opis') $('#novi_opis').value = $('#opis').textContent || $('#opis').innerText

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
})
