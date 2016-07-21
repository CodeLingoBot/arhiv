function postaviMapu(gradovi) {

  var BASE_URL = "/damjan/";
  var jajce = new google.maps.LatLng(44.341667, 17.269444);
  var mostar = new google.maps.LatLng(43.333333, 17.8);
  var centar = window.innerWidth < 768 ? mostar : jajce;

  var stilMape = [{
    "featureType": "administrative",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "road",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "poi",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "landscape",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "transit",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "water",
    "elementType": "labels",
    "stylers": [{
      "visibility": "off"
    }]
  }, {
    "featureType": "water",
    "elementType": "geometry.fill",
    "stylers": [{
      "color": "#CCF0F6"
    }]
  }]; // stilMape

  var opcijeMape = {
    zoom: 7,
    minZoom: 6,
    maxZoom: 9,
    center: centar,
    scrollwheel: false,
    mapTypeControl: false,
    scaleControl: false,
    streetViewControl: false,
    overviewMapControl: false,
    panControl: true,
    panControlOptions: {
      position: google.maps.ControlPosition.RIGHT_TOP
    },
    zoomControl: true,
    zoomControlOptions: {
      position: google.maps.ControlPosition.RIGHT_TOP
    },
    mapTypeId: google.maps.MapTypeId.TERRAIN,
    types: ['(regions)'],
    styles: stilMape
  }; // opcije mape

  var mapa = new google.maps.Map(document.getElementById('mesto-za-mapu'), opcijeMape);
  var prozorce = new google.maps.InfoWindow();
  var marker;
  var i;

  for (i = 0; i < gradovi.length; i++) {
    var geografski_polozaj = new google.maps.LatLng(gradovi[i][2], gradovi[i][3]);
    // ako grad slobodan
    if (gradovi[i][4] == 1) {
      marker = new MarkerWithLabel({
        position: geografski_polozaj,
        map: mapa,
        title: gradovi[i][1],
        icon: {
          path: google.maps.SymbolPath.CIRCLE,
          scale: 4,
          strokeWeight: 2,
          fillOpacity: 1,
          strokeColor: '#FF0000',
          fillColor: '#FF0000'
        },
        labelContent: gradovi[i][1],
        labelClass: "nazivi", // CSS klasa za natpise
        labelStyle: {
          opacity: 0.75
        }
      });
      google.maps.event.addListener(marker, 'click', (otvoriProzorce)(marker, i));
      google.maps.event.addListener(mapa, 'click', (zatvoriProzorce)(marker, i));
    } // if slobodni
  } // for postavlja markere

  function otvoriProzorce(marker, i) {
    return function() {
      var naziv_grada = gradovi[i][1];
      var id_grada = gradovi[i][0];
      var url = BASE_URL + 'pojam.php?br=' + id_grada;
      var slika_src = BASE_URL + 'slike/ustanak.jpg';
      prozorce.setContent("<a href=" + url + " target='_blank'><h3>" + naziv_grada + " u oslobodilačkom ratu </h3><img src=" + slika_src + " width='200'></a>");
      prozorce.open(mapa, marker);
    };
  }

  function zatvoriProzorce(marker, i) {
    return function() {
      prozorce.close();
    };
  }

} // postaviMapu
