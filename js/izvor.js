/*** VARIJABLE ***/

var vrsta = citajUrl('vrsta');
var platno = $('#platno');
var sadrzaj = null;
var ovajDokument = null;
var fajl_url = null;
var brojStrane = null;

if (vrsta == 2) {
  platno.width = platno.parentElement.offsetWidth;
  platno.height = window.innerHeight;
  var sadrzaj = platno.getContext('2d');
  sadrzaj.font = "bold 16px Arial";
  sadrzaj.fillText("Dokument se učitava...", platno.width / 2 - 100, 100);

  var fajl_url = $('#fajl_url').value;
  var brojStrane = Number($('#brojStrane').value);
  // disable workers to avoid cross-origin issue
  PDFJS.disableWorker = true;
  // asinhrono downloaduje PDF kao ArrayBuffer
  PDFJS.getDocument(fajl_url).then(function getPdfHelloWorld(_pdfDoc) {
      ovajDokument = _pdfDoc;
      if (brojStrane > ovajDokument.numPages) brojStrane = ovajDokument.numPages;
      renderujStranu(brojStrane);
  });
}


/*** DOGAĐAJI ***/

$('#azuriraj_opis').addEventListener('click', function() {
    $('#novi_opis').value = opis.textContent || opis.innerText;
});

/*** FUNKCIJE ***/

function isprazniPolje() {
    $('#tag').value = "";
}

function renderujStranu(broj) {
    // koristi promise da fetchuje stranu
    ovajDokument.getPage(broj).then(function(strana) {
        // prilagodjava se raspoloživoj širini
        var roditeljskaSirina = platno.parentElement.offsetWidth;
        var viewport = strana.getViewport(roditeljskaSirina / strana.getViewport(1.0).width);
        platno.height = viewport.height;
        platno.width = viewport.width;
        // renderuje PDF stranu na platno
        var renderContext = {
            canvasContext: sadrzaj,
            viewport: viewport
        };
        strana.render(renderContext);
    });
    $('#trenutna_strana').textContent = brojStrane;
    $('#ukupno_strana').textContent = ovajDokument.numPages;
}

function idiNazad() {
    if (brojStrane <= 1) return;
    brojStrane--;
    renderujStranu(brojStrane);
}

function idiNapred() {
    if (brojStrane >= ovajDokument.numPages) return;
    brojStrane++;
    renderujStranu(brojStrane);
}
