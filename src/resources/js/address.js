/**
 *
 *  編集画面 郵便番号の入力を確認後、住所の上書きの確認
 *
 */
$(document).on('click', '#zip_btn', function () {
    //郵便番号が空欄
    if ($("#zip").val() == "" || $("#zip").val() == undefined) {
        Swal.fire('郵便番号がセットされていません', '', 'error');
    } else {
        //フォームにテキストが入っているかをtrueかfalseで返す
        var value = $('#address').val();
        // フォームにテキストが入っている場合の対応
        if (value) {
            Swal.fire({
                title: '住所を上書きしてよろしいですか？',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                // OKを押した場合
                if (result.value) {
                    //（zipを入力、、県の数字を入力される、住所も入力する。）
                    AjaxZip3.zip2addr('zip', '', 'pref_code', 'address');
                    //正しくない郵便番号
                    setTimeout(function () {
                        if ($("#address").val() == "" || $("#address").val() == undefined) {
                            Swal.fire('郵便番号が正しくありません', '', 'error');
                        }
                    }, 4000);
                }
            });
        } else {
            //（zipを入力、、県の数字を入力される、住所も入力する。）
            AjaxZip3.zip2addr('zip', '', 'pref_code', 'address');
            //正しくない郵便番号
            setTimeout(function () {
                if ($("#address").val() == "" || $("#address").val() == undefined) {
                    Swal.fire('郵便番号が正しくありません', '', 'error');
                }
            }, 4000);
        }
    }
});
