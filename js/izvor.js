/*** VARIJABLE ***/

var zum = 1;

var id = null;
var vrsta = null;
var drzac = null;
var ovajDokument = null;
var brojStrane = 1;

/*** DOGAĐAJI ***/

window.addEventListener('load', function () {
  id = citajUrl('br');
  vrsta = citajUrl('vrsta');

  if (vrsta == 2) {
    drzac = document.getElementById('pdf-drzac');
    brojStrane = Number($('#broj_strane').value);
    var fajl_url = $('#fajl_url').value;
    ucitajPDF(fajl_url);
  }
});

document.addEventListener('click', function (e) {
  var element = e.target;
  if (element.id == "azuriraj_opis") $('#novi_opis').value = opis.textContent || opis.innerText;

  if (element.classList.contains('js-idi-nazad')) okreniStranu(-1);
  if (element.classList.contains('js-idi-napred')) okreniStranu(1);
  if (element.classList.contains('js-zum')) zumiraj(0.1);
  if (element.classList.contains('js-odzum')) zumiraj(-0.1);

  if (element.id == 'izmeni-datum-fotografije') izmeniDatumFotografije(element.nextElementSibling, id, $("#datum").value);
  if (element.id == 'izmeni-datum-zasebno') {
    izmeniDatumZasebno(element.nextElementSibling, id, vrsta, $("#dan").value, $("#mesec").value, $("#godina").value);
  }
  if (element.id == 'promeni-oblast') promeniOblast(element.nextElementSibling, id, vrsta, $("#nova_oblast").value);
  if (element.id == 'promeni-pripadnost') promeniPripadnost(element.nextElementSibling, id, $("#nova_pripadnost").value);
  if (element.id == 'brisi-tag') pozadinskiBrisi(element.nextElementSibling, vrsta, element.value, id);
  if (element.id == 'dodaj-tag') {
    pozadinskiTaguj(element.nextElementSibling, vrsta, element.previousElementSibling.value, id);
    isprazniTag();
  }
});

/*** FUNKCIJE ***/

function ucitajPDF() {
  PDFJS.getDocument(fajl_url).then(function (pdf) {
    ovajDokument = pdf;
    renderujStranu();
  });
}

function renderujStranu() {
  azurirajStanje();
  ovajDokument.getPage(brojStrane).then(function (pdfStrana) {
    var vidno_polje = pdfStrana.getViewport(zum);
    var renderOpcije = {
      container: drzac,
      id: brojStrane,
      scale: zum,
      defaultViewport: vidno_polje,
      textLayerFactory: new PDFJS.DefaultTextLayerFactory(),
    };
    var pdfPrikaz = new PDFJS.PDFPageView(renderOpcije);
    pdfPrikaz.setPdfPage(pdfStrana);
    pdfPrikaz.draw();
  });
}

function azurirajStanje() {
  proverBrojStrane();
  azurirajPolja();
  brisiPrethodneStrane();
}

function proverBrojStrane() {
  if (brojStrane < 1) brojStrane = 1;
  if (brojStrane > ovajDokument.numPages) brojStrane = ovajDokument.numPages;
}
function azurirajPolja() {
  $('#trenutna_strana').textContent = brojStrane;
  $('#ukupno_strana').textContent = ovajDokument.numPages;
  $('#zum').textContent = zum.toFixed(1);
}

function brisiPrethodneStrane() {
  var strane = document.querySelectorAll('.page');
  for (var i = 0; i < strane.length; i++) {
    strane[i].remove();
  }
}

function okreniStranu(broj) {
  brojStrane += broj;
  renderujStranu();
}

function zumiraj(broj) {
  zum += broj;
  renderujStranu();
}

function isprazniTag() {
  $('#tag').value = "";
}
