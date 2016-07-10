var platno = $('#platno');
platno.width = platno.parentElement.offsetWidth;
platno.height = window.innerHeight;

var sadrzaj = platno.getContext('2d');
sadrzaj.font = "bold 16px Arial";
sadrzaj.fillText("Dokument se učitava...", platno.width / 2 - 100, 100);

$('#azuriraj_opis').addEventListener('click', function() {
    // samo menja vrednost polja, forma šalje post
    $('#novi_opis').value = opis.textContent || opis.innerText;
});

$('#izmeni_datum').addEventListener('click', function(e) {
    var id = izvuciUrlVarijablu('br');
    var vrsta = izvuciUrlVarijablu('vrsta');
    izmeniDatum(e.target, id, vrsta);
});

function isprazniPolje() {
    $('#tag').value = "";
}


// if($vrsta == 2), samo za dokumente treba pdf.js
var fajl_url = $('#fajl_url').value;
var brojStrane = Number($('#brojStrane').value);

// disable workers to avoid cross-origin issue
PDFJS.disableWorker = true;
var ovajDokument = null;

function renderujStranu(broj) {
    // koristi promise da fetchuje stranu
    ovajDokument.getPage(broj).then(function(strana) {
        // proporcionalno prilagodjava raspoloživoj širini
        var roditeljskaSirina = platno.parentElement.offsetWidth;
        var viewport = strana.getViewport(roditeljskaSirina / strana.getViewport(1.0).width);
        platno.height = viewport.height;
        platno.width = viewport.width;
        // renderuje PDF stranu u sadrzaj platna
        var renderContext = {
            canvasContext: sadrzaj,
            viewport: viewport
        };
        strana.render(renderContext);
    });
    document.getElementById('trenutna_strana').textContent = brojStrane;
    document.getElementById('ukupno_strana').textContent = ovajDokument.numPages;
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

// asinhrono downloaduje PDF kao ArrayBuffer
PDFJS.getDocument(fajl_url).then(function getPdfHelloWorld(_pdfDoc) {
    ovajDokument = _pdfDoc;
    if (brojStrane > ovajDokument.numPages) brojStrane = ovajDokument.numPages;
    renderujStranu(brojStrane);
});
