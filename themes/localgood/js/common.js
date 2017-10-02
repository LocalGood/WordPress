//閲覧端末判定
//iPadもAndroidタブレットもPC扱い。
function getDeviceType() {
  var ua = window.navigator.userAgent;
  if (ua.match(/iPod|iPhone/i)) {
    return 'sp';
  } else if (ua.match(/Android.+Mobile/i)) {
    return 'sp';
  } else {
    return 'pc'
  }
}

