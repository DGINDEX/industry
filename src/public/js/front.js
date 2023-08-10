
//企業詳細画面の拡大画像を切り替える
function changeImage(src, alt) {
    $('#zoom-img').attr('src', src);
    $('#zoom-img').attr('alt', alt);
    $("#image-text").html(alt.replace(/\r|\n|\r\n/g, '<br>'));
    if (alt == null || alt == ''){
        $(".image-comment").addClass("no-display");
    }else{
        $(".image-comment").removeClass("no-display");
    }
}

//スマホのヘッダーメニューを開くボタンクリック時
$("#menuBtn").click(function () {
    $("#index").toggleClass("menu-open");
});

function setFadeElement() {

    var windowH = $(window).height(); //ウィンドウの高さを取得
    var scroll = $(window).scrollTop(); //スクロール値を取得

    //出現範囲の指定
    var contentsTop = 1300;

    //出現範囲内に入ったかどうかをチェック
    if (scroll + windowH >= contentsTop) {
        $("#page-top").addClass("UpMove");    //入っていたらUpMoveをクラス追加
        $("#page-top").removeClass("DownMove");   //DownMoveを削除
        $(".hide-btn").removeClass("hide-btn");   //hide-btnを削除
    } else {
        if (!$(".hide-btn").length) {       //サイト表示時にDownMoveクラスを一瞬付与させないためのクラス付け。hide-btnがなければ下記の動作を行う
            $("#page-top").addClass("DownMove");  //DownMoveをクラス追加
            $("#page-top").removeClass("UpMove"); //UpMoveを削除 
        }
    }
}

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
    setFadeElement();/* スクロールした際の動きの関数を呼ぶ*/
});

// ページが読み込まれたらすぐに動かしたい場合の記述
$(window).on('load', function () {
    setFadeElement();/* スクロールした際の動きの関数を呼ぶ*/
});


// #page-topをクリックした際の設定
$('#page-top').click(function () {
    $('body,html').animate({
        scrollTop: 0//ページトップまでスクロール
    }, 500);//ページトップスクロールの速さ。数字が大きいほど遅くなる
    return false;//リンク自体の無効化
});