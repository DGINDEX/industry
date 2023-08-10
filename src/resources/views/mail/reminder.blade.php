<html>

<body>
    {{ $params['user_name'] }}&nbsp;様<br>
    <br>
    パスワード再設定の為、以下のURLにアクセスしてパスワードの再設定を行って下さい。<br>
    URL:{{ $params['url'] }}<br>
    ※パスワード再設定リンクの有効期限は{{ config('const.reminder.expiration_hour_mail') }}時間です。<br>
    <br>
    本メールは送信専用です。<br>
    お問合せは以下よりお願いいたします。<br>
    <br>
    <br>
    ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br>
    {{config('const.copyright')}}<br>
    〒524-0021<br>
    滋賀県守山市吉身三丁目11番43号<br>
    TEL：077-582-2425<br>
    FAX：077-582-1551<br>
    ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br>
</body>

</html>
