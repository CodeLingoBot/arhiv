# znaci.net

Baza dokumenata o drugom svetskom ratu na tlu Jugoslavije

## Razvoj

### Keširanje

Na početku i kraju svakog fajla je potrebno uključiti pravljenje keša:

```php
// na samom početku fajla
include_once("ukljuci/kesh-pocinje.php");
// na samom kraju fajla
include_once("ukljuci/kesh-zavrsava.php");
```

## TODO
* napraviti očiglednu pretragu na stranici pojam
* popraviti login sistem
* na tri mesta dodaje "u oslobodilačkom ratu, pojam, klasa pojam, svi pojmovi", prebaciti u bazu
* spojiti stari i novi header, srediti galeriju
* dodati drzace za skrol
* napraviti keširanje na serveru
* izvor.php
  ** na izvoru napraviti dokument izdali editabilnim
  ** kada su druge knjige dokumenata, osim zbornika, ne prikazuje lepo naslov!
  ** krije .ulogovan css-om, napraviti da ne štampa ništa što ne treba ako nisi ulogovan
  ** kada ažurira opis ajaxom da ne osvežava stranu

## Bagovi

* neće defer na izvor.php

## Nekad

* pojam.php
  ** odstampati inicijalne vrednosti podeoka, ostalo ajaxom
  ** odvojiti iste elemente sa index i pojam
