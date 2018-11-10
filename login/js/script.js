$('form').submit(function(){
    var scroll_top = $(window).scrollTop();  //送信時の位置情報を取得
    $('input.st',this).prop('value',scroll_top);  //隠しフィールドに位置情報を設定
  });
   
  window.onload = function(){
    //ロード時に隠しフィールドから取得した値で位置をスクロール
    $(window).scrollTop(<?php echo @$_REQUEST['scroll_top']; ?>);
  }