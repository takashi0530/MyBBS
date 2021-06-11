<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // ユーザー管理をして機能制限をしたいときにつかう → 今回は使わないので return falseからtrueにする
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
        // 以下にバリデーションルールを記述する
        return [
            // タイトルは必須。最低3文字必要
            'title' => 'required|min:3',
            // 本文は必須項目
            'body' => 'required'
        ];
    }

    // バリデーションルールを設定した場合、以下の関数も作る必要がある
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です',
            'title.min' => ':min文字以上入力してください',
            'body.required' => '本文は必須です'
        ];
    }
}
