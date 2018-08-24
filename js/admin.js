function praviTag(element, nazivTaga, vrstaTaga) {
  const ajax = napraviAjax(element, 'value')
  ajax.open('POST', BASE_URL + 'api/pravi-tag.php')
  ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
  ajax.send('naziv_taga=' + nazivTaga + '&vrsta_taga=' + vrstaTaga)
}

function masovnoBiraOblast() {
  var izabrana_oblast = document.getElementById("izabrana_oblast");
  var oblasti = document.getElementsByClassName("oblast");
  for(var i = 0; i < oblasti.length; i++) {
      oblasti[i].value = izabrana_oblast.value;
  }
}

/* DOGAĐAJI */

Array.from($$('.js-taguj')).map(el => el.addEventListener('click', e => 
    pozadinskiTaguj(el, $('#vrsta_materijala').value, $('#br_oznake').value, el.dataset.id)
))

Array.from($$('.js-brisi')).map(el => el.addEventListener('click', e => 
    pozadinskiBrisi(el, $('#vrsta_materijala').value, $('#br_oznake').value, el.dataset.id)
))

Array.from($$('.js-menja-oblast')).map(el => el.addEventListener('dblclick', e => 
    promeniOblast(el.nextElementSibling,  el.dataset.id, $('#vrsta_materijala').value, el.value)
))

$('#pravi-tag').addEventListener('click', e => {
  if (!$('#naziv_oznake').value) return
  praviTag($('#br_oznake'), $('#naziv_oznake').value, $('#vrsta_oznake').value)
})

$('#izabrana_oblast').addEventListener('keyup', masovnoBiraOblast)