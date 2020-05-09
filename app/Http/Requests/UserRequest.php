<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

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
        $rules = [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users,email,,,deleted_at,NULL',
            'password' => 'required|min:6'
        ];

        switch($this->method())
        {
            case 'PUT':
            case 'PATCH':
                {
                    unset($rules['password']);
                    $rules['email'] = ['required', 'email', Rule::unique('users','email')->whereNull('deleted_at')->ignore($this->id)];
                }
            default: break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required'=>':attributeは必須項目です。',
            'unique'=>'この:attributeはすでに存在しています。',
            'max'=>':attributeは:max文字以内で入力してください。',
            'min'=>':attributeは:min文字以上で入力してください。',
            'email'=>':attributeの形式として正しくありません。',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'お名前',
            'email'=>'メールアドレス',
            'password'=>'パスワード'
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
