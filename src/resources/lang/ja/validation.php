<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => ':attribute は :date より後の日付で入力して下さい',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => ':attribute は日付の形式で入力して下さい',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => ':attribute は:formatの形式で入力して下さい',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => ':attribute は:min から :max 桁で入力して下さい',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attribute はメールアドレスの形式で入力して下さい',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute は :maxより大きくすることはできません',
        'file' => ':attribute は :max キロバイト以下のファイルを選択してください',
        'string' => ':attribute は :max 文字以内で入力して下さい',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => ':attribute は:valuesを選択してください',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => ':attribute は :min 文字以上で入力して下さい',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ':attribute は半角数字で入力して下さい',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => ':attribute の入力形式が正しくありません',
    'required' => ':attribute を入力して下さい',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => '指定された :attribute はすでに使用されています',
    'uploaded' => ':attribute のアップロードに失敗しました ファイルサイズを確認してください',
    'url' => ':attribute の入力形式が正しくありません',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'login_id' => 'メールアドレス(ログインID)',
        'plain_login_password' => 'パスワード',
        'mail' => 'メールアドレス',
        'password' => 'パスワード',
        'name' => '氏名',
        'name_kana' => '氏名カナ',
        'number' => 'No',
        'category_name' => 'カテゴリ名',
        'title' => 'タイトル',
        'body' => '本文',
        'status' => 'ステータス',
        'pdf' => '添付ファイル',
        'company_name'          => '会社名',
        'company_name_kana'     => '会社名カナ',
        'zip'                   => '郵便番号',
        'pref_code'             => '都道府県',
        'address'               => '住所',
        'tel'                   => '電話番号',
        'hp_url'                => 'ホームページURL',
        'representative_name'   => '代表者名',
        'responsible_name'      => '担当者名',
        'mail'                  => 'メールアドレス',
        'industry_id'           => '業種',
        'fax'                   => 'FAX番号',
        'employees_num'         => '従業員数',
        'founding_date'         => '創立年月日',
        'department'            => '担当者部署名',
        'project_name'          => '案件名',
        'comment'               => 'コメント',
        'project_content'       => '案件内容',
        'company_id'            => '会社名',
        'desired_delivery_date' => '希望納期',
        'disp_start_date'       => '受付開始日',
        'disp_end_date'         => '受付終了日',
        'responsible_name'      => '担当者名',
        'category_id'           => 'カテゴリ',
        'imageInfo.0.photo' => '画像1',
        'imageInfo.1.photo' => '画像2',
        'imageInfo.2.photo' => '画像3',
        'imageInfo.3.photo' => '画像4',
        'alt_text1' => '画像説明文1',
        'alt_text2' => '画像説明文2',
        'alt_text3' => '画像説明文3',
        'alt_text4' => '画像説明文4',
    ],

];
