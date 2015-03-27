<?php
require_once("ukljuci/config.php");
include_once(ROOT_PATH . 'ukljuci/zaglavlje.php');
?>

<script>
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight = document.getElementById(id).contentWindow.document.body.scrollHeight;
        newwidth = document.getElementById(id).contentWindow.document.body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
</script>


	<iframe src="http://znaci.net" width="100%" height="200%" id="iframe1" marginheight="0" frameborder="0" onLoad="autoResize('iframe1');"></iframe>


<?php include_once(ROOT_PATH . "ukljuci/podnozje.php"); ?>
