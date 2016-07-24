# znaci.net

Baza dokumenata o drugom svetskom ratu na tlu Jugoslavije

- [Razvoj](#razvoj)
  - [CSS development](#css-development)
  - [PHP Keširanje](#php-ke%C5%A1iranje)
- [TODO](#todo)
- [Bagovi](#bagovi)
- [Optimizovati](#optimizovati)

## Razvoj

### CSS razvoj

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

Podrazumevano keš traje 7 dana ali se pre uključenja zaglavlja može podesiti varijabla `$kesh_trajanje`. Npr, keš na naslovnoj strani traje do isteka dana. Neke admin stranice i stranice za ulogovane korisnike se ne keširaju.

Tutorijal za keširanje pročitaj [ovde](https://www.sanwebe.com/2013/09/php-cache-dynamic-pages-speed-up-load-times).

## TODO
* izvor.php
  * kada ažurira opis da ne osvežava stranu
  * refaktorisati ajaxe (+ ukinuti prazan span)
  * učiniti pdf editabilnim
* na tri mesta dodaje "u oslobodilačkom ratu, pojam, klasa pojam, svi pojmovi", prebaciti u bazu
  * da se svi pojmovi vrste lokacija prikazuju "* u drugom svetskom ratu"
  * prebaciti Istra u oslobodilačkom ratu da bude lokacija, ne tema, i preimenovati u Istra
* srediti galeriju
* naslovna
  * upit za fotografije da prikazuje najblize datumu
* admin
  * malo uputstvo za upotrebu
* arhitektura
  * razdvojiti klasu izvor na podklase (fotografija, dokument i zapis), takođe stranicu izvor.php
  * ukloniti sve sql pozive iz htmla
  * azurira-datum, oblast i pripadnost iz ukljuci u api
  * umesto praznog spana apendovati element

## Bagovi
* izvor.php
  * neće script defer na izvor.php
  * kada su druge knjige dokumenata, osim zbornika, ne prikazuje lepo naslov!

## Optimizovati

* pojam.php
  * odstampati inicijalne vrednosti podeoka, ostalo ajaxom
  * odvojiti iste elemente sa index.php i pojam.php
