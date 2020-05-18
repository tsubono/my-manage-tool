<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
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
            'project_id' => 'required',
            'planned_deposit_date' => 'required|date',
            'price' => 'required',
            'sale_status_id' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required'=>':attributeは必須項目です。',
        ];
    }

    public function attributes()
    {
        return [
            'project_id'=>'案件',
            'planned_deposit_date'=>'入金予定日',
            'price'=>'金額',
            'sale_status_id'=>'ステータス',
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
