$ = jQuery
var map

var markers = []

var currentInfoWin = null

var lonlatList = {
  'city_yokohama': [35.443972, 139.63825],
  'naka': [35.444722, 139.642139],
  'hodogaya': [35.459917, 139.596028],
  'minami': [35.431306, 139.608806],
  'totsuka': [35.396472, 139.532333],
  'asahi': [35.474667, 139.544778],
  'sakae': [35.364306, 139.554083],
  'izumi': [35.417861, 139.488722],
  'kohoku': [35.519, 139.633028],
  'konan': [35.400722, 139.591222],
  'seya': [35.466028, 139.498778],
  'isogo': [35.402333, 139.618333],
  'kanagawa': [35.477056, 139.629278],
  'midori': [35.512361, 139.538028],
  'nishi': [35.453639, 139.616917],
  'tsuzuki': [35.544778, 139.570722],
  'kanazawa': [35.337278, 139.6245],
  'aoba': [35.552778, 139.537],
  'tsurumi': [35.508306, 139.682417],
  'tobu': [35.46419354030555, 139.65347254276278],
  'nanbu': [35.38680400641701, 139.5880051851273],
  'hokubu': [35.53568119957754, 139.5425310134888],
  'seibu': [35.44507164054968, 139.5125600099564],
}

function mapInit (coordinate) {
  var area = location.href.split('?').pop().replace('project_area=', '')
  var zoom = 10
  if (area in lonlatList) {
    latlng = lonlatList[area]
    zoom = 13
  }
  var myOptions = {
    zoom: zoom,
    center: new google.maps.LatLng(coordinate.latitude, coordinate.longitude),

    mapTypeControl: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  }
  map = new google.maps.Map(document.getElementById('gmap'), myOptions)
}

function addMarker (latlng, content, type) {
  var icon_path = {
    'place': {
      url: '/wp-content/themes/localgood/images/pin_icon_spot@2x.png',
      size: new google.maps.Size(40, 58),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 58)
    },
    'event': {
      url: '/wp-content/themes/localgood/images/pin_icon_event@2x.png',
      size: new google.maps.Size(40, 58),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 58)
    },
    'subject': {
      url: '/wp-content/themes/localgood/images/pin_icon_subject@2x.png',
      size: new google.maps.Size(40, 58),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 58)
    }
  }

  var marker = new google.maps.Marker({
    map: map,
    position: latlng,
    icon: icon_path[type],
    animation: google.maps.Animation.DROP
  })
  var infowindow = new google.maps.InfoWindow({
    content: content,
    maxWidth: 200
  })
  google.maps.event.addListener(marker, 'click', function () {

    if (currentInfoWin) {
      currentInfoWin.close()
    }

    infowindow.open(map, marker)
    currentInfoWin = infowindow

  })
  markers.push(marker)
}

function parseMarkers () {
  var long = $(this).data('long')
  var lat = $(this).data('lat')
  var title = $(this).data('title')
  var href = $(this).data('href')
  var type = ($(this).data('type') !== undefined) ? $(this).data('type') : 'event'
  if (long && lat && title && href) {
    var latlng = {lat: parseFloat(lat), lng: parseFloat(long)}
    addMarker(latlng, '<a href="' + href + '">' + title + '</a>', type)
  }
}

function removeMarkers () {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null)
  }
}

$(function () {
  console.log($('#gmap').hasClass('default-close'));
  if (!$('#gmap').hasClass('default-close')) {
    $.getJSON('/wp-json/api/v1/apikeys',function(data){
      mapInit(data.googlemaps.coordinate)
      $('.event_box, .place_box, .article_box').each(parseMarkers)
    })
  }
  $('.knows_map__toggle_button').click(function () {
    var span = $(this).find('span')
    var text = span.text()
    var openText = '地図を開く'
    var closeText = '地図を閉じる'
    if (text == openText) {
      span.text(closeText)
      $(this).toggleClass('close')

      if ($('#gmap').html() !== '') {
        $('#gmap').show()
      } else {
        $('#gmap').show()
        console.log('initialize map');
        $.getJSON('/wp-json/api/v1/apikeys',function(data){
          mapInit(data.googlemaps.coordinate)
          $('.event_box, .place_box, .article_box').each(parseMarkers)
        })
      }

      if (getDeviceType() === 'pc') {
        $('.knowsMapFilter').css('display', 'flex')
      } else {
        $('.knowsMapFilter').css('display', 'block')
      }

    } else {
      span.text(openText)
      $(this).toggleClass('close')
      $('#gmap').hide()
      $('.knowsMapFilter').css('display', 'none')
    }
  })
  
  $('#f_news_area, #f_event_type').on('change', function (e) {
    $(this).closest('form').submit()
  })

  $('.select_theme button').on('click', function (e) {
    e.preventDefault()
    $(this).toggleClass('on')
    $(this).prev().click()
  })

  $('.togglePin').on('change', function (e) {
    removeMarkers()
    var selector = []
    $('.togglePin').each(function () {
      if ($(this).prop('checked')) {
        if ($(this).val() === 'event') {
          selector.push('.event_box')
        } else if ($(this).val() === 'place') {
          selector.push('.place_box')
        }
      }
    })
    if (selector.length) {
      $(selector.join(', ')).each(parseMarkers)
    }
  })
})
