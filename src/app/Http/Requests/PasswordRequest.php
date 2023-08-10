<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'password'         => 'required|min:8|regex:/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/',
            'password-confirm' => 'same:password'
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
            'password.required'     => 'パスワードは必須です',
            'password.min'          => 'パスワードは8文字以上で入力して下さい',
            'password.regex'        => 'パスワードは半角英数字で半角英小文字・半角英大文字・半角数字のそれぞれを１種類以上を含んで下さい',
            'password-confirm.same' => '確認用パスワードが一致しません'
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
            'password'         => 'パスワード',
            'password-confirm' => '確認用パスワード',
        ];
    }
}
