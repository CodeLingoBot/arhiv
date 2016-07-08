function postaviMapu(gradovi) {

  var opcijeMape = {
    zoom: 7,
    minZoom: 6,
    maxZoom: 9,
    center: new google.maps.LatLng(43.8, 18.5),
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
    styles: [{
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
    }]
  }; // kraj opcija mape

  var mapa = new google.maps.Map(document.getElementById('mesto-za-mapu'), opcijeMape);
  var prozorce = new google.maps.InfoWindow();
  var marker;
  var i;

  for (i = 0; i < gradovi.length; i++) {
    var geografski_polozaj = new google.maps.LatLng(gradovi[i][2], gradovi[i][3]);
    // ako je grad slobodan
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

      // otvara prozorce na klik
      google.maps.event.addListener(marker, 'click', (function (marker, i) {
        return function () {
          var naziv_grada = gradovi[i][1];
          var id_grada = gradovi[i][0];
          var url = 'pojam.php?br=' + id_grada;
          prozorce.setContent("<a href=" + url + " target='_blank'><h3>" + naziv_grada + " u oslobodilačkom ratu </h3><img src='slike/ustanak.jpg' width='200'></a>");
          prozorce.setPosition(geografski_polozaj); // ne radi
          prozorce.open(mapa, marker);
        };
      })(marker, i));

      // zatvara prozorcice
      google.maps.event.addListener(mapa, 'click', (function (marker, i) {
        return function () {
          prozorce.close();
        };
      })(marker, i));

    } // if slobodni

  } // for postavlja markere

} // postaviMapu
