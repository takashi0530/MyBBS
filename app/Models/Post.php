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
}
