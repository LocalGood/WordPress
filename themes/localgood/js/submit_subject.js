$ = jQuery;

function setLatlngtoInput(_latLng, _elem_lat, _elem_lng) {
    var elem_lat = $(_elem_lat);
    var elem_lng = $(_elem_lng);
    if (_latLng !== null) {
        elem_lat.val(_latLng.lat());
        elem_lng.val(_latLng.lng());
    } else {
        elem_lat.val(0);
        elem_lng.val(0);
    }
}

function setMarker(_map, _lat, _lng, _draggable) {
    _marker = new google.maps.Marker({
        position: new google.maps.LatLng(_lat, _lng),
        draggable: _draggable,
        map: _map,
        icon: "../wp-content/themes/localgood/images/map_pin.png"
    });
    google.maps.event.addListener(_marker, "dragend", function (event) {
        setLatlngtoInput(event.latLng, 'input#loc_position_lat', 'input#loc_position_lng');
    });
    return _marker;
}

$(function () {

    if ($('#subject_gmap').length > 0) {
        // 投稿画面google map

      $.getJSON('/wp-json/api/v1/apikeys',function(data){
        var map = new google.maps.Map(
          document.getElementById("subject_gmap"), {
            zoom: 13,
            center: new google.maps.LatLng(parseFloat(data.coordinate.latitude), parseFloat(data.coordinate.longitude)),
            mapTypeId: google.maps.MapTypeId.ROADMAP
          }
        );

        var marker = null;

        var _input_pos_lat = $('input#loc_position_lat');
        var _input_pos_lng = $('input#loc_position_lng');

        if (
          ( parseFloat(_input_pos_lat.val()) > 0 ) &&
          ( parseFloat(_input_pos_lng.val()) > 0 )
        ) {
          marker = setMarker(map, parseFloat(_input_pos_lat.val()), parseFloat(_input_pos_lng.val()), true);
          map.setCenter(new google.maps.LatLng(parseFloat(_input_pos_lat.val()), parseFloat(_input_pos_lng.val())));
        }

        google.maps.event.addListener(map, "click", function (event) {
          var _latlng = event.latLng;

          setLatlngtoInput(_latlng, 'input#loc_position_lat', 'input#loc_position_lng');

          if (marker !== null) {
            marker.setPosition(_latlng);
            setLatlngtoInput(_latlng, 'input#loc_position_lat', 'input#loc_position_lng');
          } else {
            marker = setMarker(map, _latlng.k, _latlng.B, true);
            marker.setPosition(_latlng);
          }
        });
      })


    } else if ($('#preview_gmap').length > 0) {
        // 確認画面google map

        var prev_gmap = $('#preview_gmap');
        var platlng = prev_gmap.data('lonlat').split(',');

        var map = new google.maps.Map(
            prev_gmap[0], {
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        );

        if (( parseFloat(platlng[0]) > 0 ) && ( parseFloat(platlng[1]) > 1 )) {
            setMarker(map, parseFloat(platlng[0]), parseFloat(platlng[1]), false);
            map.setCenter(new google.maps.LatLng(parseFloat(platlng[0]), parseFloat(platlng[1])));
        } else {
            map.setCenter(new google.maps.LatLng(35.443972, 139.63825));
        }

    }

    // Validation, Input check
    $("button.submit[name='stage']").on('click',
        function (e) {

            var _valid = true;

            $('.invalid').remove();

            var _subject = $('textarea#subject_content');
            var _ward = $('select#loc_wards');

            if (_subject.length > 0 && _ward.length > 0) {

                if (_subject[0].value.length <= 0) {
                    _subject.before('<p class="invalid">課題の内容は入力必須です</p>');
                    _valid = false;
                }

                if (_ward.val() == '') {
                    _ward.after('<span class="invalid inline">地域の指定は必須です</span>');
                    _valid = false;
                }
            }

            return _valid;
        }
    );

    //when click, display description all
    $('a.continue').click(function () {
        $(this).css({
            'display': 'none'
        });
        $('.subject_description').css({
            'max-height': 'none',
            'overflow': 'visible'
        });
    });

    $('.select_theme__wrapper button').on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('on');
        $(this).prev().click();
    });

    $('.template_panel button').on('click', function(e){
        e.preventDefault();
        $('#subject_content').text($(this).text());
        $('#template_panel__wrapper').removeClass('view');
    })
});