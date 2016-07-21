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
  ** centrirati mapu
  ** polozene slike puna sirina
  ** mozda jos jedan rukodrzac na vrhu
* naslovna
  ** upit za fotografije da prikazuje najblize datumu
  ** keširati naslovnu za svaki ceo dan
* pojam
  ** napraviti očiglednu pretragu
* izvor.php
  ** na izvoru napraviti dokument izdali editabilnim
  ** kada su druge knjige dokumenata, osim zbornika, ne prikazuje lepo naslov!
  ** krije .ulogovan css-om, napraviti da ne štampa ništa što ne treba ako nisi ulogovan
  ** kada ažurira opis ajaxom da ne osvežava stranu
* na tri mesta dodaje "u oslobodilačkom ratu, pojam, klasa pojam, svi pojmovi", prebaciti u bazu
  ** da se svi pojmovi vrste lokacija prikazuju "* u drugom svetskom ratu"
  ** prebaciti Istra u oslobodilačkom ratu da bude lokacija, ne tema, i preimenovati u Istra
* srediti galeriju
* dodati Avijacija u oslobodilačkom ratu (pilot, avion, zrakoplov, vazduhoplov, bombard...)

## Bagovi

* kad je prazna druga kolona, deformiše je
* neće script defer na izvor.php

## Optimizovati

* pojam.php
  ** odstampati inicijalne vrednosti podeoka, ostalo ajaxom
  ** odvojiti iste elemente sa index.php i pojam.php
