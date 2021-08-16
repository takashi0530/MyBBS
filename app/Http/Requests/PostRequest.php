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
        // 許可されている画像拡張子
        // $uploadableFileTypes = [
        //     // 'jpg' => 'image/jpeg',
        //     'jpeg' => 'image/jpeg',
        //     'gif' => 'image/gif',
        //     'png' => 'image/png'
        // ];
        // $extensionsRule = '|mimes:'     . implode(',', array_keys($uploadableFileTypes));    // |mimes:avi,mov,mp4,webm,wmv
        // $mimeTypesRule = '|mimetypes:'  . implode(',', array_values($uploadableFileTypes));  // |mimetypes:video/x-msvideo,video/quicktime,video/mp4,video/webm,video/x-ms-wmv


        // 以下にバリデーションルールを記述する
        return [
            // タイトルは必須。最低3文字必要
            'title' => 'required|min:3',
            // 本文は必須項目
            'body' => 'required',

            // 'file.*' => 'image'
            // 'file.*' => 'mimes:jpg,jpeg,bmp,png|max:5000',
            // 'file' => 'required|mimes:jpg,gif,png',
            // 'file' => 'required' . $extensionsRule . $mimeTypesRule
            // 'file[]' =>'mimes:image',
            // 'file[*]' =>'required|mimes:image',
            // 'file[0]' =>'required|mimes:image',
            // 'file[]' =>'image|mimes:jpeg,bmp,png',
            // 'file.[*]' =>'required|mimes:image',
            // 'file' =>'required|mimes:image',
            // 'file' =>'mimetypes:image/jpeg',
        ];
    }

    // バリデーションルールを設定した場合、以下の関数も作る必要がある
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です',
            'title.min' => ':min文字以上入力してください',
            'body.required' => '本文は必須です',

            // 'file[*].required' => 'ファイルは必須です a file[*]',
            // 'file[].required' => 'ファイルは必須です a',
            // 'file.required' => 'ファイルは必須です b',
            // 'file[].mimes' => 'ファイルはjpg,gif,pngのいずれかです a' ,
            // 'file[].image' => 'ファイルはjpg,gif,pngのいずれかです a',
        ];
    }
}
