<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;


    // postsテーブルとpost_imagesテーブルを紐付ける  postsテーブルからpost_imagesテーブルを参照できるようにする  $postImage->post で取得したい
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
