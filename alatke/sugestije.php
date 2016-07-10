<meta charset="UTF-8">
<title>Sugestije</title>

<style>
.sugestije-okvir {
    display: inline-block;
}

#lista_predloga {
    margin: 0;
    padding: 0;
    list-style: none;
    display: none;
}

.sugestije-okvir:hover #lista_predloga {
    display: block;
    position: absolute;
}

.predlozi {
    display: block;
    position: relative;
    border-top: 1px solid #ffffff;
    padding: 5px;
	background: rgb(250,250,250);
    margin-left: 1px;
    white-space: nowrap;
}
.predlozi:hover {
	background: #eee;
}
.nevidljiv {
	display:none;
}
</style>
	
<?php

	$tag = $_POST['tag'];
	$broj_entia = $_POST['br_oznake'];

?>
	<form method="post" action="<?php $_SERVER[PHP_SELF]; ?>">

		Izaberi oznaku: <div class="sugestije-okvir">
			<input name="tag" id="tag" onkeyup="pokaziSugestije(this.value)" autocomplete="off" value="<?php echo $tag; ?>">
			
			<div id="polje_za_sugestije"></div>
		</div>

		<span>id oznake</span><input name="br_oznake" id="br_oznake" type="number" value="<?php echo $broj_entia; ?>">
		
	</form>

<script>
var polje_za_sugestije = document.getElementById("polje_za_sugestije");
var tag = document.getElementById("tag");
var lista_predloga = document.getElementById("lista_predloga");
var br_oznake = document.getElementById("br_oznake");

function pokaziSugestije(unos) {
	var ajax = new XMLHttpRequest();
	if (unos.length > 1) {
		polje_za_sugestije.style.display = "block";
		
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				polje_za_sugestije.innerHTML = ajax.responseText;
			}
		}
		ajax.open("GET", "sugestije-sve.php?pocetno="+unos, true);
		ajax.send();
	}
}

function izaberiOznaku(izabrano) {
	tag.value = izabrano.innerHTML;
	br_oznake.value = izabrano.nextSibling.innerHTML;
	polje_za_sugestije.style.display = "none";
}
</script>