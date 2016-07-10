var platno = document.getElementById('platno');
var sadrzaj = platno.getContext('2d');
platno.width = platno.parentElement.offsetWidth;
platno.height = window.innerHeight;

sadrzaj.font = "bold 16px Arial";
// sadrzaj.fillText("Dokument se učitava...", platno.width/2-100, 100);

var datum_prikaz = document.getElementById('datum-prikaz');
if (datum_prikaz.innerText == "0000-00-00.") datum_prikaz.innerText = " nepoznat";

var opis = document.getElementById('opis');
opis.contentEditable = true;
var novi_opis = document.getElementById('novi_opis');

function promeniOpis(id, vrsta){
    novi_opis.value = opis.textContent || opis.innerText;
}

function isprazniPolje(){
    document.getElementById('tag').value = "";
}
