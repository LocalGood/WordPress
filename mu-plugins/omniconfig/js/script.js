jQuery(document).ready(function ($) {
  $('#configSection').tabs();

  $('.color-picker').spectrum({
    preferredFormat: "hex",
    showSelectionPalette: true,
    showInput:true,
    showInitial: true,
    chooseText: "OK",
    cancelText: "キャンセル",
    containerClassName: 'color-picker-window',
    palette:[]
  });

  $('.hce_navigation').find('a').click(function(e){
    e.preventDefault();
    var target = $(this).attr('href');
    $('.hce_navigation .isActive').removeClass('isActive');
    $(this).addClass('isActive');
    $(target).siblings('.hce_section').slideUp(300);
    setTimeout(function(){
      $(target).slideDown(400);
    },500);
  });

});

/**
 * HTMLエンティティの変換
 * @param text string 変換したい文字
 * @param proc 'encode'|'decode' 変換モード
 * @returns string 変換後の文字列
 * @link // http://qiita.com/ka215/items/ace36f55c3ad1297de81
 */
function htmlEntities( text, proc ) {
  var entities = [
    ['amp', '&'],
    ['apos', '\''],
    ['lt', '<'],
    ['gt', '>']
  ];

  for ( var i=0, max=entities.length; i<max; i++ ) {
    if ( 'encode' === proc ) {
      text = text.replace(new RegExp( entities[i][1], 'g' ), "&"+entities[i][0]+';' ).replace( '"', '&quot;' );
    } else {
      text = text.replace( '&quot;', '"' ).replace(new RegExp( '&'+entities[i][0]+';', 'g' ), entities[i][1] );
    }
  }
  return text;
}
