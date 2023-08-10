<?php

namespace App\Http\Requests;

use App\Rules\Katakana;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            $unique = 'unique:users,login_id,' . $this->user_id . ',id,deleted_at,NULL';
        } else {
            $unique = 'unique:users,login_id,NULL,id,deleted_at,NULL';
        }

        return [
            'company_name'          => 'required|max:100',
            'company_name_kana'     => ['required', 'max:100', new Katakana],
            'login_id'              => 'required|email|max:100|' . $unique,  //ログイン用メールアドレス
            'plain_login_password'  => 'required|max:255|min:8|regex:/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/',
            'status'                => 'required',
            'zip'                   => 'required|max:8|regex:/^\d{3}\-\d{4}$/',
            'pref_code'             => 'required|digits_between:1,2',   //都道府県コード
            'address'               => 'required|max:255',   //住所
            'tel'                   => 'required|regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/|max:50',   //電話番号
            'fax'                   => 'nullable|regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/|max:50',   //FAX番号
            'hp_url'                => 'nullable|url',   //ホームページURL
            'representative_name'   => 'required|max:100',   //代表者名
            'employees_num'         => 'nullable|numeric|digits_between:1,10',   //従業員数
            'founding_date'         => 'nullable|date_format:Y/m/d',   //創立年月日
            'industry_id'           => 'required',   //業種
            'category_id'           => 'required',   //カテゴリ
            'responsible_name'      => 'required|max:100',   //担当者名
            'department'            => 'nullable|max:100',   //担当者部署名
            'mail'                  => 'required|email|max:100',   //お問い合わせ用メールアドレス
            'imageInfo.*.photo'     => 'nullable|mimes:jpg,png,jpeg|max:1024',
        ];
    }

    public function attributes()
    {
        return [
            'login_id' => 'ログイン用メールアドレス',
            'mail' => 'お問い合わせ用メールアドレス',
        ];
    }

    public function messages()
    {
        return [

            'plain_login_password.regex' => ':attribute は半角英数字で半角英小文字・半角英大文字・半角数字のそれぞれを１種類以上を含んで下さい',
            'category_id.required' => ':attribute は1つ以上選択してください',
            'tel.regex' => ':attribute は市外局番・ハイフンありで入力してください',
            'fax.regex' => ':attribute は市外局番・ハイフンありで入力してください',
        ];
    }
}
