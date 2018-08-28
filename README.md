[![](screen.png)](http://znaci.net/arhiv/)

# Arhiv Znaci

Baza dokumenata o drugom svetskom ratu na tlu Jugoslavije. Sadrži na stotine hiljada unosa.

Naslovna stranica prikazuje mapu oslobođenih gradova u okupiranoj Jugoslaviji na današnji dan.

Poseti: [znaci.net/arhiv](http://znaci.net/arhiv/)

## Razvoj

- Prekopiraj bazu `znaci` na lokalni mysql server
- Iskljuci strogi SQL mod, jer pucaju upiti bez podrazumevanih vrednosti
  - Proveri jel uključen: `SHOW VARIABLES LIKE 'sql_mode';`
  - Ako jeste isključi: `SET GLOBAL sql_mode='';`
- Prekopiraj sa produkcije fajlove `ukljuci/povezivanje2.php` i `ukljuci/povezivanje-staro.php` i unesi podatke za povezivanje sa lokalnom bazom
- Podesi naziv podomena u fajlu `ukljuci/config.php`
- Podesi naziv podomena u fajlu `js/main.js`
- Pokreni projekat preko lokalnog servera

### Menjanje CSS-a

Build proces za `CSS` se pokreće komandom:
```
npm install
npm start
```

CSS se potom edituje u `css/dev` folderu, i automatski se kompajlira (spajanje, minifikacija, autoprefiksi) u `css/dist`.

Ne možete editovati CSS direktno u `css/dist/style.css` fajlu.

### Pravljenje sličica

Za masovno pravljenje malih sličica (thumbnails), pokrenuti skriptu `admin/prevelicaj-slike.php` iz konzole.

Skripta smanjuje sve slike iz foldera `znaci.net/images` na visinu 200px i izvozi ih u `slike/smanjene`.

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

- css godine na naslovnoj
- azurira opis, datum, oblast i pripadnost prebaciti iz ukljuci u api
- vezati rezultate pretrage dokumenata na dokument.php
- odvojiti iste elemente sa index.php i odrednica.php

