const id = $('#izvor_id').value
const vrsta = $('#vrsta').value

/*** DOGAĐAJI ***/

document.addEventListener('click', function(e) {
  const el = e.target
  if (el.id == 'azuriraj_opis') 
    $('#novi_opis').value = $('#opis').textContent || $('#opis').innerText
  if (el.id == 'izmeni-datum-fotografije') 
    izmeniDatumFotografije(el.nextElementSibling, id, $('#datum').value)
  if (el.id == 'promeni-pripadnost') 
    promeniPripadnost(el.nextElementSibling, id, $('#nova_pripadnost').value)

  if (el.id == 'izmeni-datum-zasebno')
    izmeniDatumZasebno(el.nextElementSibling, id, vrsta, $('#dan').value, $('#mesec').value, $('#godina').value)
  if (el.id == 'promeni-oblast') 
    promeniOblast(el.nextElementSibling, id, vrsta, $('#nova_oblast').value)
  if (el.id == 'brisi-tag') 
    pozadinskiBrisi(el.nextElementSibling, vrsta, el.value, id)
  if (el.id == 'dodaj-tag')
    pozadinskiTaguj(el.nextElementSibling, vrsta, el.previousElementSibling.value, id)
})
