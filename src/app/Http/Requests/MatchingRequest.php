<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchingRequest extends FormRequest
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
            //
            'company_id' => 'required',
            'project_name' => 'required|max:100',
            'comment' => 'required|max:100',
            'project_content' => 'required',
            'category_id' => 'required',
            'status' => 'required',
            'desired_delivery_date' => 'required',
            'disp_start_date' => 'required|date_format:Y/m/d',
            'disp_end_date' => 'required|after:disp_start_date|date_format:Y/m/d',
            'responsible_name' => 'required',
            'mail' => 'required|email',
            'tel'  => 'nullable|regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/|max:50',   //電話番号
            'imageInfo.*.photo'     => 'nullable|mimes:jpg,png,jpeg|max:1024',
        ];
    }

    public function attributes()
    {
        return [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => ':attribute は1つ以上選択してください',
            'tel.regex' => ':attribute は市外局番・ハイフンありで入力してください',
        ];
    }


    /**
     * 受付期間チェック
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $startDate = $this->input('disp_start_date');
            $endDate = $this->input('disp_end_date');
            $status = $this->input('status');
            if (!isset($startDate) || !isset($endDate) || !isset($status)) {
                return;
            } else if (
                date('Y/m/d') < $startDate  && date('Y/m/d') < $endDate  && $status != config('const.matching.status.before')
            ) {
                $validator->errors()->add('field', '受付期間前は、状態は受付前に設定してください');
            } else if (
                date('Y/m/d') >= $startDate && date('Y/m/d') <= $endDate && $status != config('const.matching.status.accepting')
            ) {
                $validator->errors()->add('field', '受付期間中は、状態は受付中に設定してください');
            } else if (
                date('Y/m/d') > $startDate && date('Y/m/d') > $endDate && $status != config('const.matching.status.closed')
            ) {
                $validator->errors()->add('field', '受付期間後は、状態は受付終了に設定してください');
            }
        });
    }
}
