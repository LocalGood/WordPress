var map;

var markers = [];

function mapInit(data) {
    var myOptions = {
        zoom: parseFloat(data.googlemaps.default_zoom_level),
        center: new google.maps.LatLng(parseFloat(data.googlemaps.coordinate.latitude), parseFloat(data.googlemaps.coordinate.longitude)),
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('gmap'), myOptions);
}

function addMarker(latlng, content, type) {
  var icon_path = {
    'place': {
      url: '/wp-content/themes/localgood/images/pin_icon_spot@2x.png',
      size: new google.maps.Size(40,58),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(0,58)
    },
    'event': {
      url: '/wp-content/themes/localgood/images/pin_icon_event@2x.png',
      size: new google.maps.Size(40,58),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(0,58)
    }
  }


  var marker = new google.maps.Marker({
    map: map,
    position: latlng,
    icon: icon_path[type],
    animation: google.maps.Animation.DROP
  })
  if (content) {
    var infowindow = new google.maps.InfoWindow({
      content: content
    });
    google.maps.event.addListener(marker, 'click', function () {
      infowindow.open(map, marker);
    });
  }
  markers.push(marker);
}



$.getJSON('/wp-json/api/v1/apikeys', function (data) {
  mapInit(data)
  $gmap = $('#gmap')
  var long = $gmap.data('long');
  var lat = $gmap.data('lat');
  var title = $gmap.data('title')
  var type = ($gmap.data('type') !== undefined) ? $gmap.data('type') : 'default'
  if (long && lat) {
    var latlng = {lat: parseFloat(lat), lng: parseFloat(long)};
    addMarker(latlng, title, type);
    map.setCenter(new google.maps.LatLng(latlng.lat, latlng.lng));
  }
  google.maps.event.trigger($('#gmap')[0], 'resize');
})

$(function(){
  var exp = /(\b(https?):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
  $('.commentBody').each(function(){
    $(this).html($(this).html().replace(exp,"<a href='$1' target='_blank'>$1</a>"));
  })

})