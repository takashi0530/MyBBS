<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Post -> post
class Post extends Model
{
    use HasFactory;

    // マスアサイメント（一括でデータを挿入する）をするために、値をどのカラムに挿入するかちゃんと設定する
    protected $fillable = [
        'title',
        'body',
    ];

    // リレーション設定  postsテーブルとcommentsテーブルをかんたんに操作できるようにする   （$post->comment 投稿に紐付いたコメントを取得できる）
    public function comments()
    {
        // 特定のpostに対してcommentは複数あるため hasMany    classキーワード：クラスの名前が文字列で渡される
        return $this->hasMany(Comment::class);
    }

    // リレーション設定
    public function postImage()
    {
        return $this->hasMany(PostImage::class);
    }

}
