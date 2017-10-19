$ = jQuery
$(function () {

  if ($('#subject_gmap').length > 0) {
    // 投稿画面google map

      $.getJSON('/wp-json/api/v1/apikeys',function(data){
        var map = new google.maps.Map(
          document.getElementById("subject_gmap"), {
            zoom: parseFloat(data.googlemaps.default_zoom_level),
            center: new google.maps.LatLng(parseFloat(data.googlemaps.coordinate.latitude), parseFloat(data.googlemaps.coordinate.longitude)),
            mapTypeId: google.maps.MapTypeId.ROADMAP
          }
        );

      var marker = null

      var _input_pos_lat = $('input#loc_position_lat')
      var _input_pos_lng = $('input#loc_position_lng')

      if (
        ( parseFloat(_input_pos_lat.val()) > 0 ) &&
        ( parseFloat(_input_pos_lng.val()) > 0 )
      ) {
        marker = setMarker(map, parseFloat(_input_pos_lat.val()),
          parseFloat(_input_pos_lng.val()), true)
        map.setCenter(new google.maps.LatLng(parseFloat(_input_pos_lat.val()),
          parseFloat(_input_pos_lng.val())))
      }

      google.maps.event.addListener(map, 'click', function (event) {
        console.log(event)
        var _latlng = event.latLng

        setLatlngtoInput(_latlng, 'input#loc_position_lat',
          'input#loc_position_lng')

        if (marker !== null) {
          marker.setPosition(_latlng)
          setLatlngtoInput(_latlng, 'input#loc_position_lat',
            'input#loc_position_lng')
        } else {
          marker = setMarker(map, _latlng.k, _latlng.B, true)
          marker.setPosition(_latlng)
        }
      })
    })

  } else if ($('#preview_gmap').length > 0) {
    // 確認画面google map

    var prev_gmap = $('#preview_gmap')
    var platlng = prev_gmap.data('lonlat').split(',')

    var map = new google.maps.Map(
      prev_gmap[0], {
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
      }
    )

    if (( parseFloat(platlng[0]) > 0 ) && ( parseFloat(platlng[1]) > 1 )) {
      setMarker(map, parseFloat(platlng[0]), parseFloat(platlng[1]), false)
      map.setCenter(
        new google.maps.LatLng(parseFloat(platlng[0]), parseFloat(platlng[1])))
    } else {
      map.setCenter(new google.maps.LatLng(35.443972, 139.63825))
    }

  }

  $('.template_panel').css({'display': 'none'})
  $('.template_select_button').click(function () {
    $('.template_panel').css({'display': 'block'})
    $('.popup_bk').css({'display': 'block'})
  })

  $('.template_panel .close_button').click(function () {
    $('.template_panel').css({'display': 'none'})
    $('.popup_bk').css({'display': 'none'})
  })

  $('.template_panel button').on('click', function (e) {
    e.preventDefault()
    $('#subject_content').text($(this).text())
    $('.template_panel').css({'display': 'none'})
  })

})