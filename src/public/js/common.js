
/**
 * 削除処理
 * routeでdeleteを設定する場合にhiddenパラメータを追加する必要があるのでpostにすること
 * @param {*} event 
 * @param {string} url 
 * @param {type} target 
 * @param {*} method 
 */
function dataDelete(event, url, target, method) {

    //確認画面
    Swal.fire({
        title: "削除します。よろしいですか?",
        text: "",
        type: "warning",
        showCancelButton: true,
        dangerMode: true,
        focusCancel: true // 初期にカーソルを当てるボタンをキャンセルに設定します
    })
        .then((willDelete) => {
            if (willDelete.value) {
                //url,method変更
                changeAction(target, url, method);
            }
        });
}

/**
 * 確認メッセージを表示してデータを保存します
 * @param {*} target 
 * @param {*} url 
 * @param {*} method 
 * @param {*} message 
 */
function confirmAction(target, url, method, message = '削除します。よろしいですか？') {
    Swal.fire({
        title: message,
        text: '',
        type: 'warning',
        showCancelButton: true,
        dangerMode: true,
        focusCancel: true
    }).then((check) => {
        if (check.value) {
            changeAction(target, url, method);
        }
    });
}

/**
 * targetのmethodとURLを変更してsubmitします
 * @param {*} target 
 * @param {*} url 
 * @param {*} method 
 */
function changeAction(target, url, method) {
    $(target).get(0).action = url;
    $(target).get(0).method = method;
    $(target).submit();
}


/**
 * 保存ボタンを１回しか押せないようにします
 */
$(function () {
    $('#save-button').click(function () {
        $(this).prop('disabled', true); //ボタンを無効化する
        $(this).closest('form').submit(); //フォームを送信する
    });
});

