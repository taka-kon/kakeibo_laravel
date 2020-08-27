<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->path() == 'page'){
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
            //ログイン
            'email' => 'required',
            'password' => 'required',

            //記録追加
            /*このエラーを増やすとemailとpassが合っていてもloginページに飛ばされる。ジャンルが入力されていないということだが、ジャンルはログインではなくユーザページの中にある。
            */
            // 'genre'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => '* メールドレスを入力してください',
            'password.required' => '* パスワードを入力してください',
            // 'genre.required'=>"* ジャンルを選択してください",
        ];
    }
}
