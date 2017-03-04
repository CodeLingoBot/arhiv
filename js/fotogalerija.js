const pokrov = document.getElementById('pokrov')
const prozorce = document.getElementById('prozorce')
const prozorce_opis = document.getElementById('prozor-za-tekst-opis')
const galerija = document.getElementsByClassName('galerija-slike')

/** FUNCTIONS **/

function slikaReaguje(e) {
  e.target.style.opacity = '0.8'
}

function slikaNormalno(e) {
  e.target.style.opacity = '1'
}

function iskaceProzorce(e) {
  const izvorSlike = e.target.src
  const brInv = izvorSlike.match(/\d+/)[0]
  const velikiIzvorSlike = `http://znaci.net/images/${brInv}.jpg`
  prozorce.onload = function() {
    prozorce.src = velikiIzvorSlike
  }
  prozorce.src = izvorSlike
  pokrov.style.display = prozorce.style.display = 'block'
  prozorce.style.left = (window.innerWidth / 2 - prozorce.offsetWidth / 2) + 'px'
  const tekstualniOpis = document.getElementById('tekst-opis-' + brInv)
  if (tekstualniOpis) {
    prozorce_opis.innerHTML = tekstualniOpis.innerHTML
    prozorce_opis.style.padding = '10px'
    prozorce_opis.style.display = 'block'
  }
  prozorce_opis.style.width = (prozorce.offsetWidth - 40) + 'px'
  prozorce_opis.style.left = (window.innerWidth / 2 - prozorce.offsetWidth / 2) + 20 + 'px'
  // ako je slika položena
  if(e.target.width > e.target.height) {
    prozorce_opis.style.width = (prozorce.offsetWidth - 160) + 'px'
    prozorce_opis.style.left = (window.innerWidth / 2 - prozorce.offsetWidth / 2) + 80 + 'px'
  }
}

function nestajeProzorce() {
  prozorce.style.display = 'none'
  pokrov.style.display = 'none'
  prozorce_opis.style.display = 'none'
}

// ne moze zatvoriti samo opis jer su spojeni kao dve pozadinske slike
function nestajeOpis() {
  prozorce_opis.style.display = 'none'
}

/** EVENTS **/

for (let i = 0; i < galerija.length; i++) {
  galerija[i].addEventListener('click', iskaceProzorce) // iskaceProzorce(this)
  galerija[i].addEventListener('mouseover', slikaReaguje) // slikaReaguje(this)
  galerija[i].addEventListener('mouseleave', slikaNormalno) // slikaNormalno(this)
}
