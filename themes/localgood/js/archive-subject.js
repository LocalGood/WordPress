$ = jQuery

// for IE couldn't recoginize window.location property
if (!window.location.origin) {
  window.location.origin = window.location.protocol + '//' + window.location.hostname + (window.location.port ? ':' + window.location.port : '')
}

function openInfoWindow (_map, _now_marker, pInfo) {
  var _content = ''

  // tweetの場合はハッシュタグとURL自動リンク
  if (pInfo[6] == 'tweet') {
    var _tmp = pInfo[2].replace(/(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/, '<a target="_blank" href="$1$2">$1$2</a>')
    _tmp = _tmp.replace(/\s#(w*[一-龠_ぁ-ん_ァ-ヴーａ-ｚＡ-Ｚa-zA-Z0-9]+|[a-zA-Z0-9_]+|[a-zA-Z0-9_]w*)/, ' <a href="https://twitter.com/search/%23$1" target="twitter">#$1</a>')
    _content = '<p>' + _tmp + '</p>'
  } else {
    _content = '<p><a href="' + pInfo[1] + '" target="_blank">' + pInfo[2] + '</a></p>'
  }

  var contentStr = '<div id="subject_point">' +
    _content +
    '<p class="sub_pic"><a href="' + pInfo[1] + '" target="_blank">' + pInfo[3] + '</a></p>'
  contentStr += '</div>'

  var info_window = new google.maps.InfoWindow({content: contentStr})
  info_window.open(_map, _now_marker)
  return info_window
}

// AJAX map load
function ajaxMapLoad (map, marker, iw_stat) {

  $.ajax({
    // 別ページでAPIを叩いてjsonを吐かせている
    url: location.origin + '/wp-json/api/v1/get-subjects',
    type: 'get',
    headers: {
      'X-LocalGood-UA': 'iOS',
      'X-LocalGood-AuthKey': 'jMCYynSCuxe4WH2NmjhKpcELpXNzZ24BjPsQZp9wL4t8bsupbJYmb4TFPyffFapK',
    },
    dataType: 'json',
    success: function (json) {
      // マーカー配置
      $.each(
        json,
        function (i) {
          var post_info = this
          var _id = post_info[6]
          var post_loc = new google.maps.LatLng(post_info[4], post_info[5])
          var mopt = {
            position: post_loc,
            map: map,
            title: post_info[0],
            id: i,
          }

          // マーカー色変更
          if (_id == 'tweet') {
            mopt.icon = {
              path: google.maps.SymbolPath.CIRCLE,
              fillColor: '#444',
              strokeColor: '#55acee',
              fillOpacity: 1,
              scale: 7,
            }
          }

          marker[i] = new google.maps.Marker(mopt)

          // インフォウィンドウ、クリックイベント
          var listener = google.maps.event.addListener(marker[i], 'click', function () {
            if (iw_stat) {
              iw_stat.close()
            }
            iw_stat = openInfoWindow(map, marker[i], post_info)
          })
        })
    }
  })
}

$(function () {
  if (!$('#gmap').html()) {
    $.getJSON('/wp-json/api/v1/apikeys', function (data) {
      // マップオプション
      var mapOpt = {
        zoom: parseFloat(data.googlemaps.default_zoom_level),
        // omniconfigの設定値から中心位置を決定
        center: new google.maps.LatLng(parseFloat(data.googlemaps.coordinate.latitude), parseFloat(data.googlemaps.coordinate.longitude)),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
      }
      var map = new google.maps.Map(document.getElementById('gmap'), mapOpt)
      var marker = []
      var iw_stat = null
      ajaxMapLoad(map, marker, iw_stat, '')
    })
  }

  $('.select_theme button').on('click', function (e) {
    e.preventDefault()
    $(this).toggleClass('on')
    $(this).prev().click()
  })

  $('.knows_map__toggle_button').click(function () {
    var span = $(this).find('span')
    var text = span.text()
    var openText = '地図を開く'
    var closeText = '地図を閉じる'
    if (text == openText) {
      span.text(closeText)
      $(this).toggleClass('close')
      $('#gmap').show()
    } else {
      span.text(openText)
      $(this).toggleClass('close')
      $('#gmap').hide()
      $('.knowsMapFilter').css('display', 'none')
    }
  })

})
