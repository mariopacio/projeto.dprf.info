function $map(element) {
  return document.getElementById(element);
}

var speedTest = {};

speedTest.pics = null;
speedTest.map = null;
speedTest.markerClusterer = null;
speedTest.markers = [];
speedTest.infoWindow = null;

speedTest.init = function() {

  var commaPos = lat_long_padrao.indexOf(',');
  var coordinatesLat = parseFloat(lat_long_padrao.substring(0, commaPos));
  var coordinatesLong = parseFloat(lat_long_padrao.substring(commaPos + 1, lat_long_padrao.length));

  var latlng = new google.maps.LatLng(coordinatesLat, coordinatesLong);
  var options = {
    'zoom': zoom_mapa,
    'minZoom' : 4,
    'maxZoom' : 16,
    'center': latlng,
    'mapTypeId': google.maps.MapTypeId.ROADMAP,
    'panControl' : false,
    noClear: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.MEDIUM,
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    streetViewControl: true,
    streetViewControlOptions: {
        position: google.maps.ControlPosition.RIGHT_TOP
    },
	styles: GoogleMapsStyle
  };

  if(lat_long_padrao != null)
  speedTest.map = new google.maps.Map($map('map'), options);
  
  google.maps.event.addDomListener(window, "resize", function() {
        var center = speedTest.map.getCenter();
        google.maps.event.trigger(speedTest.map, "resize");
        speedTest.map.setCenter(center);
  });
  
  speedTest.locais = data.locais;
  speedTest.total = data.count;
 
  speedTest.infoWindow = new google.maps.InfoWindow();
  speedTest.showMarkers();

};

speedTest.showMarkers = function() {
  speedTest.markers = [];

  var type = 0;

  if (speedTest.markerClusterer) {
    speedTest.markerClusterer.clearMarkers();
  }

  var numMarkers = speedTest.total;

  for (var i = 0; i < numMarkers; i++) {

    var latLng = new google.maps.LatLng(speedTest.locais[i].lat, speedTest.locais[i].lon);
    
    // Icone do google: http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=FFFFFF,008CFF,000000&ext=.png
    var imageUrl = 'http://infodprf.com/m1.png';
    var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(53, 52));
    var marker = new google.maps.Marker({
      'position': latLng,
      'icon': markerImage
    });

    //var fn = speedTest.markerClickFunction(speedTest.locais[i], latLng);
    //google.maps.event.addListener(marker, 'click', fn);
    
    speedTest.markers.push(marker);

  }

  window.setTimeout(speedTest.time, 0);
};

speedTest.markerClickFunction = function(local, latlng) {
  return function(e) {
    e.cancelBubble = true;
    e.returnValue = false;
    if (e.stopPropagation) {
      e.stopPropagation();
      e.preventDefault();
    }

    //var id = local.ID;

    var infoHtml = 
      '<div class="info">KM ' +
            '<div class="info-body">' +
            'Teste</div>' +
            '<br/>' +
      '</div>';

    speedTest.infoWindow.setContent(infoHtml);
    speedTest.infoWindow.setPosition(latlng);
    speedTest.infoWindow.open(speedTest.map);
  };
};

speedTest.change = function() {
  speedTest.clear();
  speedTest.showMarkers();
};

speedTest.time = function() {
  speedTest.markerClusterer = new MarkerClusterer(speedTest.map, speedTest.markers);  
};