<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'login_id' => 'required|email',
            'send_mail'     => 'required|email',
        ];
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'login_id.required'      => ':attribute は必須です',
            'login_id.email'         => ':attribute の形式が正しくありません',
            'send_mail.required'     => ':attribute は必須です',
            'send_mail.email'        => ':attribute の形式が正しくありません',
        ];
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'login_id' => 'ログインID',
            'send_mail'     => '送信先メールアドレス',
        ];
    }
}
