<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvRequest extends FormRequest
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
        return [
            'csv' => 'required|mimes:csv,txt',
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
            'csv.required' => 'CSVファイルを選択してください',
            'csv.mimes'    => '許可されている拡張子はCSV形式のみです',
        ];
    }

}