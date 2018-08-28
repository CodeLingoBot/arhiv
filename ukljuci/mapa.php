<div class="drzac-mape relative">
  <div class="hide-lg kruzic prstodrzac prstodrzac-dole"></div>
  <div class="hide-lg prstodrzac polukrug-levo"></div>
  <div class="hide-lg prstodrzac polukrug-desno"></div>

  <iframe class="mapa-frejm" name="mapa-frejm" scrolling="no" src="ukljuci/slobodni-gradovi.php?godina=<?php echo $datum->godina;?>&mesec=<?php echo $datum->mesec;?>&dan=<?php echo $datum->dan;?>"></iframe>

  <form class="mali-formular" method="get" action="index.php">
    <p class="legenda">
      <span class="legenda-kruzic"></span><span> Slobodni gradovi</span>
    </p>
    <table>
      <tr>
        <td><strong>Izaberi datum</strong></td>
      </tr>
      <tr>
        <td>Godina: </td>
        <td><input id="godina" name="godina" type="number" min="1941" max="1945" value="<?php echo $godina; ?>" class="unos-sirina"></td>
      </tr>
      <tr>
        <td>Mesec: </td>
        <td><input id="mesec" name="mesec" type="number" min="1" max="12" value="<?php echo $mesec; ?>" class="unos-sirina"></td>
      </tr>
      <tr>
        <td>Dan: </td>
        <td><input id="dan" name="dan" type="number" min="1" max="31" value="<?php echo $dan; ?>" class="unos-sirina"></td>
      </tr>
    </table>
    <button type="submit">Prikaži</button>
  </form>
</div>