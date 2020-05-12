<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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
            'name' => 'required|max:100',
            'client_id' => 'required',
            'status_id' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required'=>':attributeは必須項目です。',
            'integer'=>':attributeは数値で入力してください。',
            'max'=>':attributeは:max文字以内で入力してください。',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'名前',
            'client_id'=>'取引先',
            'status_id'=>'ステータス',
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
