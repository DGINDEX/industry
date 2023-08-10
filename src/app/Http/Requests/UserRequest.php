<?php

namespace App\Http\Requests;

use App\Rules\Katakana;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->id) {
            $unique = 'unique:users,login_id,' . $this->id . ',id,deleted_at,NULL';
        } else {
            $unique = 'unique:users,login_id,NULL,id,deleted_at,NULL';
        }

        return [
            'login_id' => 'required|email|max:100|' . $unique,
            'plain_login_password' => 'required|max:255|min:8|regex:/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/',
            'name' => 'required|max:100',
            'name_kana' => ['required', 'max:100', new Katakana],
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'plain_login_password.regex' => ':attribute は半角英数字で半角英小文字・半角英大文字・半角数字のそれぞれを１種類以上を含んで下さい',
        ];
    }
}
