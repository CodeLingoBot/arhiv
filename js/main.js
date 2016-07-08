window.$ = function(selektor) {
  return document.querySelector(selektor);
};

/*** EVENTS ***/

var izaberiPojam = $("#izaberi-pojam");
izaberiPojam.addEventListener("click", function () {
  otvoriStranu();
});

/*** FUNCTIONS ***/

function otvoriStranu() {
  var br_oznake = document.getElementById("br_oznake").value;
  window.open("http://znaci.net/damjan/pojam.php?br=" + br_oznake, "_self");
}
