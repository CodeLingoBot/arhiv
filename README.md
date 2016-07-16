# znaci.net

Baza dokumenata o drugom svetskom ratu na tlu Jugoslavije

## Razvoj

### Keširanje

Tutorijal za keširanje: https://www.sanwebe.com/2013/09/php-cache-dynamic-pages-speed-up-load-times

Na početku i kraju svakog fajla je potrebno uključiti pravljenje keša:

```php
// na samom početku fajla
include_once("ukljuci/kesh-pocinje.php");
// na samom kraju fajla
include_once("ukljuci/kesh-zavrsava.php");
```

## TODO
* mobilni prikaz
  ** dodati drzace za skrol na index i pojam
  ** dodati burger meni
* naslovna
  ** upit poziva samo fotografije bez meseca i dana
  ** $upit_fotografije = "SELECT * FROM fotografije WHERE datum='$godina-00-00' ORDER BY RAND() LIMIT 20";
* napraviti očiglednu pretragu na stranici pojam
* na tri mesta dodaje "u oslobodilačkom ratu, pojam, klasa pojam, svi pojmovi", prebaciti u bazu
* srediti galeriju
* izvor.php
  ** na izvoru napraviti dokument izdali editabilnim
  ** kada su druge knjige dokumenata, osim zbornika, ne prikazuje lepo naslov!
  ** krije .ulogovan css-om, napraviti da ne štampa ništa što ne treba ako nisi ulogovan
  ** kada ažurira opis ajaxom da ne osvežava stranu

## Bagovi

* kad je prazna druga kolona, deformiše je
* neće script defer na izvor.php

## Optimizovati

* pojam.php
  ** odstampati inicijalne vrednosti podeoka, ostalo ajaxom
  ** odvojiti iste elemente sa index.php i pojam.php
