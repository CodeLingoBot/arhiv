var platno = $('#platno');
platno.width = platno.parentElement.offsetWidth;
platno.height = window.innerHeight;

var sadrzaj = platno.getContext('2d');
sadrzaj.font = "bold 16px Arial";
sadrzaj.fillText("Dokument se učitava...", platno.width/2-100, 100);

var datum_prikaz = $('#datum-prikaz');
if (datum_prikaz.innerText == "0000-00-00.") datum_prikaz.innerText = " nepoznat";

var opis = $('#opis');
opis.contentEditable = true;
var novi_opis = $('#novi_opis');

function promeniOpis(id, vrsta){
    novi_opis.value = opis.textContent || opis.innerText;
}

function isprazniPolje(){
    $('#tag').value = "";
}
