<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class TodoRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string',
            'limit_datetime' => 'nullable|date_format:Y-m-d H:i:s',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required'=>':attributeは必須項目です。',
            'string'=>':attributeは文字列で入力してください。',
            'date_format'=>':attributeの日付形式が不正です。',
        ];
    }

    public function attributes()
    {
        return [
            'title'=>'タイトル',
            'limit_datetime'=>'期限日時',
        ];
    }

    /**
     * バリデーション失敗時
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return void
     * @throw HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors()->toArray(), 422)
        );
    }
}
