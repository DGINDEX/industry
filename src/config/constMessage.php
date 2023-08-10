<?php

//
// 各種定数定義
// 使用方法
// phpファイル内 : config('constMessage.xxxx.tttt')
// ブレードファイル内 : {{config('constMessage.xxxx.tttt')}}
//

return [
    'success' => [
        'M1001' => '保存が完了しました',
        'M1002' => '削除が完了しました',
        'M1003' => 'DBは正常に更新されました',
        'M1004' => '企業情報CSV取込完了しました',
    ],

    'error' => [
        'E1001' => '保存に失敗しました',
        'E1002' => '削除に失敗しました',
        'E1003' => 'データが見つかりませんでした',
        'E1004' => 'ログインIDとメールアドレスが一致しません',

        //CSV取込
        'E2001' => 'CSV取り込み処理中にExceptionが発生したため、DBは取り込み処理前にロールバックされました。',
        'E2002' => 'エラー発生行があるため、DBは取り込み処理前にロールバックされました。',
        'E2003' => '会社名がセットされていません',
        'E2004' => '代表者名がセットされていません',
        'E2005' => '電話番号は数値とハイフンでセットしてください',
        'E2006' => '郵便番号は正しい形式でセットして下さい',
        'E2007' => '住所は県名を含まず、市区町村からの形式でセットして下さい',
        'E2008' => 'メールアドレスが既に存在します',
        'E2009' => '会社名カナがセットされていません',
    ],

    'http' => [
        404 => 'Not Found',
    ]
];
