<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SaleStatusRequest extends FormRequest
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
            'statuses' => 'required|array',
            'statuses.*.name' => 'string',
            'statuses.*.color' => 'string',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required'=>':attributeは必須項目です。',
            'string'=>':attributeは文字列で入力してください。',
            'array'=>':attributeはは配列で指定してください。',
        ];
    }

    public function attributes()
    {
        return [
            'statuses'=>'ステータス',
            'statuses.*.name'=>'名称',
            'statuses.*.color'=>'色',
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
