# znaci.net

Baza dokumenata o drugom svetskom ratu na tlu Jugoslavije

## Razvoj

### CSS development

Postoji build proces za `CSS` koji se pokreće komandom:
```
npm start
```

CSS se potom edituje u `css/dev` folderu, i automatski se kompajlira (spajanje, minifikacija, autoprefiksi) u `css/dist`.

Ne možete editovati CSS direktno u `css/dist/style.css` fajlu.

### PHP Keširanje

Na početku i kraju svakog fajla (u zaglavlju i podnožju) je uključeno pravljenje keša:

```php
// na samom početku
include_once("ukljuci/kesh-pocinje.php");
// na samom kraju
include_once("ukljuci/kesh-zavrsava.php");
```

Podrazumevano keš traje 1 čas ali se pre uključenja zaglavlja može podesiti varijabla `$kesh_trajanje`. Npr, ona je na strani `pojam.php` 604800 sekundi, odnosno 7 dana. Neke admin stranice i stranice za ulogovane korisnike se ne keširaju.

Tutorijal za keširanje: https://www.sanwebe.com/2013/09/php-cache-dynamic-pages-speed-up-load-times

## TODO
* naslovna
  * keširati naslovnu za svaki ceo dan
  * upit za fotografije da prikazuje najblize datumu
* pojam
  * napraviti očiglednu pretragu
* izvor.php
  * na izvoru napraviti dokument izdali editabilnim
  * kada su druge knjige dokumenata, osim zbornika, ne prikazuje lepo naslov!
  * krije .ulogovan css-om, napraviti da ne štampa ništa što ne treba ako nisi ulogovan
  * kada ažurira opis ajaxom da ne osvežava stranu
* na tri mesta dodaje "u oslobodilačkom ratu, pojam, klasa pojam, svi pojmovi", prebaciti u bazu
  * da se svi pojmovi vrste lokacija prikazuju "* u drugom svetskom ratu"
  * prebaciti Istra u oslobodilačkom ratu da bude lokacija, ne tema, i preimenovati u Istra
* srediti galeriju
* dodati Avijacija u oslobodilačkom ratu (pilot, avion, zrakoplov, vazduhoplov, bombard...)

## Bagovi

* neće script defer na izvor.php

## Optimizovati

* pojam.php
  * odstampati inicijalne vrednosti podeoka, ostalo ajaxom
  * odvojiti iste elemente sa index.php i pojam.php
