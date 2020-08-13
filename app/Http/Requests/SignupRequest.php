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
            'password' => 'required|min:6',
            'sex' => 'required',
            'month'=>'required',
            'year'=>'required',
            'month'=>'required',
            'day'=>'required',
        ];
    }

    public function messages(){
        return [
            'name.required' => '* ニックネームが入力されていません。',
            'email.required' => '* メールアドレスが入力されていません。',
            'email.email' => '* メールアドレスを入力してください',
            'password.required' => '* パスワードを入力してください',
            'password.min' => '* 文字数が少なすぎます。',
            'sex.required' => '* 性別を選択してください。',
            'year.required'=>"* 年を選択してください。",
            'month.required'=>"* 月を選択してください。",
            'day.required'=>"* 日を選択してください。",
        ];
    }
}
