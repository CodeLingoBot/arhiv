/*** VARIJABLE ***/

var zoom = 1;
var id = null;
var vrsta = null;
var platno = null;
var podloga = null;
var pdf = null;
var trenutnaStrana = 0;

/*** DOGAĐAJI ***/

window.addEventListener('load', function () {

  id = citajUrl('br');
  vrsta = citajUrl('vrsta');
  platno = $('#platno');
  var pdfUrl = $('#pdfUrl').value;

  if (vrsta == 2) {
    platno.width = platno.parentElement.offsetWidth;
    platno.height = window.innerHeight;
    podloga = platno.getContext('2d');
    podloga.font = "bold 16px Arial";
    podloga.fillText("Dokument se učitava...", platno.width / 2 - 100, 100);
    trenutnaStrana = Number($('#trenutnaStrana').value);
    ucitajPDF(pdfUrl);
  }

}); // on load

document.addEventListener('click', function (e) {
  var element = e.target;

  if (element.id == "azuriraj_opis") {
    $('#novi_opis').value = opis.textContent || opis.innerText; // samo prebacuje u skriveni input
  }

  if (element.classList.contains('js-idi-nazad')) idiNazad();

  if (element.classList.contains('js-idi-napred')) idiNapred();

  if (element.id == 'izmeni-datum-fotografije') {
    izmeniDatumFotografije(element.nextElementSibling, id, $("#datum").value);
  }

  if (element.id == 'izmeni-datum-zasebno') {
    izmeniDatumZasebno(element.nextElementSibling, id, vrsta, $("#dan").value, $("#mesec").value, $("#godina").value);
  }

  if (element.id == 'promeni-oblast') {
    promeniOblast(element.nextElementSibling, id, vrsta, $("#nova_oblast").value);
  }

  if (element.id == 'promeni-pripadnost') {
    promeniPripadnost(element.nextElementSibling, id, $("#nova_pripadnost").value);
  }

  if (element.id == 'brisi-tag') {
    pozadinskiBrisi(element.nextElementSibling, vrsta, element.value, id);
  }

  if (element.id == 'dodaj-tag') {
    pozadinskiTaguj(element.nextElementSibling, vrsta, element.previousElementSibling.value, id);
    isprazniTag();
  }

}); // on click

/*** FUNKCIJE ***/

function ucitajPDF(pdfUrl) {
  PDFJS.disableWorker = true; // gasi workere zbog cross-origin greške
  // asinhrono downloaduje PDF kao ArrayBuffer
  PDFJS.getDocument(pdfUrl).then(function renderujPdf(pdf) {
    if (trenutnaStrana > pdf.numPages) trenutnaStrana = pdf.numPages;
    $('#trenutna_strana').textContent = trenutnaStrana;
    $('#ukupno_strana').textContent = pdf.numPages;
    pdf.getPage(trenutnaStrana).then(renderujStranu); // koristi promise da fetchuje stranu
  });
}

function renderujStranu(strana) {
  // prilagodjava se raspoloživoj širini
  var roditeljskaSirina = platno.parentElement.offsetWidth;
  var vidno_polje = strana.getViewport(roditeljskaSirina / strana.getViewport(zoom).width);
  platno.height = vidno_polje.height;
  platno.width = vidno_polje.width;
  // renderuje PDF stranu na platno
  var renderContext = {
    canvasContext: podloga,
    viewport: vidno_polje
  };
  strana.render(renderContext);
}

function idiNazad() {
  if (trenutnaStrana <= 1) return;
  trenutnaStrana--;
  renderujStranu(trenutnaStrana);
}

function idiNapred() {
  if (trenutnaStrana >= pdf.numPages) return;
  trenutnaStrana++;
  renderujStranu(trenutnaStrana);
}

function isprazniTag() {
  $('#tag').value = "";
}
