<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->path() == 'signup'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
    }

    public function messages(){
        return [
            'name.required' => '* ニックネームが入力されていません。',
            'email.required' => 'メールアドレスが入力されていません。',
            'email.email' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => '文字数が少なすぎます。',
        ];
    }
}
